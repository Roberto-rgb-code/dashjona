@extends('layouts.app')

@section('content')
  <canvas id="regChart"></canvas>
  <p>Coeficientes: a = {{ $coef[0] }}@if(isset($coef[1])), b = {{ $coef[1] }}@endif</p>
@endsection

@section('scripts')
<script>
  const pts = @json(array_map(fn($i)=>({ x: $samples[$i][0], y: $targets[$i] }), range(0, count($samples)-1)));
  const fit = @json(array_map(fn($i)=>({ x: $samples[$i][0], y: $predictions[$i] }), range(0, count($samples)-1)));
  new Chart(document.getElementById('regChart'), {
    type: 'scatter',
    data: { datasets: [
      { label:'Datos', data: pts },
      { label:'Ajuste', type:'line', fill:false, data: fit }
    ]}
  });
</script>
@endsection
map.blade.phpmap.blade.php