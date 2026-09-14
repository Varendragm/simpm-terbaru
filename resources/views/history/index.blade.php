@extends('layouts.app')
@section('title', 'Riwayat Maintenance')
@section('content')

<form method="GET" class="filter-row">
  <div class="field"><label>Stasiun</label>
    <select name="station_id"><option value="">Semua</option>
      @foreach($stations as $s)<option value="{{ $s->id }}" @selected(request('station_id')==$s->id)>{{ $s->name }}</option>@endforeach
    </select>
  </div>
  <div class="field"><label>Kategori</label>
    <select name="kategori"><option value="">Semua</option>
      <option value="mekanik" @selected(request('kategori')=='mekanik')>Mekanik</option>
      <option value="elektrik" @selected(request('kategori')=='elektrik')>Elektrik</option>
      <option value="instrumentasi" @selected(request('kategori')=='instrumentasi')>Instrumentasi</option>
    </select>
  </div>
  <div class="field"><label>Dari</label><input type="date" name="from" value="{{ request('from') }}"></div>
  <div class="field"><label>Sampai</label><input type="date" name="to" value="{{ request('to') }}"></div>
  <div class="field"><label>&nbsp;</label><button class="btn" type="submit">Terapkan</button></div>
</form>

<div class="panel">
  <div class="table-scroll">
  <table>
    <thead><tr><th>Tanggal</th><th>Stasiun</th><th>Mesin</th><th>Jenis</th><th>Pekerjaan</th><th>Pelaksana</th><th>Downtime</th><th>Hasil</th><th>Sumber</th></tr></thead>
    <tbody>
      @forelse($riwayat as $h)
        <tr>
          <td class="mono">{{ $h->tanggal->format('d M Y') }}</td>
          <td>{{ $h->machine->station->name }}</td>
          <td>{{ $h->machine->name }}</td>
          <td>{{ $h->kategori }}</td>
          <td>{{ $h->pekerjaan }}</td>
          <td>{{ $h->pelaksana }}</td>
          <td class="mono">{{ $h->downtime_menit }} mnt</td>
          <td>{{ $h->hasil }}</td>
          <td><x-badge :status="$h->source === 'pm' ? 'normal' : 'info'" :label="strtoupper($h->source)"/></td>
        </tr>
      @empty
        <tr><td colspan="9" class="empty-state">Tidak ada riwayat yang sesuai dengan filter.</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
  {{ $riwayat->links() }}
</div>
@endsection
