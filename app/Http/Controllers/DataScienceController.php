<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DataScienceController extends Controller
{
    public function index()
    {
        // KPIs rápidos
        $usersCount    = DB::table('tbl_users')->count();
        $loansCount    = DB::table('loans')->count();
        $productsCount = DB::table('products')->count();
        $companiesCount= DB::table('tbl_companies')->count();

        // Usuarios por estado
        $usersByState = DB::table('tbl_user_data')
            ->select('state', DB::raw('COUNT(*) as total'))
            ->whereNotNull('state')
            ->groupBy('state')
            ->orderByDesc('total')
            ->get();

        // Préstamos por año
        $loansYear = DB::table('loans')
            ->select(DB::raw('YEAR(applicationDate) as year'), DB::raw('COUNT(*) as total'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // Estado de loan prospects
        $prospects = DB::table('loan_prospects')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // Pagos próximos (30 días)
        $today    = now()->toDateString();
        $future   = now()->addDays(30)->toDateString();
        $payments = DB::table('payment_schedule')
            ->whereBetween('payment_date', [$today, $future])
            ->orderBy('payment_date')
            ->get(['payment_date','total_payment']);

        // Inversiones por compañía
        $investByCompany = DB::table('tbl_investments')
            ->join('tbl_companies', 'tbl_investments.id_company', '=', 'tbl_companies.id_company')
            ->select('tbl_companies.name as company', DB::raw('COUNT(*) as total'))
            ->groupBy('tbl_companies.name', 'tbl_investments.id_company')
            ->orderByDesc('total')
            ->get();

        // Regresión: mínimo vs tasa anual
        $products = DB::table('products')
            ->whereNotNull('minimumAmount')
            ->whereNotNull('annualInterest')
            ->get(['minimumAmount','annualInterest']);
        $samples = [];
        $targets = [];
        foreach ($products as $p) {
            $samples[] = [(float)$p->minimumAmount];
            $targets[] = (float)$p->annualInterest;
        }
        // Simula regresión lineal sencilla
        $preds = [];
        if (count($samples) > 1) {
            $meanX = array_sum(array_column($samples,0))/count($samples);
            $meanY = array_sum($targets)/count($targets);
            $num=0; $den=0;
            foreach ($samples as $i => $s) {
                $num += ($s[0]-$meanX)*($targets[$i]-$meanY);
                $den += pow($s[0]-$meanX,2);
            }
            $b = ($den==0)?0:$num/$den;
            $a = $meanY-$b*$meanX;
            foreach ($samples as $s) {
                $preds[] = $a + $b*$s[0];
            }
        }
        $prodSamples = [];
        $prodFit = [];
        foreach ($samples as $i => $s) {
            $prodSamples[] = ["x" => $s[0], "y" => $targets[$i] ?? null];
            $prodFit[]     = ["x" => $s[0], "y" => $preds[$i] ?? null];
        }

        // Ubicaciones de usuarios (para mapa)
        $points = DB::table('tbl_user_data')
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->get(['latitude','longitude','first_name']);

        // Artículos por tipo
        $articlesByType = DB::table('tbl_articles')
            ->select('article_type', DB::raw('COUNT(*) as total'))
            ->whereNotNull('article_type')
            ->groupBy('article_type')
            ->orderByDesc('total')
            ->get();

        // Garantías por tipo
        $guaranteesByType = DB::table('tbl_se_guarantees')
            ->select('guarantee_type', DB::raw('COUNT(*) as total'))
            ->whereNotNull('guarantee_type')
            ->groupBy('guarantee_type')
            ->orderByDesc('total')
            ->get();

        // Referencias comerciales por actividad
        $comReferences = DB::table('tbl_se_commercial_references')
            ->select('business_activity', DB::raw('COUNT(*) as total'))
            ->whereNotNull('business_activity')
            ->groupBy('business_activity')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Ingresos promedio de finanzas
        $financeIncome = DB::table('tbl_se_finances')
            ->select(DB::raw('AVG(CAST(current_income as DECIMAL(12,2))) as avg_current'), DB::raw('AVG(CAST(previous_income as DECIMAL(12,2))) as avg_previous'))
            ->first();

        return view('dashboard', compact(
            'usersCount', 'loansCount', 'productsCount', 'companiesCount',
            'usersByState', 'loansYear', 'prospects', 'payments', 'investByCompany',
            'prodSamples', 'prodFit', 'points', 'articlesByType',
            'guaranteesByType', 'comReferences', 'financeIncome'
        ));
    }
}
