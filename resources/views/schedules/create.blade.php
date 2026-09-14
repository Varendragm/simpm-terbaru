@extends('layouts.app')
@section('title', 'Tambah Jadwal Preventive')
@section('content')

<div class="panel" style="max-width:640px;">
  <form method="POST" action="{{ route('schedules.store') }}">
    @csrf
    <div class="form-grid">
      <div class="field"><label>Stasiun</label>
        <select id="jt_station" onchange="loadMachines(this.value)">
          <option value="">Pilih Stasiun</option>
          @foreach($stations as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
        </select>
      </div>
      <div class="field"><label>Mesin</label>
        <select name="machine_id" id="jt_machine" required><option value="">Pilih Stasiun dahulu</option></select>
      </div>
      <div class="field full"><label>Jenis Pemeriksaan/PM</label><input type="text" name="jenis" required placeholder="mis. Pemeriksaan Rutin Bulanan"></div>
      <div class="field"><label>Teknisi Pelaksana</label>
        <select name="technician_id" required>
          <option value="">Pilih Teknisi</option>
          @foreach($teknisi as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach
        </select>
      </div>
      <div class="field"><label>Tanggal</label><input type="date" name="tanggal" required></div>
      <div class="field"><label>Interval Pengulangan (hari)</label><input type="number" name="interval_hari" min="0"></div>
      <div class="field"><label>Prioritas</label>
        <select name="prioritas">
          <option value="rendah">Rendah</option>
          <option value="sedang" selected>Sedang</option>
          <option value="tinggi">Tinggi</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <a class="btn" href="{{ route('schedules.index') }}">Batal</a>
      <button class="btn btn-primary" type="submit">Simpan Jadwal</button>
    </div>
  </form>
</div>

<script>
function loadMachines(stationId){
  const sel = document.getElementById('jt_machine');
  sel.innerHTML = '<option value="">Memuat...</option>';
  if(!stationId){ sel.innerHTML = '<option value="">Pilih Stasiun dahulu</option>'; return; }
  fetch('/master/stasiun/' + stationId + '/mesin')
    .then(r => r.json())
    .then(list => {
      sel.innerHTML = '<option value="">Pilih Mesin</option>' +
        list.map(m => `<option value="${m.id}">${m.name} (${m.code})</option>`).join('');
    });
}
</script>
@endsection
