<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AnalyticsService;
use App\Models\Prestamo;
use App\Models\Abono;
use App\Models\Producto;
use App\Models\StatusPrestamo;
use App\Models\DetalleRuta;

class DashboardController extends Controller
{
    public function index(Request $request, AnalyticsService $analytics)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $kpis = $analytics->kpis($from,$to);
        $weekly = $analytics->weeklyCollections($from,$to);
        $reg = $analytics->regressionAndForecast($weekly, 12);

        $porStatus = Prestamo::selectRaw('sp.status_prestamo as status, COUNT(*) as n, SUM(cantidad) as monto')
            ->join('tbl_status_prestamo as sp','sp.id_status_prestamo','=','tbl_prestamos.id_status_prestamo')
            ->when($from, fn($q)=>$q->whereDate('fecha_solicitud','>=',$from))
            ->when($to, fn($q)=>$q->whereDate('fecha_solicitud','<=',$to))
            ->groupBy('sp.status_prestamo')
            ->orderByDesc('n')
            ->get();

        $porProducto = Prestamo::selectRaw('p.producto, COUNT(*) as n, SUM(cantidad) as monto')
            ->leftJoin('tbl_productos as p','p.id_producto','=','tbl_prestamos.id_producto')
            ->when($from, fn($q)=>$q->whereDate('fecha_solicitud','>=',$from))
            ->when($to, fn($q)=>$q->whereDate('fecha_solicitud','<=',$to))
            ->groupBy('p.producto')
            ->get();

        $rutas = DetalleRuta::select('latitud','longitud','prioridad','observaciones')
            ->whereNotNull('latitud')->whereNotNull('longitud')->limit(2000)->get();

        return view('dashboard.index', compact('kpis','weekly','reg','porStatus','porProducto','rutas','from','to'));
    }

    // API JSON para usar desde Chart.js (si prefieres)
    public function series(Request $request, AnalyticsService $analytics)
    {
        $weekly = $analytics->weeklyCollections($request->query('from'), $request->query('to'));
        $reg = $analytics->regressionAndForecast($weekly, 12);
        return response()->json(['weekly'=>$weekly,'reg'=>$reg]);
    }
}