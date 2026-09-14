<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk — SIMPM PG Rendeng</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="login-shell">
  <div class="login-box">
    <h1>SIMPM</h1>
    <p class="sub">Sistem Informasi Manajemen Pemeliharaan Mesin — Pabrik Gula Rendeng</p>

    @if($errors->any())
      <div class="alert alert-error">
        @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
      @csrf
      <div class="field">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
      </div>
      <div class="field">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <button class="btn btn-primary" type="submit">Masuk</button>
    </form>

    <p style="margin-top:16px;font-size:11.5px;color:var(--ink-soft);">
      Akun demo (lihat seeder): supervisor@simpm.local / teknisi@simpm.local / manajer@simpm.local — password: <span class="mono">password123</span>
    </p>
  </div>
</div>
</body>
</html>
