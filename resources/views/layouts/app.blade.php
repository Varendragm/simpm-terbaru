<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Dashboard') — SIMPM PG Rendeng</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="app-shell">
  <aside class="sidebar">
    <div class="brand">
      <strong>SIMPM</strong>
      <span>PG Rendeng</span>
    </div>

    @php $user = auth()->user(); @endphp

    @if($user->role === 'supervisor')
      <div class="group-label">Utama</div>
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><x-icon name="dashboard"/> Dashboard</a>
      <div class="group-label">Monitoring</div>
      <a class="nav-link {{ request()->routeIs('performance.index') ? 'active' : '' }}" href="{{ route('performance.index') }}"><x-icon name="monitor"/> Performa Mesin</a>
      <div class="group-label">Pemeliharaan</div>
      <a class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}" href="{{ route('schedules.index') }}"><x-icon name="schedule"/> Jadwal Preventive</a>
      <a class="nav-link {{ request()->routeIs('validation.*') ? 'active' : '' }}" href="{{ route('validation.index') }}"><x-icon name="check"/> Validasi Pemeriksaan</a>
      <a class="nav-link {{ request()->routeIs('history.index') ? 'active' : '' }}" href="{{ route('history.index') }}"><x-icon name="history"/> Riwayat Maintenance</a>
      <div class="group-label">Data</div>
      <a class="nav-link {{ request()->routeIs('stations.index') ? 'active' : '' }}" href="{{ route('stations.index') }}"><x-icon name="station"/> Stasiun &amp; Mesin</a>
      <div class="group-label">Laporan</div>
      <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}" href="{{ route('reports.index') }}"><x-icon name="report"/> Laporan &amp; Grafik</a>
      <div class="group-label">Akun</div>
      <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><x-icon name="profile"/> Profil Saya</a>
    @elseif($user->role === 'teknisi')
      <div class="group-label">Menu</div>
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><x-icon name="dashboard"/> Dashboard</a>
      <a class="nav-link {{ request()->routeIs('schedules.index') ? 'active' : '' }}" href="{{ route('schedules.index') }}"><x-icon name="calendar"/> Jadwal Maintenance Saya</a>
      <a class="nav-link {{ request()->routeIs('history.index') ? 'active' : '' }}" href="{{ route('history.index') }}"><x-icon name="history"/> Riwayat Perbaikan Saya</a>
      <div class="group-label">Performa</div>
      <a class="nav-link {{ request()->routeIs('performance.index') ? 'active' : '' }}" href="{{ route('performance.index') }}"><x-icon name="monitor"/> Performa Mesin Saya</a>
      <div class="group-label">Akun</div>
      <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><x-icon name="profile"/> Profil Saya</a>
    @else
      <div class="group-label">Eksekutif</div>
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><x-icon name="dashboard"/> Dashboard Eksekutif</a>
      <a class="nav-link {{ request()->routeIs('performance.*') ? 'active' : '' }}" href="{{ route('performance.index') }}"><x-icon name="monitor"/> Performa Seluruh Mesin</a>
      <a class="nav-link {{ request()->routeIs('history.index') ? 'active' : '' }}" href="{{ route('history.index') }}"><x-icon name="history"/> Analisis Maintenance</a>
      <div class="group-label">Laporan</div>
      <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}" href="{{ route('reports.index') }}"><x-icon name="report"/> Unduh Laporan</a>
      <div class="group-label">Akun</div>
      <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><x-icon name="profile"/> Profil Saya</a>
    @endif

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="logout-btn" type="submit"><x-icon name="logout"/> Keluar</button>
    </form>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <strong>@yield('title', 'Dashboard')</strong>
      </div>
      <div style="display:flex; align-items:center; gap:10px;">
        <span class="role-pill">{{ ucfirst($user->role) }}</span>
        <span>{{ $user->name }}</span>
      </div>
    </div>
    <div class="content">
      @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-error">
          @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
        </div>
      @endif

      @yield('content')
    </div>
  </div>
</div>
</body>
</html>
