@extends('layouts.app')
@section('title', 'Detail Validasi')
@section('content')

<div class="panel" style="max-width:720px;">
  <h3 class="panel-title">{{ $schedule->machine->name }} — {{ $schedule->jenis }}</h3>
  <p style="font-size:12.5px;color:var(--ink-soft);">Teknisi: {{ optional($schedule->technician)->name }} · Tanggal jadwal: <span class="mono">{{ $schedule->tanggal->format('d M Y') }}</span></p>

  @if($schedule->report)
    <p><strong>Kategori:</strong> {{ ucfirst($schedule->report->kategori) }}</p>
    <p><strong>Deskripsi Temuan:</strong> {{ $schedule->report->deskripsi_temuan }}</p>
    <p><strong>Tindakan:</strong> {{ $schedule->report->tindakan }}</p>
    @if($schedule->report->rekomendasi)<p><strong>Rekomendasi:</strong> {{ $schedule->report->rekomendasi }}</p>@endif
    <p><strong>Downtime:</strong> <span class="mono">{{ $schedule->report->downtime_menit }} menit</span></p>
    @if($schedule->report->spareparts->count())
      <p><strong>Sparepart digunakan:</strong></p>
      <ul class="mini-list">
        @foreach($schedule->report->spareparts as $sp)
          <li>{{ $sp->nama }} <span class="mono">{{ rtrim(rtrim(number_format($sp->jumlah,2),'0'),'.') }} {{ $sp->satuan }}</span></li>
        @endforeach
      </ul>
    @endif
  @else
    <p class="empty-state">Laporan belum tersedia.</p>
  @endif

  <form method="POST" action="{{ route('validation.store', $schedule) }}" style="margin-top:16px;">
    @csrf
    <div class="form-grid">
      <div class="field full"><label>Keputusan</label>
        <select name="hasil" required>
          <option value="disetujui">Disetujui</option>
          <option value="ditolak">Ditolak</option>
        </select>
      </div>
      <div class="field full"><label>Catatan</label><textarea name="catatan"></textarea></div>
      <div class="field full"><label>Jadwal PM Berikutnya (opsional)</label><input type="date" name="jadwal_berikutnya"></div>
    </div>
    <div class="form-actions">
      <a class="btn" href="{{ route('validation.index') }}">Batal</a>
      <button class="btn btn-primary" type="submit">Simpan Validasi</button>
    </div>
  </form>
</div>
@endsection
