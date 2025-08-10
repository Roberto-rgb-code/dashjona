<!doctype html>
<html lang="es" class="h-full" x-data="{dark: localStorage.getItem('dark')==='1'}" x-init="$watch('dark', v=>localStorage.setItem('dark', v?'1':'0'))" x-bind:class="dark ? 'dark' : ''">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? 'Dashboard' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>.card{ @apply rounded-2xl shadow-md p-5 bg-white dark:bg-slate-900 dark:text-slate-100; }</style>
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950">
  <div class="max-w-7xl mx-auto p-4">
    <header class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-semibold">{{ $title ?? 'Dashboard' }}</h1>
      <div class="flex items-center gap-2">
        <input type="date" id="from" value="{{ $from ?? '' }}" class="border rounded px-2 py-1">
        <input type="date" id="to" value="{{ $to ?? '' }}" class="border rounded px-2 py-1">
        <button id="apply" class="px-3 py-1 rounded-lg bg-slate-900 text-white dark:bg-slate-100 dark:text-slate-900">Aplicar</button>
        <button @click="dark=!dark" class="px-3 py-1 rounded-lg border">🌙/☀️</button>
      </div>
    </header>

    {{ $slot }}
  </div>

  <script>
    document.getElementById('apply')?.addEventListener('click', ()=>{
      const params = new URLSearchParams(window.location.search)
      const f=document.getElementById('from').value; const t=document.getElementById('to').value;
      if(f) params.set('from', f); else params.delete('from');
      if(t) params.set('to', t); else params.delete('to');
      window.location.search = params.toString();
    })
  </script>
</body>
</html>