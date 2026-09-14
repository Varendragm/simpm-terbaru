@extends('layouts.app')
@section('title', 'Dashboard Saya')
@section('content')

<div class="grid-stats">
  <div class="stat-card c-blue"><div class="label">Jadwal Aktif</div><div class="value">{{ $jadwalAktif }}</div></div>
  <div class="stat-card c-amber"><div class="label">Jatuh Tempo Hari Ini</div><div class="value">{{ $jatuhTempoHariIni }}</div></div>
  <div class="stat-card c-green"><div class="label">Selesai Bulan Ini</div><div class="value">{{ $selesaiBulanIni }}</div></div>
</div>

<div class="panel">
  <h3 class="panel-title">Jadwal Ditugaskan Kepada Saya</h3>
  <div class="table-scroll">
  <table>
    <thead><tr><th>Tanggal</th><th>Mesin</th><th>Jenis</th><th>Prioritas</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @forelse($jadwalSaya as $j)
        <tr>
          <td class="mono">{{ $j->tanggal->format('d M Y') }}</td>
          <td>{{ $j->machine->name }} <span style="color:var(--ink-soft)">({{ $j->machine->station->name }})</span></td>
          <td>{{ $j->jenis }}</td>
          <td><x-badge :status="$j->prioritas" :label="ucfirst($j->prioritas)"/></td>
          <td><x-badge :status="$j->status" :label="$j->statusLabel()"/></td>
          <td>
            @if($j->status === 'terjadwal')
              <a class="btn btn-sm btn-primary" href="{{ route('reports.create', $j) }}">Isi Laporan</a>
            @else
              <a class="btn btn-sm" href="{{ route('schedules.show', $j) }}">Lihat</a>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty-state">Tidak ada jadwal aktif.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
