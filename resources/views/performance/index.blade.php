@extends('layouts.app')
@section('title', 'Performa Mesin')
@section('content')

<form method="GET" class="filter-row">
  <div class="field"><label>Stasiun</label>
    <select name="station_id" onchange="this.form.submit()">
      <option value="">Semua Stasiun</option>
      @foreach($stations as $s)
        <option value="{{ $s->id }}" @selected(request('station_id')==$s->id)>{{ $s->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="field"><label>Periode</label><input type="month" name="period" value="{{ $period }}" onchange="this.form.submit()"></div>
  <div class="field"><label>&nbsp;</label><button class="btn" type="submit">Terapkan</button></div>
</form>

<div class="panel">
  <h3 class="panel-title">OEE per Mesin — {{ $period }}</h3>
  <x-bar-chart :items="$chartOee" unit="%"/>
</div>

<div class="panel">
  <div class="table-scroll">
  <table>
    <thead><tr><th>Mesin</th><th>Stasiun</th><th>Status</th><th>Availability</th><th>OEE</th><th>Downtime (mnt)</th><th></th></tr></thead>
    <tbody>
      @forelse($rows as $r)
        <tr>
          <td>{{ $r['machine']->name }}</td>
          <td>{{ $r['machine']->station->name }}</td>
          <td><x-badge :status="$r['machine']->status" :label="$r['machine']->statusLabel()"/></td>
          <td class="mono">{{ $r['perf']['availability'] !== null ? $r['perf']['availability'].'%' : '—' }}</td>
          <td class="mono">{{ $r['perf']['oee'] !== null ? $r['perf']['oee'].'%' : '—' }}</td>
          <td class="mono">{{ $r['perf']['downtime_minutes'] }}</td>
          <td><a class="btn btn-sm" href="{{ route('performance.show', $r['machine']) }}">Detail</a></td>
        </tr>
      @empty
        <tr><td colspan="7" class="empty-state">Tidak ada mesin yang sesuai filter.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
