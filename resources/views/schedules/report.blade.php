@extends('layouts.app')
@section('title', 'Isi Laporan Pemeriksaan')
@section('content')

<div class="panel" style="max-width:720px;">
  <h3 class="panel-title">{{ $schedule->machine->name }} — {{ $schedule->jenis }}</h3>
  <p style="color:var(--ink-soft);font-size:12.5px;">Jadwal: <span class="mono">{{ $schedule->tanggal->format('d M Y') }}</span></p>

  <form method="POST" action="{{ route('reports.store', $schedule) }}">
    @csrf
    <div class="form-grid">
      <div class="field"><label>Kategori Pekerjaan</label>
        <select name="kategori" required>
          <option value="mekanik">Mekanik</option>
          <option value="elektrik">Elektrik</option>
          <option value="instrumentasi">Instrumentasi</option>
        </select>
      </div>
      <div class="field"><label>Downtime (menit)</label><input type="number" name="downtime_menit" min="0" required></div>
      <div class="field full"><label>Deskripsi Temuan</label><textarea name="deskripsi_temuan" required></textarea></div>
      <div class="field full"><label>Tindakan yang Dilakukan</label><textarea name="tindakan" required></textarea></div>
      <div class="field full"><label>Rekomendasi (opsional)</label><textarea name="rekomendasi"></textarea></div>
    </div>

    <h4>Sparepart Digunakan (opsional)</h4>
    <div id="sparepartRows"></div>
    <button type="button" class="btn btn-sm" onclick="addSparepartRow()">+ Tambah Baris</button>

    <div class="form-actions">
      <a class="btn" href="{{ route('schedules.index') }}">Batal</a>
      <button class="btn btn-primary" type="submit">Kirim untuk Validasi</button>
    </div>
  </form>
</div>

<script>
let spIndex = 0;
function addSparepartRow(){
  const wrap = document.createElement('div');
  wrap.className = 'form-grid';
  wrap.style.marginBottom = '8px';
  wrap.innerHTML = `
    <div class="field"><label>Nama Sparepart</label><input type="text" name="spareparts[${spIndex}][nama]"></div>
    <div class="field"><label>Jumlah</label><input type="number" step="0.01" name="spareparts[${spIndex}][jumlah]"></div>
    <div class="field"><label>Satuan</label><input type="text" name="spareparts[${spIndex}][satuan]" placeholder="pcs / liter / kg"></div>
  `;
  document.getElementById('sparepartRows').appendChild(wrap);
  spIndex++;
}
</script>
@endsection
