<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Selamat Datang — SIMPM PG Rendeng</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
.welcome{min-height:100vh;background:#1f2933;color:#fff;display:flex;align-items:center;justify-content:center;text-align:center;padding:24px}.inner{max-width:520px}.avatar{width:68px;height:68px;border-radius:50%;display:grid;place-items:center;margin:0 auto 20px;background:#34424d;border:1px solid #53616c;font:500 20px 'IBM Plex Mono',monospace}.hello{font-size:11px;text-transform:uppercase;letter-spacing:.12em;color:#8f9ba6}.name{margin-top:7px;font:600 38px 'Barlow Condensed',sans-serif}.role{margin-top:2px;color:#aeb8c2;font-size:13px}.prepare{margin-top:38px;color:#7f8b96;font-size:11px}.loader{width:220px;height:3px;background:#35434e;border-radius:10px;overflow:hidden;margin:12px auto 0}.loader span{display:block;width:40%;height:100%;background:#6ea5d8;animation:move 1.4s ease-in-out infinite}@keyframes move{0%{transform:translateX(-110%)}100%{transform:translateX(650%)}}
</style>
</head>
<body>
<div class="welcome"><div class="inner"><div class="avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div><div class="hello">Selamat Datang</div><div class="name">{{ $user->name }}</div><div class="role">{{ ucfirst($user->role) }} · SIMPM PG Rendeng</div><div class="prepare">Menyiapkan dashboard</div><div class="loader"><span></span></div></div></div>
<script>setTimeout(function(){window.location.href='{{ route('dashboard') }}';},1500);</script>
</body>
</html>
