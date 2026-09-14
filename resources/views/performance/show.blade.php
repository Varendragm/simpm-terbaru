@extends('layouts.app')
@section('title', 'Detail Mesin — '.$machine->name)
@section('content')

<div class="panel">
  <h3 class="panel-title">{{ $machine->name }} <span class="mono" style="font-size:13px;color:var(--ink-soft);">{{ $machine->code }}</span></h3>
  <div style="display:flex; gap:24px; font-size:12.8px; flex-wrap:wrap;">
    <div>Stasiun: <strong>{{ $machine->station->name }}</strong></div>
    <div>Status: <x-badge :status="$machine->status" :label="$machine->statusLabel()"/></div>
    <div>Jenis: {{ $machine->type ?? '—' }}</div>
    <div>Tahun Pasang: <span class="mono">{{ $machine->install_year ?? '—' }}</span></div>
  </div>
</div>

<form method="GET" class="filter-row">
  <div class="field"><label>Periode</label><input type="month" name="period" value="{{ $period }}" onchange="this.form.submit()"></div>
</form>

<div class="panel">
  <h3 class="panel-title">Indikator Performa — {{ $period }}</h3>
  <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:16px;">
    <x-progress label="OEE" :value="$perf['oee']" color="blue"/>
    <x-progress label="Availability" :value="$perf['availability']" color="green"/>
    <x-progress label="Reliability" :value="$perf['reliability']" color="green"/>
    <x-progress label="Performance" :value="$perf['performance']" color="amber"/>
    <x-progress label="Quality" :value="$perf['quality']" color="amber"/>
  </div>
  <div style="display:flex; gap:24px; margin-top:14px; font-size:12.5px; color:var(--ink-soft);">
    <div>MTTR: <span class="mono">{{ $perf['mttr'] !== null ? $perf['mttr'].' mnt' : 'Belum tersedia' }}</span></div>
    <div>MTBF: <span class="mono">{{ $perf['mtbf'] !== null ? $perf['mtbf'].' mnt' : 'Belum tersedia' }}</span></div>
    <div>Downtime: <span class="mono">{{ $perf['downtime_minutes'] }} mnt</span></div>
  </div>
</div>

<div class="panel">
  <h3 class="panel-title">Tren OEE 6 Bulan Terakhir</h3>
  <x-bar-chart :items="collect($trend)->map(fn($v,$k)=>['label'=>$k,'value'=>$v ?? 0])->values()" unit="%"/>
</div>

<div class="panel">
  <h3 class="panel-title">Jadwal Preventive Berikutnya</h3>
  @if($nextSchedule)
    <p>{{ $nextSchedule->jenis }} — <span class="mono">{{ $nextSchedule->tanggal->format('d M Y') }}</span> oleh {{ optional($nextSchedule->technician)->name ?? '—' }}</p>
  @else
    <p class="empty-state">Tidak ada jadwal preventive yang akan datang.</p>
  @endif
</div>

<div class="panel">
  <h3 class="panel-title">Riwayat Maintenance</h3>
  <div class="table-scroll">
  <table>
    <thead><tr><th>Tanggal</th><th>Jenis</th><th>Pekerjaan</th><th>Pelaksana</th><th>Downtime</th><th>Hasil</th></tr></thead>
    <tbody>
      @forelse($riwayat as $h)
        <tr>
          <td class="mono">{{ $h->tanggal->format('d M Y') }}</td>
          <td>{{ $h->kategori }}</td>
          <td>{{ $h->pekerjaan }}</td>
          <td>{{ $h->pelaksana }}</td>
          <td class="mono">{{ $h->downtime_menit }} mnt</td>
          <td>{{ $h->hasil }}</td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty-state">Belum ada riwayat maintenance untuk mesin ini.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
