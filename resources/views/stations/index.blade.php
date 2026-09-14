@extends('layouts.app')
@section('title', 'Stasiun & Mesin')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
  <p style="color:var(--ink-soft); margin:0;">Kelola struktur Stasiun → Mesin. Perubahan di sini langsung tercermin di seluruh filter modul lain.</p>
  <button class="btn btn-primary" onclick="openStationModal('create')">+ Tambah Stasiun</button>
</div>

@foreach($stations as $station)
  <div class="panel">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <h3 class="panel-title" style="margin-bottom:2px;">{{ $station->name }} <span class="mono" style="font-size:12px;color:var(--ink-soft);">{{ $station->code }}</span></h3>
        <div style="font-size:12px;color:var(--ink-soft);">{{ $station->location }}</div>
      </div>
      <div style="display:flex; gap:8px;">
        <x-badge :status="$station->status === 'aktif' ? 'normal' : 'perbaikan'" :label="ucfirst($station->status)"/>
        <button class="btn btn-sm" onclick='openStationModal("edit", @json($station))'>Edit</button>
        <button class="btn btn-sm btn-primary" onclick="openMachineModal(\"create\", null, {{ $station->id }})">+ Mesin</button>
        <form method="POST" action="{{ route('stations.destroy', $station) }}" onsubmit="return confirm('Hapus stasiun ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
        </form>
      </div>
    </div>
    <div class="table-scroll" style="margin-top:10px;">
      <table>
        <thead><tr><th>Kode</th><th>Nama Mesin</th><th>Jenis</th><th>Kapasitas</th><th>Tahun</th><th>Status</th><th></th></tr></thead>
        <tbody>
          @forelse($station->machines as $m)
            <tr>
              <td class="mono">{{ $m->code }}</td>
              <td>{{ $m->name }}</td>
              <td>{{ $m->type }}</td>
              <td>{{ $m->capacity }}</td>
              <td class="mono">{{ $m->install_year }}</td>
              <td><x-badge :status="$m->status" :label="$m->statusLabel()"/></td>
              <td style="display:flex;gap:6px;">
                <button class="btn btn-sm" onclick='openMachineModal("edit", @json($m), {{ $station->id }})'>Edit</button>
                <form method="POST" action="{{ route('machines.destroy', $m) }}" onsubmit="return confirm('Hapus mesin ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="empty-state">Belum ada mesin di stasiun ini.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endforeach

{{-- Modal Stasiun --}}
<div class="modal-overlay" id="stationModal">
  <div class="modal-box">
    <h3 id="stationModalTitle">Tambah Stasiun</h3>
    <form method="POST" id="stationForm">
      @csrf
      <div id="stationMethodField"></div>
      <div class="form-grid">
        <div class="field full"><label>Kode</label><input type="text" name="code" id="st_code" required></div>
        <div class="field full"><label>Nama Stasiun</label><input type="text" name="name" id="st_name" required></div>
        <div class="field full"><label>Lokasi</label><input type="text" name="location" id="st_location"></div>
        <div class="field full"><label>Deskripsi</label><textarea name="description" id="st_description"></textarea></div>
        <div class="field"><label>Status</label>
          <select name="status" id="st_status"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select>
        </div>
      </div>
      <div class="form-actions">
        <button type="button" class="btn" onclick="closeModal('stationModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Mesin --}}
<div class="modal-overlay" id="machineModal">
  <div class="modal-box">
    <h3 id="machineModalTitle">Tambah Mesin</h3>
    <form method="POST" id="machineForm">
      @csrf
      <div id="machineMethodField"></div>
      <input type="hidden" name="station_id" id="mc_station_id">
      <div class="form-grid">
        <div class="field"><label>Kode</label><input type="text" name="code" id="mc_code" required></div>
        <div class="field"><label>Nama Mesin</label><input type="text" name="name" id="mc_name" required></div>
        <div class="field"><label>Jenis</label><input type="text" name="type" id="mc_type"></div>
        <div class="field"><label>Kapasitas</label><input type="text" name="capacity" id="mc_capacity"></div>
        <div class="field"><label>Tahun Pemasangan</label><input type="number" name="install_year" id="mc_year"></div>
        <div class="field"><label>Status</label>
          <select name="status" id="mc_status">
            <option value="normal">Normal</option>
            <option value="perhatian">Perlu Perhatian</option>
            <option value="perbaikan">Dalam Perbaikan</option>
          </select>
        </div>
        <div class="field full"><label>Keterangan</label><textarea name="notes" id="mc_notes"></textarea></div>
      </div>
      <div class="form-actions">
        <button type="button" class="btn" onclick="closeModal('machineModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
function closeModal(id){ document.getElementById(id).classList.remove('open'); }

function openStationModal(mode, station){
  document.getElementById('stationModalTitle').textContent = mode === 'edit' ? 'Edit Stasiun' : 'Tambah Stasiun';
  const form = document.getElementById('stationForm');
  form.action = mode === 'edit' ? '/master/stasiun/' + station.id : '{{ route('stations.store') }}';
  document.getElementById('stationMethodField').innerHTML = mode === 'edit' ? '@method('PUT')' : '';
  document.getElementById('st_code').value = station ? station.code : '';
  document.getElementById('st_name').value = station ? station.name : '';
  document.getElementById('st_location').value = station ? (station.location||'') : '';
  document.getElementById('st_description').value = station ? (station.description||'') : '';
  document.getElementById('st_status').value = station ? station.status : 'aktif';
  document.getElementById('stationModal').classList.add('open');
}

function openMachineModal(mode, machine, stationId){
  document.getElementById('machineModalTitle').textContent = mode === 'edit' ? 'Edit Mesin' : 'Tambah Mesin';
  const form = document.getElementById('machineForm');
  form.action = mode === 'edit' ? '/master/mesin/' + machine.id : '{{ route('machines.store') }}';
  document.getElementById('machineMethodField').innerHTML = mode === 'edit' ? '@method('PUT')' : '';
  document.getElementById('mc_station_id').value = stationId;
  document.getElementById('mc_code').value = machine ? machine.code : '';
  document.getElementById('mc_name').value = machine ? machine.name : '';
  document.getElementById('mc_type').value = machine ? (machine.type||'') : '';
  document.getElementById('mc_capacity').value = machine ? (machine.capacity||'') : '';
  document.getElementById('mc_year').value = machine ? (machine.install_year||'') : '';
  document.getElementById('mc_status').value = machine ? machine.status : 'normal';
  document.getElementById('mc_notes').value = machine ? (machine.notes||'') : '';
  document.getElementById('machineModal').classList.add('open');
}
</script>
@endsection
