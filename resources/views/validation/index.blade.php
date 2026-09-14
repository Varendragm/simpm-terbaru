@extends('layouts.app')
@section('title', 'Validasi Pemeriksaan')
@section('content')

<div class="panel">
  <h3 class="panel-title">Antrean Menunggu Validasi</h3>
  <div class="table-scroll">
  <table>
    <thead><tr><th>Mesin</th><th>Jenis</th><th>Teknisi</th><th>Kategori</th><th>Downtime</th><th></th></tr></thead>
    <tbody>
      @forelse($antrean as $a)
        <tr>
          <td>{{ $a->machine->name }} <span style="color:var(--ink-soft)">({{ $a->machine->station->name }})</span></td>
          <td>{{ $a->jenis }}</td>
          <td>{{ optional($a->technician)->name }}</td>
          <td>{{ $a->report ? ucfirst($a->report->kategori) : '—' }}</td>
          <td class="mono">{{ optional($a->report)->downtime_menit ?? 0 }} mnt</td>
          <td><a class="btn btn-sm btn-primary" href="{{ route('validation.show', $a) }}">Validasi</a></td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty-state">Tidak ada antrean validasi.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>

<div class="panel">
  <h3 class="panel-title">Riwayat Validasi</h3>
  <div class="table-scroll">
  <table>
    <thead><tr><th>Tanggal</th><th>Mesin</th><th>Divalidasi Oleh</th><th>Hasil</th></tr></thead>
    <tbody>
      @forelse($riwayat as $v)
        <tr>
          <td class="mono">{{ $v->tanggal->format('d M Y') }}</td>
          <td>{{ $v->machine->name }}</td>
          <td>{{ optional($v->validator)->name }}</td>
          <td><x-badge :status="$v->hasil" :label="ucfirst($v->hasil)"/></td>
        </tr>
      @empty
        <tr><td colspan="4" class="empty-state">Belum ada riwayat validasi.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
