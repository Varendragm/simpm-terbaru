@extends('layouts.app')
@section('title', 'Detail Jadwal')
@section('content')

<div class="panel" style="max-width:720px;">
  <h3 class="panel-title">{{ $schedule->jenis }}</h3>
  <div style="display:flex; gap:24px; flex-wrap:wrap; font-size:12.8px; margin-bottom:12px;">
    <div>Mesin: <strong>{{ $schedule->machine->name }}</strong> ({{ $schedule->machine->station->name }})</div>
    <div>Tanggal: <span class="mono">{{ $schedule->tanggal->format('d M Y') }}</span></div>
    <div>Teknisi: {{ optional($schedule->technician)->name ?? '—' }}</div>
    <div>Prioritas: <x-badge :status="$schedule->prioritas" :label="ucfirst($schedule->prioritas)"/></div>
    <div>Status: <x-badge :status="$schedule->status" :label="$schedule->statusLabel()"/></div>
  </div>

  @if($schedule->report)
    <h3 class="panel-title">Laporan Pemeriksaan Teknisi</h3>
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
  @endif

  @if($schedule->validationHistory)
    <h3 class="panel-title">Hasil Validasi</h3>
    <p><x-badge :status="$schedule->validationHistory->hasil" :label="ucfirst($schedule->validationHistory->hasil)"/></p>
    @if($schedule->validationHistory->catatan)<p><strong>Catatan:</strong> {{ $schedule->validationHistory->catatan }}</p>@endif
  @endif
</div>
@endsection
