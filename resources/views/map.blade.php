@extends('layouts.app')

@section('content')
  <div id="map" style="height:500px"></div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  const map = L.map('map').setView([23.6345,-102.5528],5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
  @foreach($points as $p)
    L.marker([parseFloat('{{ $p->latitude }}'), parseFloat('{{ $p->longitude }}')]).addTo(map);
  @endforeach
</script>
@endsection
