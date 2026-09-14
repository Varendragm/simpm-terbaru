<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk — SIMPM PG Rendeng</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
.auth-page{min-height:100vh;background:#f3f7f4;display:flex;align-items:center;justify-content:center;padding:28px;position:relative;overflow:hidden}.auth-page:before{content:'';position:absolute;width:560px;height:560px;border-radius:50%;background:#e3f2e9;right:-240px;top:-250px}.auth-shell{position:relative;width:min(1060px,100%);min-height:630px;background:#fff;border:1px solid #dfe9e3;border-radius:14px;overflow:hidden;display:grid;grid-template-columns:43% 57%;box-shadow:0 18px 55px rgba(21,70,45,.11);z-index:1}.auth-side{background:linear-gradient(160deg,#0d3b27,#176b43 72%,#198754);color:#fff;padding:42px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden}.auth-side:after{content:'';position:absolute;width:330px;height:330px;border:1px solid rgba(255,255,255,.1);border-radius:50%;right:-170px;bottom:-140px}.brand{display:flex;align-items:center;gap:10px;font-size:22px;font-weight:800;letter-spacing:-.03em}.brand-mark{width:38px;height:38px;border-radius:9px;background:#fff;color:#198754;display:grid;place-items:center}.brand-mark svg{width:23px;height:23px}.brand span{color:#a9e6c3}.side-title{font-size:31px;line-height:1.08;margin:0 0 14px;letter-spacing:-.025em}.side-copy{color:#c8e3d3;line-height:1.7;font-size:12.5px;max-width:370px}.flow{margin-top:28px;display:grid;gap:13px}.flow-item{display:flex;gap:11px;align-items:flex-start;color:#e0f0e7;font-size:12px}.flow-n{width:25px;height:25px;border:1px solid rgba(255,255,255,.3);border-radius:50%;display:grid;place-items:center;font-size:10px;font-weight:700;flex:none}.side-foot{font-size:10px;color:#a8cfb8;line-height:1.6;border-top:1px solid rgba(255,255,255,.14);padding-top:17px}.side-foot strong{display:block;color:#e8f5ee;font-weight:700;font-size:11px}.auth-main{padding:48px 62px;display:flex;align-items:center}.auth-card{width:100%;max-width:475px;margin:auto}.eyebrow{font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:#198754;font-weight:800;margin-bottom:7px}.auth-card h1{font-size:31px;margin:0 0 6px;letter-spacing:-.025em}.auth-card .lead{margin:0 0 24px;color:#69776f;font-size:13px}.role-tabs{display:grid;grid-template-columns:repeat(3,1fr);border:1px solid #dce7e0;border-radius:8px;padding:3px;margin-bottom:22px;background:#f5f8f6}.role-tab{border:0;background:transparent;border-radius:6px;padding:10px 6px;font-weight:700;font-size:12px;color:#68766e;cursor:pointer}.role-tab.active{background:#198754;color:#fff;box-shadow:0 3px 9px rgba(25,135,84,.2)}.field{margin-bottom:15px}.field label{display:block;font-size:10px;text-transform:uppercase;letter-spacing:.06em;color:#59675f;margin-bottom:6px;font-weight:800}.field input{width:100%;height:43px;padding:0 12px;border:1px solid #d9e3dd;border-radius:7px;font-size:13px;color:#1c2922;background:#fff;outline:none}.field input:focus{border-color:#198754;box-shadow:0 0 0 3px rgba(25,135,84,.1)}.password-wrap{position:relative}.password-wrap input{padding-right:80px}.toggle-pass{position:absolute;right:10px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:#198754;font-size:11px;font-weight:700;cursor:pointer}.remember{display:flex;align-items:center;gap:7px;font-size:11.5px;color:#68766e;margin:2px 0 20px}.remember input{accent-color:#198754}.submit{width:100%;height:44px;border:0;border-radius:7px;background:#198754;color:#fff;font-weight:800;font-size:13px;cursor:pointer;box-shadow:0 5px 13px rgba(25,135,84,.18)}.submit:hover{background:#146c43}.demo{margin-top:18px;padding:11px 12px;background:#f4f8f5;border:1px solid #dfeae3;border-radius:7px;color:#66746c;font-size:10.5px;line-height:1.6}.demo strong{color:#26342c;font-weight:800}.mono{font-family:ui-monospace,SFMono-Regular,Menlo,monospace}.alert{margin-bottom:16px;padding:10px 12px;border-radius:7px;font-size:12px}.alert-error{background:#fdebea;color:#b93830;border:1px solid #f2cfcc}@media(max-width:760px){.auth-page{padding:0}.auth-shell{border:0;border-radius:0;grid-template-columns:1fr;min-height:100vh}.auth-side{display:none}.auth-main{padding:32px 22px}.auth-card h1{font-size:28px}}
</style>
</head>
<body>
<div class="auth-page">
  <div class="auth-shell">
    <aside class="auth-side">
      <div>
        <div class="brand"><span class="brand-mark"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 17V8h4v9H5Zm5 0V5h4v12h-4Zm5 0v-6h4v6h-4Z" fill="currentColor"/><path d="M4 20h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span><span style="color:#fff">SIM<span>PM</span></span></div>
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
        <div class="eyebrow">Akses sistem</div><h1>Masuk ke SIMPM</h1><p class="lead">Pilih peran, lalu masukkan akun Anda untuk melanjutkan.</p>
        @if($errors->any())<div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('login.attempt') }}">
          @csrf
          <input type="hidden" name="role" id="loginRole" value="{{ old('role','supervisor') }}">
          <div class="role-tabs">
            <button type="button" class="role-tab {{ old('role','supervisor')==='supervisor' ? 'active':'' }}" data-role="supervisor">Supervisor</button>
            <button type="button" class="role-tab {{ old('role')==='teknisi' ? 'active':'' }}" data-role="teknisi">Teknisi</button>
            <button type="button" class="role-tab {{ old('role')==='manajer' ? 'active':'' }}" data-role="manajer">Manajer</button>
          </div>
          <div class="field"><label>Email</label><input type="email" name="email" id="loginEmail" value="{{ old('email') }}" placeholder="nama@simpm.local" required autofocus></div>
          <div class="field"><label>Password</label><div class="password-wrap"><input type="password" name="password" id="loginPassword" placeholder="Masukkan password" required><button type="button" class="toggle-pass" id="togglePass">Tampilkan</button></div></div>
          <label class="remember"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
          <button class="submit" type="submit">Masuk sebagai <span id="roleText">{{ ucfirst(old('role','supervisor')) }}</span></button>
        </form>
        <div class="demo"><strong>Akun demo</strong><br>Supervisor: supervisor@simpm.local · Teknisi: budi@simpm.local · Manajer: manajer@simpm.local<br>Password: <span class="mono">password123</span></div>
      </div>
    </main>
  </div>
</div>
<script>
const accounts={supervisor:'supervisor@simpm.local',teknisi:'budi@simpm.local',manajer:'manajer@simpm.local'};const labels={supervisor:'Supervisor',teknisi:'Teknisi',manajer:'Manajer'};
document.querySelectorAll('.role-tab').forEach(btn=>btn.addEventListener('click',()=>{const role=btn.dataset.role;document.getElementById('loginRole').value=role;document.getElementById('loginEmail').value=accounts[role];document.getElementById('roleText').textContent=labels[role];document.querySelectorAll('.role-tab').forEach(b=>b.classList.toggle('active',b===btn));}));
document.getElementById('togglePass').addEventListener('click',()=>{const input=document.getElementById('loginPassword');const show=input.type==='password';input.type=show?'text':'password';document.getElementById('togglePass').textContent=show?'Sembunyikan':'Tampilkan';});
</script>
</body>
</html>
