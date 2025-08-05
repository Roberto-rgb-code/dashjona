@extends('layouts.app')

@section('content')
  <ul>
    <li>Media: {{ number_format($mean,2) }}</li>
    <li>Mediana: {{ number_format($median,2) }}</li>
    <li>Desviación estándar: {{ number_format($std,2) }}</li>
  </ul>
@endsection
