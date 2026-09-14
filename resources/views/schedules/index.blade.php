@extends('layouts.app')
@section('title', 'Jadwal Preventive Maintenance')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center;">
  <p style="color:var(--ink-soft);margin:0 0 10px;">Kelola jadwal pemeriksaan/preventive maintenance per mesin.</p>
  @if(auth()->user()->isSupervisor())
    <a class="btn btn-primary" href="{{ route('schedules.create') }}">+ Tambah Jadwal</a>
  @endif
</div>

<form method="GET" class="filter-row">
  <div class="field"><label>Stasiun</label>
    <select name="station_id"><option value="">Semua</option>
      @foreach($stations as $s)<option value="{{ $s->id }}" @selected(request('station_id')==$s->id)>{{ $s->name }}</option>@endforeach
    </select>
  </div>
  <div class="field"><label>Status</label>
    <select name="status">
      <option value="">Semua</option>
      @foreach(['terjadwal'=>'Terjadwal','menunggu_validasi'=>'Menunggu Validasi','selesai'=>'Selesai','ditolak'=>'Ditolak'] as $k=>$v)
        <option value="{{ $k }}" @selected(request('status')==$k)>{{ $v }}</option>
      @endforeach
    </select>
  </div>
  <div class="field"><label>Dari</label><input type="date" name="from" value="{{ request('from') }}"></div>
  <div class="field"><label>Sampai</label><input type="date" name="to" value="{{ request('to') }}"></div>
  <div class="field"><label>&nbsp;</label><button class="btn" type="submit">Terapkan</button></div>
</form>

<div class="panel">
  <div class="table-scroll">
  <table>
    <thead><tr><th>Tanggal</th><th>Mesin</th><th>Jenis</th><th>Teknisi</th><th>Prioritas</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @forelse($jadwal as $j)
        <tr>
          <td class="mono">{{ $j->tanggal->format('d M Y') }}</td>
          <td>{{ $j->machine->name }} <span style="color:var(--ink-soft)">({{ $j->machine->station->name }})</span></td>
          <td>{{ $j->jenis }}</td>
          <td>{{ optional($j->technician)->name ?? '—' }}</td>
          <td><x-badge :status="$j->prioritas" :label="ucfirst($j->prioritas)"/></td>
          <td><x-badge :status="$j->status" :label="$j->statusLabel()"/></td>
          <td style="display:flex;gap:6px;">
            <a class="btn btn-sm" href="{{ route('schedules.show', $j) }}">Lihat</a>
            @if(auth()->user()->isTeknisi() && $j->status === 'terjadwal' && $j->technician_id === auth()->id())
              <a class="btn btn-sm btn-primary" href="{{ route('reports.create', $j) }}">Isi Laporan</a>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="7" class="empty-state">Tidak ada jadwal yang sesuai dengan filter.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
  {{ $jadwal->links() }}
</div>
@endsection
