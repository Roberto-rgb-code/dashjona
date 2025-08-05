@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background: #f8fafc; }
.sidebar {
  height: 100vh; min-height:100vh; background: #232946;
  color: #fff; position: fixed; left: 0; top: 0; width: 220px; z-index: 10;
  transition: all 0.3s;
}
.sidebar .nav-link, .sidebar .navbar-brand {
  color: #fff; font-weight: 500; letter-spacing: .5px;
}
.sidebar .nav-link.active, .sidebar .nav-link:hover {
  background: #394867; border-radius: .75rem;
}
.main-content {
  margin-left: 220px; padding: 2rem 1rem 1rem 1rem;
  transition: all 0.3s;
}
.header {
  position: sticky; top: 0; background: #fff; z-index: 99; border-bottom: 1px solid #e5e7eb; padding: .75rem 0 .75rem 0;
  margin-bottom: 2rem;
}
.card { border-radius: 1.5rem; }
.chart-title { margin-top: 2rem; margin-bottom:1rem;}
@media (max-width: 991px) {
  .sidebar { width: 64px; }
  .sidebar .nav-link span,
  .sidebar .navbar-brand span { display: none; }
  .main-content { margin-left: 64px; }
}
@media (max-width: 576px) {
  .main-content { padding-left: .3rem; padding-right: .3rem;}
  .sidebar { display:none;}
}
</style>

<div class="sidebar d-flex flex-column py-3 shadow-sm">
    <a class="navbar-brand mb-3 d-flex align-items-center gap-2 px-3" href="#">
        <i class="bi bi-graph-up fs-3"></i> <span>Data Dashboard</span>
    </a>
    <nav class="nav flex-column px-2">
        <a class="nav-link active mb-1" href="#kpis"><i class="bi bi-speedometer2 me-2"></i> <span>Resumen</span></a>
        <a class="nav-link mb-1" href="#usuarios"><i class="bi bi-person-lines-fill me-2"></i> <span>Usuarios</span></a>
        <a class="nav-link mb-1" href="#prestamos"><i class="bi bi-cash-coin me-2"></i> <span>Préstamos</span></a>
        <a class="nav-link mb-1" href="#inversiones"><i class="bi bi-piggy-bank me-2"></i> <span>Inversiones</span></a>
        <a class="nav-link mb-1" href="#articulos"><i class="bi bi-box-seam me-2"></i> <span>Artículos</span></a>
        <a class="nav-link mb-1" href="#mapa"><i class="bi bi-geo-alt-fill me-2"></i> <span>Mapa</span></a>
    </nav>
</div>

<div class="main-content">
  <div class="header bg-white d-flex align-items-center justify-content-between shadow-sm px-4 rounded-3 mb-3">
      <h1 class="mb-0 fw-bold text-primary" style="letter-spacing:1px;">Dashboard Ciencia de Datos</h1>
      <span class="text-muted d-none d-md-block">Powered by Laravel</span>
  </div>

  <!-- KPIs -->
  <div class="row g-4 mb-4" id="kpis">
    <div class="col-lg-3 col-6">
      <div class="card shadow p-3 text-center">
        <div class="text-muted mb-1"><i class="bi bi-people-fill me-1"></i> Usuarios</div>
        <div class="display-5 fw-bold text-success">{{ $usersCount }}</div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="card shadow p-3 text-center">
        <div class="text-muted mb-1"><i class="bi bi-cash-coin me-1"></i> Préstamos</div>
        <div class="display-5 fw-bold text-primary">{{ $loansCount }}</div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="card shadow p-3 text-center">
        <div class="text-muted mb-1"><i class="bi bi-shop-window me-1"></i> Productos</div>
        <div class="display-5 fw-bold text-warning">{{ $productsCount }}</div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="card shadow p-3 text-center">
        <div class="text-muted mb-1"><i class="bi bi-buildings me-1"></i> Compañías</div>
        <div class="display-5 fw-bold text-info">{{ $companiesCount }}</div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-7">
      <!-- Usuarios por estado -->
      <h2 class="chart-title" id="usuarios">Usuarios por Estado</h2>
      <div class="card p-3 mb-4 shadow-sm">
        <canvas id="usersStateChart" height="60"></canvas>
      </div>
      <!-- Préstamos por año -->
      <h2 class="chart-title" id="prestamos">Préstamos por Año</h2>
      <div class="card p-3 mb-4 shadow-sm">
        <canvas id="loansChart" height="60"></canvas>
      </div>
      <!-- Prospectos por Estado -->
      <h2 class="chart-title">Prospectos por Estado</h2>
      <div class="card p-3 mb-4 shadow-sm">
        <canvas id="prospectChart" height="60"></canvas>
      </div>
      <!-- Inversiones por compañía -->
      <h2 class="chart-title" id="inversiones">Inversiones por Compañía</h2>
      <div class="card p-3 mb-4 shadow-sm">
        <canvas id="investChart" height="60"></canvas>
      </div>
    </div>
    <div class="col-lg-5">
      <!-- Pagos próximos -->
      <h2 class="chart-title">Pagos próximos (30 días)</h2>
      <div class="card p-3 mb-4 shadow-sm">
        <canvas id="paymentChart" height="50"></canvas>
      </div>
      <!-- Regresión productos -->
      <h2 class="chart-title">Regresión: Monto Mínimo vs Tasa Anual</h2>
      <div class="card p-3 mb-4 shadow-sm">
        <canvas id="productRegChart" height="50"></canvas>
      </div>
      <!-- Artículos por tipo -->
      <h2 class="chart-title" id="articulos">Artículos por Tipo</h2>
      <div class="card p-3 mb-4 shadow-sm">
        <canvas id="articlesTypeChart" height="50"></canvas>
      </div>
      <!-- Garantías por tipo -->
      <h2 class="chart-title">Garantías por Tipo</h2>
      <div class="card p-3 mb-4 shadow-sm">
        <canvas id="guaranteesTypeChart" height="50"></canvas>
      </div>
    </div>
  </div>

  <!-- Referencias comerciales por actividad -->
  <h2 class="chart-title">Principales Referencias Comerciales</h2>
  <div class="card p-3 mb-4 shadow-sm">
    <canvas id="referencesChart" height="60"></canvas>
  </div>

  <!-- Ingresos promedio finanzas -->
  <h2 class="chart-title">Ingreso Promedio Declarado (Finanzas)</h2>
  <div class="row mb-3">
    <div class="col-md-6 text-center">
      <div class="card shadow p-3 mb-3">
        <div class="fw-semibold mb-2 text-secondary">Ingreso Actual</div>
        <div class="display-6 fw-bold text-primary">${{ number_format($financeIncome->avg_current,2) }}</div>
      </div>
    </div>
    <div class="col-md-6 text-center">
      <div class="card shadow p-3 mb-3">
        <div class="fw-semibold mb-2 text-secondary">Ingreso Anterior</div>
        <div class="display-6 fw-bold text-info">${{ number_format($financeIncome->avg_previous,2) }}</div>
      </div>
    </div>
  </div>

  <!-- Mapa de usuarios -->
  <h2 class="chart-title" id="mapa">Ubicación de Usuarios</h2>
  <div class="card p-3 mb-4 shadow-sm">
    <div id="map" style="height:340px;"></div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script>
