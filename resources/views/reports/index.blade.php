@extends('layouts.app')
@section('title', 'Laporan & Grafik')
@section('content')

<form method="GET" class="filter-row">
  <div class="field"><label>Stasiun</label>
    <select name="station_id"><option value="">Semua</option>
      @foreach($stations as $s)<option value="{{ $s->id }}" @selected(request('station_id')==$s->id)>{{ $s->name }}</option>@endforeach
    </select>
  </div>
  <div class="field"><label>Periode</label><input type="month" name="period" value="{{ $period }}"></div>
  <div class="field"><label>&nbsp;</label><button class="btn" type="submit">Terapkan</button></div>
  <div class="field"><label>&nbsp;</label><button class="btn" type="button" onclick="alert('Ekspor PDF/Excel akan tersedia setelah generator laporan sungguhan diimplementasikan.')">Ekspor (placeholder)</button></div>
</form>

<div class="grid-stats">
  <div class="stat-card c-blue"><div class="label">Total Maintenance</div><div class="value">{{ $totalMaintenance }}</div></div>
  <div class="stat-card c-red"><div class="label">Total Downtime</div><div class="value">{{ $totalDowntime }}<small style="font-size:12px;"> mnt</small></div></div>
  <div class="stat-card c-blue"><div class="label">MTTR Rata-rata</div><div class="value">{{ $perf['mttr'] ?? '—' }}</div></div>
  <div class="stat-card c-blue"><div class="label">MTBF Rata-rata</div><div class="value">{{ $perf['mtbf'] ?? '—' }}</div></div>
  <div class="stat-card c-blue"><div class="label">OEE Rata-rata</div><div class="value">{{ $perf['oee'] !== null ? $perf['oee'].'%' : '—' }}</div></div>
  <div class="stat-card c-green"><div class="label">Mesin Normal</div><div class="value">{{ $mesinNormal }}</div></div>
  <div class="stat-card c-amber"><div class="label">Mesin Warning</div><div class="value">{{ $mesinWarning }}</div></div>
  <div class="stat-card c-red"><div class="label">Mesin Critical</div><div class="value">{{ $mesinCritical }}</div></div>
</div>

<div class="panel">
  <h3 class="panel-title">OEE per Mesin</h3>
  <x-bar-chart :items="$oeePerMesin" unit="%"/>
</div>

<div class="panel">
  <h3 class="panel-title">Downtime per Mesin</h3>
  <x-bar-chart :items="$downtimePerMesin" unit=" mnt"/>
</div>

<div class="panel">
  <h3 class="panel-title">Tren Downtime — 6 Bulan Terakhir</h3>
  <x-bar-chart :items="$trendDowntime" unit=" mnt"/>
</div>

<div class="panel">
  <h3 class="panel-title">Ringkasan Maintenance per Stasiun</h3>
  <div class="table-scroll">
  <table>
    <thead><tr><th>Stasiun</th><th>Jumlah Mesin</th><th>Total Maintenance</th><th>Total Downtime</th></tr></thead>
    <tbody>
      @forelse($perStation as $row)
        <tr>
          <td>{{ $row['stasiun'] }}</td>
          <td class="mono">{{ $row['jumlah_mesin'] }}</td>
          <td class="mono">{{ $row['total_maintenance'] }}</td>
          <td class="mono">{{ $row['total_downtime'] }} mnt</td>
        </tr>
      @empty
        <tr><td colspan="4" class="empty-state">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
