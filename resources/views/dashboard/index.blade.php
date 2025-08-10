@extends('layouts.app', ['title' => 'Microfinanzas — Dashboard'])

@section('content')
@php
  $k = $kpis;
@endphp
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
  <div class="card"><div class="text-sm text-slate-500">Préstamos</div><div class="text-2xl font-bold">{{ number_format($k['total_count']) }}</div></div>
  <div class="card"><div class="text-sm text-slate-500">Cartera Colocada</div><div class="text-2xl font-bold">$ {{ number_format($k['colocada'],2) }}</div></div>
  <div class="card"><div class="text-sm text-slate-500">Tasa Aprobación</div><div class="text-2xl font-bold">{{ $k['tasa_aprob'] }}%</div></div>
  <div class="card"><div class="text-sm text-slate-500">Entrega de Recursos</div><div class="text-2xl font-bold">{{ $k['tasa_entrega'] }}%</div></div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
  <div class="card">
    <h3 class="font-semibold mb-2">Cobranzas Semanales & Pronóstico</h3>
    <canvas id="s1"></canvas>
  </div>
  <div class="card">
    <h3 class="font-semibold mb-2">Préstamos por Estatus</h3>
    <canvas id="pie1"></canvas>
  </div>

  <div class="card">
    <h3 class="font-semibold mb-2">Préstamos por Producto</h3>
    <canvas id="bar1"></canvas>
  </div>
  <div class="card">
    <h3 class="font-semibold mb-2">Mapa de Rutas/Visitas</h3>
    <div id="map" style="height:420px;border-radius:1rem;"></div>
  </div>
</div>

<script>
  // Datos inyectados
  const weekly = @json($weekly);
  const fitted = @json($reg['fitted']);
  const forecast = @json($reg['forecast']);
  const porStatus = @json($porStatus);
  const porProducto = @json($porProducto);
  const rutas = @json($rutas);

  // Serie tiempo + pronóstico
  const s1 = document.getElementById('s1');
  const labels = weekly.map(p=>p.date).concat(forecast.map(p=>p.date));
  const real = weekly.map(p=>p.value);
  const fit = fitted.map(p=>p.value);
  const fc = Array(weekly.length).fill(null).concat(forecast.map(p=>p.value));

  new Chart(s1, {
    type:'line',
    data:{
      labels,
      datasets:[
        {label:'Real', data: real, tension:0.25},
        {label:'Tendencia (OLS)', data: fit, borderDash:[5,5], tension:0.25},
        {label:'Pronóstico (+12 sem.)', data: fc, borderWidth:2, borderDash:[2,2], tension:0.25}
      ]
    },
    options:{ responsive:true, plugins:{legend:{position:'bottom'}} }
  });

  // Pie por estatus
  const pie1 = document.getElementById('pie1');
  new Chart(pie1, {
    type:'doughnut',
    data:{ labels: porStatus.map(r=>r.status||'N/D'), datasets:[{ data: porStatus.map(r=>r.n) }] },
    options:{ plugins:{legend:{position:'bottom'}} }
  });

  // Barras por producto
  const bar1 = document.getElementById('bar1');
  new Chart(bar1, {
    type:'bar',
    data:{ labels: porProducto.map(r=>r.producto||'N/D'), datasets:[{ label:'Monto', data: porProducto.map(r=>r.monto) }] },
    options:{ plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}} }
  });

  // Leaflet Map
  const map = L.map('map').setView([23.6,-102.55], 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
  const pts = rutas.filter(p=>p.latitud && p.longitud);
  pts.forEach(p=>{
    const lat = parseFloat(p.latitud); const lon = parseFloat(p.longitud);
    if (!isNaN(lat) && !isNaN(lon)) {
      L.circleMarker([lat,lon],{radius:4}).addTo(map).bindPopup(`<b>Prioridad:</b> ${p.prioridad||''}<br>${p.observaciones||''}`);
    }
  });
  </script>
@endsection