@extends('layouts.app')
@section('title', 'Dashboard Supervisor')
@section('content')

<div class="grid-stats">
  <div class="stat-card c-blue"><div class="label">Total Mesin</div><div class="value">{{ $totalMesin }}</div></div>
  <div class="stat-card c-green"><div class="label">Mesin Normal</div><div class="value">{{ $mesinNormal }}</div></div>
  <div class="stat-card c-amber"><div class="label">Perlu Perhatian</div><div class="value">{{ $mesinPerhatian }}</div></div>
  <div class="stat-card c-blue"><div class="label">Maintenance Hari Ini</div><div class="value">{{ $maintenanceHariIni }}</div></div>
  <div class="stat-card c-red"><div class="label">Downtime Bulan Ini</div><div class="value">{{ $downtimeBulanIni }}<small style="font-size:12px;"> mnt</small></div></div>
</div>

<div class="panel">
  <h3 class="panel-title">Indikator Performa Rata-rata Pabrik — {{ now()->translatedFormat('F Y') }}</h3>
  <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:16px;">
    <x-progress label="OEE" :value="$perf['oee']" color="blue"/>
    <x-progress label="Availability" :value="$perf['availability']" color="green"/>
    <x-progress label="Reliability" :value="$perf['reliability']" color="green"/>
  </div>
  <div style="display:flex; gap:24px; margin-top:14px; font-size:12.5px; color:var(--ink-soft);">
    <div>MTTR: <span class="mono">{{ $perf['mttr'] !== null ? $perf['mttr'].' mnt' : 'Belum tersedia' }}</span></div>
    <div>MTBF: <span class="mono">{{ $perf['mtbf'] !== null ? $perf['mtbf'].' mnt' : 'Belum tersedia' }}</span></div>
  </div>
</div>

<div class="panel">
  <h3 class="panel-title">Downtime per Mesin — Bulan Berjalan</h3>
  <x-bar-chart :items="$downtimePerMesin" unit=" mnt"/>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:16px;">
  <div class="panel">
    <h3 class="panel-title">Mesin Perlu Perhatian</h3>
    <ul class="mini-list">
      @forelse($mesinPerluPerhatian as $m)
        <li><span>{{ $m->name }} <span style="color:var(--ink-soft)">— {{ $m->station->name }}</span></span> <x-badge :status="$m->status" :label="$m->statusLabel()"/></li>
      @empty
        <li class="empty-state">Tidak ada mesin yang perlu perhatian.</li>
      @endforelse
    </ul>
  </div>
  <div class="panel">
    <h3 class="panel-title">Jadwal Maintenance Terdekat</h3>
    <ul class="mini-list">
      @forelse($jadwalTerdekat as $j)
        <li><span>{{ $j->machine->name }} — {{ $j->jenis }}</span> <span class="mono">{{ $j->tanggal->format('d M') }}</span></li>
      @empty
        <li class="empty-state">Tidak ada jadwal mendatang.</li>
      @endforelse
    </ul>
  </div>
  <div class="panel">
    <h3 class="panel-title">Menunggu Validasi</h3>
    <ul class="mini-list">
      @forelse($menungguValidasi as $j)
        <li><a href="{{ route('validation.show', $j) }}">{{ $j->machine->name }} — {{ $j->jenis }}</a> <x-badge status="menunggu_validasi" label="Menunggu"/></li>
      @empty
        <li class="empty-state">Tidak ada antrean validasi.</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection
