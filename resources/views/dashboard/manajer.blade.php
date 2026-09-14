@extends('layouts.app')
@section('title', 'Dashboard Eksekutif')
@section('content')

<div class="grid-stats">
  <div class="stat-card c-blue"><div class="label">OEE Pabrik</div><div class="value">{{ $perf['oee'] !== null ? $perf['oee'].'%' : '—' }}</div></div>
  <div class="stat-card c-green"><div class="label">Availability Pabrik</div><div class="value">{{ $perf['availability'] !== null ? $perf['availability'].'%' : '—' }}</div></div>
  <div class="stat-card c-red"><div class="label">Total Downtime</div><div class="value">{{ $totalDowntime }}<small style="font-size:12px;"> mnt</small></div></div>
  <div class="stat-card c-blue"><div class="label">Total Perbaikan</div><div class="value">{{ $totalPerbaikan }}</div></div>
</div>

<div class="panel">
  <h3 class="panel-title">Downtime per Mesin — Bulan Berjalan</h3>
  <x-bar-chart :items="$downtimePerMesin" unit=" mnt"/>
</div>

<div class="panel">
  <h3 class="panel-title">Ranking Mesin Paling Bermasalah</h3>
  <div class="table-scroll">
  <table>
    <thead><tr><th>Mesin</th><th>Stasiun</th><th>Downtime (mnt)</th></tr></thead>
    <tbody>
      @forelse($rankingBermasalah as $r)
        <tr><td>{{ $r['machine']->name }}</td><td>{{ $r['machine']->station->name }}</td><td class="mono">{{ $r['downtime'] }}</td></tr>
      @empty
        <tr><td colspan="3" class="empty-state">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
