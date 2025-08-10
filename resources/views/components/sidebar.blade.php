<aside class="hidden md:block w-64 mr-4">
  <div class="card sticky top-4">
    <div class="font-semibold mb-2">Filtros</div>
    <div class="space-y-2 text-sm">
      <label class="block">Fecha desde
        <input type="date" id="from2" class="border rounded w-full px-2 py-1">
      </label>
      <label class="block">Fecha hasta
        <input type="date" id="to2" class="border rounded w-full px-2 py-1">
      </label>
      <button class="mt-2 w-full px-3 py-1 rounded-lg bg-slate-900 text-white" onclick="apply2()">Aplicar</button>
    </div>
  </div>
</aside>
<script>
function apply2(){
  const f=document.getElementById('from2').value; const t=document.getElementById('to2').value;
  const params = new URLSearchParams(window.location.search)
  if(f) params.set('from', f); else params.delete('from');
  if(t) params.set('to', t); else params.delete('to');
  window.location.search = params.toString();
}
</script>