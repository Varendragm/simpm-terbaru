<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk — SIMPM PG Rendeng</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
.auth-page{min-height:100vh;background:#f4f5f7;display:flex;align-items:stretch;justify-content:center;padding:24px}
.auth-shell{width:min(1050px,100%);min-height:620px;background:#fff;border:1px solid #e2e5ea;border-radius:8px;overflow:hidden;display:grid;grid-template-columns:42% 58%;box-shadow:0 14px 40px rgba(20,30,40,.08)}
.auth-side{background:#1f2933;color:#fff;padding:46px 42px;display:flex;flex-direction:column;justify-content:space-between}
.brand{font:600 32px 'Barlow Condensed',sans-serif;letter-spacing:.4px}.brand span{color:#6ea5d8}
.side-title{font:600 34px 'Barlow Condensed',sans-serif;line-height:1.05;margin:0 0 14px}.side-copy{color:#aeb8c2;line-height:1.65;font-size:13px;max-width:360px}
.flow{margin-top:28px;display:grid;gap:12px}.flow-item{display:flex;gap:12px;align-items:flex-start;color:#d6dce2;font-size:12.5px}.flow-n{width:24px;height:24px;border:1px solid #52606c;border-radius:50%;display:grid;place-items:center;font:500 11px 'IBM Plex Mono',monospace;flex:none}
.side-foot{font-size:11px;color:#7f8b96;line-height:1.6;border-top:1px solid #33404a;padding-top:18px}.side-foot strong{display:block;color:#aeb8c2;font-weight:500}
.auth-main{padding:48px 58px;display:flex;align-items:center}.auth-card{width:100%;max-width:480px;margin:auto}.eyebrow{font-size:10.5px;text-transform:uppercase;letter-spacing:.09em;color:#7a858f;font-weight:600;margin-bottom:7px}.auth-card h1{font-size:31px;margin:0 0 6px}.auth-card .lead{margin:0 0 24px;color:#69737d;font-size:13px}
.role-tabs{display:grid;grid-template-columns:repeat(3,1fr);border:1px solid #e2e5ea;border-radius:6px;padding:3px;margin-bottom:22px;background:#f8f9fa}.role-tab{border:0;background:transparent;border-radius:4px;padding:9px 6px;font:600 12px Inter,sans-serif;color:#69737d;cursor:pointer}.role-tab.active{background:#fff;color:#1f2933;box-shadow:0 1px 4px rgba(20,30,40,.12)}
.field{margin-bottom:15px}.field label{display:block;font-size:11px;text-transform:uppercase;letter-spacing:.04em;color:#5b6470;margin-bottom:5px;font-weight:600}.field input{width:100%;min-width:0;height:42px;padding:0 12px;border:1px solid #dfe3e8;border-radius:6px;font:13px Inter,sans-serif;color:#1c2126;outline:none}.field input:focus{border-color:#2563a8;box-shadow:0 0 0 3px rgba(37,99,168,.09)}
.password-wrap{position:relative}.password-wrap input{padding-right:74px}.toggle-pass{position:absolute;right:10px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:#69737d;font-size:11px;cursor:pointer}
.remember{display:flex;align-items:center;gap:7px;font-size:12px;color:#69737d;margin:2px 0 20px}.remember input{accent-color:#2563a8}.submit{width:100%;height:43px;border:1px solid #1f2933;border-radius:6px;background:#1f2933;color:#fff;font:600 13px Inter,sans-serif;cursor:pointer}.submit:hover{background:#2a333b}.demo{margin-top:18px;padding:11px 12px;background:#f7f8fa;border:1px solid #e7e9ed;border-radius:6px;color:#69737d;font-size:11px;line-height:1.55}.demo strong{color:#1c2126;font-weight:600}
.alert{margin-bottom:16px;padding:10px 12px;border-radius:6px;font-size:12px}.alert-error{background:#fbe9e7;color:#c0392b;border:1px solid #f2d1cd}
@media(max-width:760px){.auth-page{padding:0}.auth-shell{border:0;border-radius:0;grid-template-columns:1fr;min-height:100vh}.auth-side{display:none}.auth-main{padding:32px 22px}.auth-card h1{font-size:28px}}
</style>
</head>
<body>
<div class="auth-page">
  <div class="auth-shell">
    <aside class="auth-side">
      <div>
        <div class="brand">SIM<span>PM</span></div>
        <div style="margin-top:72px">
          <h2 class="side-title">Monitoring Performa Mesin &amp; Maintenance</h2>
          <p class="side-copy">Sistem informasi pemeliharaan mesin Pabrik Gula Rendeng untuk memantau kondisi mesin, preventive maintenance, hasil pemeriksaan, dan performa operasional.</p>
          <div class="flow">
            <div class="flow-item"><span class="flow-n">1</span><span>Data kerusakan dan perbaikan dari SIPPM menjadi riwayat maintenance.</span></div>
            <div class="flow-item"><span class="flow-n">2</span><span>Performa mesin dipantau melalui OEE, availability, reliability, dan downtime.</span></div>
            <div class="flow-item"><span class="flow-n">3</span><span>Supervisor, Teknisi, dan Manajer bekerja sesuai kewenangan masing-masing.</span></div>
          </div>
        </div>
      </div>
      <div class="side-foot"><strong>SIMPM PG Rendeng</strong>Modul pemeliharaan dan monitoring performa mesin.</div>
    </aside>

    <main class="auth-main">
      <div class="auth-card">
        <div class="eyebrow">Akses sistem</div>
        <h1>Masuk ke SIMPM</h1>
        <p class="lead">Pilih peran, lalu masukkan akun Anda untuk melanjutkan.</p>

        @if($errors->any())
          <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
          @csrf
          <input type="hidden" name="role" id="loginRole" value="{{ old('role','supervisor') }}">

          <div class="role-tabs">
            <button type="button" class="role-tab {{ old('role','supervisor')==='supervisor' ? 'active':'' }}" data-role="supervisor">Supervisor</button>
            <button type="button" class="role-tab {{ old('role')==='teknisi' ? 'active':'' }}" data-role="teknisi">Teknisi</button>
            <button type="button" class="role-tab {{ old('role')==='manajer' ? 'active':'' }}" data-role="manajer">Manajer</button>
          </div>

          <div class="field">
            <label>Email</label>
            <input type="email" name="email" id="loginEmail" value="{{ old('email') }}" placeholder="nama@simpm.local" required autofocus>
          </div>
          <div class="field">
            <label>Password</label>
            <div class="password-wrap"><input type="password" name="password" id="loginPassword" placeholder="Masukkan password" required><button type="button" class="toggle-pass" id="togglePass">Tampilkan</button></div>
          </div>
          <label class="remember"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
          <button class="submit" type="submit">Masuk sebagai <span id="roleText">{{ ucfirst(old('role','supervisor')) }}</span></button>
        </form>

        <div class="demo"><strong>Akun demo</strong><br>Supervisor: supervisor@simpm.local · Teknisi: budi@simpm.local · Manajer: manajer@simpm.local<br>Password: <span class="mono">password123</span></div>
      </div>
    </main>
  </div>
</div>
<script>
const accounts={supervisor:'supervisor@simpm.local',teknisi:'budi@simpm.local',manajer:'manajer@simpm.local'};
const labels={supervisor:'Supervisor',teknisi:'Teknisi',manajer:'Manajer'};
document.querySelectorAll('.role-tab').forEach(btn=>btn.addEventListener('click',()=>{const role=btn.dataset.role;document.getElementById('loginRole').value=role;document.getElementById('loginEmail').value=accounts[role];document.getElementById('roleText').textContent=labels[role];document.querySelectorAll('.role-tab').forEach(b=>b.classList.toggle('active',b===btn));}));
document.getElementById('togglePass').addEventListener('click',()=>{const input=document.getElementById('loginPassword');const show=input.type==='password';input.type=show?'text':'password';document.getElementById('togglePass').textContent=show?'Sembunyikan':'Tampilkan';});
</script>
</body>
</html>