// Usuarios por Estado
new Chart(document.getElementById('usersStateChart'),{
    type:'bar',
    data:{
      labels:@json($usersByState->pluck('state')),
      datasets:[{
        label:'Usuarios',
        data:@json($usersByState->pluck('total')),
        backgroundColor:'rgba(75,192,192,0.5)'
      }]
    }
});
// Préstamos por Año
new Chart(document.getElementById('loansChart'),{
    type:'line',
    data:{
      labels:@json($loansYear->pluck('year')),
      datasets:[{
        label:'Préstamos',
        data:@json($loansYear->pluck('total')),
        fill:true,
        borderColor:'#3b82f6',
        backgroundColor:'rgba(59,130,246,0.2)'
      }]
    }
});
// Prospectos por Estado
new Chart(document.getElementById('prospectChart'),{
    type:'pie',
    data:{
      labels:@json($prospects->pluck('status')),
      datasets:[{
        data:@json($prospects->pluck('total')),
        backgroundColor:['#22c55e','#fbbf24','#ef4444','#6366f1','#f472b6']
      }]
    }
});
// Pagos próximos
new Chart(document.getElementById('paymentChart'),{
    type:'bar',
    data:{
      labels:@json($payments->pluck('payment_date')),
      datasets:[{
        label:'Total Pago',
        data:@json($payments->pluck('total_payment')),
        backgroundColor:'#4ade80'
      }]
    }
});
// Inversiones por compañía
new Chart(document.getElementById('investChart'),{
    type:'bar',
    data:{
      labels:@json($investByCompany->pluck('company')),
      datasets:[{
        label:'Inversiones',
        data:@json($investByCompany->pluck('total')),
        backgroundColor:'#a78bfa'
      }]
    }
});
// Regresión products (scatter + ajuste lineal)
new Chart(document.getElementById('productRegChart'),{
  type:'scatter',
  data:{
      datasets:[
        {label:'Datos',data:@json($prodSamples), backgroundColor:'#6c757d'},
        {label:'Ajuste',type:'line',fill:false,data:@json($prodFit), borderColor:'#007bff'}
      ]
  }
});
// Artículos por tipo
new Chart(document.getElementById('articlesTypeChart'),{
    type:'bar',
    data:{
      labels:@json($articlesByType->pluck('article_type')),
      datasets:[{
        label:'Artículos',
        data:@json($articlesByType->pluck('total')),
        backgroundColor:'#fde68a'
      }]
    }
});
// Garantías por tipo
new Chart(document.getElementById('guaranteesTypeChart'),{
    type:'bar',
    data:{
      labels:@json($guaranteesByType->pluck('guarantee_type')),
      datasets:[{
        label:'Garantías',
        data:@json($guaranteesByType->pluck('total')),
        backgroundColor:'#60a5fa'
      }]
    }
});
// Referencias comerciales por actividad
new Chart(document.getElementById('referencesChart'),{
    type:'bar',
    data:{
      labels:@json($comReferences->pluck('business_activity')),
      datasets:[{
        label:'Referencias',
        data:@json($comReferences->pluck('total')),
        backgroundColor:'#f472b6'
      }]
    }
});
// Mapa Leaflet
const map = L.map('map').setView([23.6345,-102.5528],5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
@foreach($points as $p)
  L.marker([parseFloat('{{ $p->latitude }}'),parseFloat('{{ $p->longitude }}')])
    .bindPopup('{{$p->first_name}}')
    .addTo(map);
@endforeach
</script>
@endsection
