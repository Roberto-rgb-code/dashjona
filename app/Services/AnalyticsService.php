<?php
namespace App\Services;

use App\Models\Abono;
use App\Models\Prestamo;
use Carbon\Carbon;
use MathPHP\Statistics\Regression\Linear as LinearRegression;

class AnalyticsService
{
    /** Series semanal de cobranzas (sum(cantidad)) */
    public function weeklyCollections($from = null, $to = null): array
    {
        $q = Abono::query();
        if ($from) { $q->whereDate('fecha_pago','>=',$from); }
        if ($to) { $q->whereDate('fecha_pago','<=',$to); }

        $rows = $q->selectRaw("
                YEARWEEK(fecha_pago, 3) AS yw,
                DATE_FORMAT(DATE_SUB(DATE(fecha_pago), INTERVAL WEEKDAY(fecha_pago) DAY), '%Y-%m-%d') AS week_start,
                SUM(cantidad) AS total
            ")
            ->groupBy('yw','week_start')
            ->orderBy('week_start')
            ->get();

        return $rows->map(fn($r) => [
            'date'  => $r->week_start,
            'value' => (float) $r->total,
        ])->values()->all();
    }

    /** Regresión lineal simple y pronóstico n pasos */
    public function regressionAndForecast(array $series, int $horizon = 8): array
    {
        $y = array_map(fn($p)=>$p['value'], $series);
        $x = range(1, count($y));
        if (count($y) < 3) return ['coeffs'=>null,'fitted'=>$series,'forecast'=>[]];

        $reg = new LinearRegression($x, $y); // y = a + b x
        $a = $reg->getIntercept();
        $b = $reg->getSlope();

        $fitted = [];
        foreach ($x as $i) {
            $fitted[] = ['date'=>$series[$i-1]['date'], 'value'=>$a + $b*$i];
        }

        $forecast = [];
        $last = end($series)['date'];
        $lastDate = Carbon::parse($last);
        for ($k = 1; $k <= $horizon; $k++) {
            $idx = count($x) + $k;
            $forecast[] = [
                'date' => $lastDate->copy()->addWeeks($k)->toDateString(),
                'value' => $a + $b*$idx
            ];
        }

        return [
            'coeffs' => ['intercept'=>$a,'slope'=>$b],
            'fitted' => $fitted,
            'forecast' => $forecast
        ];
    }

    /** KPIs rápidos */
    public function kpis($from = null, $to = null): array
    {
        $prestamos = Prestamo::query();
        if ($from) $prestamos->whereDate('fecha_solicitud','>=',$from);
        if ($to) $prestamos->whereDate('fecha_solicitud','<=',$to);

        $total_count = (clone $prestamos)->count();
        $colocada = (clone $prestamos)->sum('cantidad');
        $aprobados = (clone $prestamos)->whereHas('status', fn($q)=>$q->where('status_prestamo','LIKE','%Aprob%'))->count();
        $entregados = (clone $prestamos)->whereNotNull('fecha_entrega_recurso')->count();
        $tasa_aprob = $total_count ? round($aprobados/$total_count*100,2) : 0;
        $tasa_entrega = $total_count ? round($entregados/$total_count*100,2) : 0;

        return compact('total_count','colocada','tasa_aprob','tasa_entrega');
    }
}
