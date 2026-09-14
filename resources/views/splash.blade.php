<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SIMPM PG Rendeng</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
.splash{min-height:100vh;background:linear-gradient(135deg,#0d3b27 0%,#145c3b 52%,#198754 100%);color:#fff;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.splash:before,.splash:after{content:'';position:absolute;border:1px solid rgba(255,255,255,.11);border-radius:50%;animation:float 7s ease-in-out infinite}.splash:before{width:520px;height:520px;right:-190px;top:-190px}.splash:after{width:380px;height:380px;left:-170px;bottom:-170px;animation-delay:-2s}
.splash-inner{position:relative;text-align:center;z-index:1;padding:30px;width:min(620px,90vw)}
.splash-logo-mark{width:78px;height:78px;margin:0 auto 22px;border-radius:18px;background:#fff;color:#198754;display:grid;place-items:center;box-shadow:0 18px 45px rgba(0,0,0,.18);animation:logo-in .65s ease both}.splash-logo-mark svg{width:45px;height:45px}
.splash-logo{font:700 64px/1 Inter, sans-serif;letter-spacing:-.045em}.splash-logo span{color:#a9e6c3}.splash-title{margin:10px 0 0;font:500 17px Inter,sans-serif;color:#edf8f2}.splash-sub{margin:8px 0 0;color:#b9dbc8;font-size:11px;letter-spacing:.13em;font-weight:700}
.loader{width:260px;height:4px;background:rgba(255,255,255,.18);border-radius:10px;margin:38px auto 0;overflow:hidden}.loader span{display:block;width:35%;height:100%;background:#fff;border-radius:10px;animation:load 1.8s ease-in-out infinite}.splash-foot{margin-top:13px;color:#b3d3c1;font-size:10px}.dots{display:inline-flex;gap:4px;margin-left:4px;vertical-align:middle}.dots i{width:3px;height:3px;background:#cdebd8;border-radius:50%;animation:dot 1s infinite}.dots i:nth-child(2){animation-delay:.15s}.dots i:nth-child(3){animation-delay:.3s}
@keyframes load{0%{transform:translateX(-120%)}100%{transform:translateX(750%)}}@keyframes float{50%{transform:translateY(18px) scale(1.04)}}@keyframes logo-in{from{opacity:0;transform:translateY(12px) scale(.94)}to{opacity:1;transform:none}}@keyframes dot{0%,70%,100%{opacity:.3}35%{opacity:1}}
@media(max-width:600px){.splash-logo{font-size:50px}.splash-title{font-size:14px}.splash-logo-mark{width:68px;height:68px}}
</style>
</head>
<body>
<div class="splash">
  <div class="splash-inner">
    <div class="splash-logo-mark" aria-label="Logo SIMPM">
      <svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M10 34V14h7v20h-7Zm10 0V9h7v25h-7Zm10 0V18h7v16h-7Z" fill="currentColor"/><path d="M8 38h32" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
    </div>
    <div class="splash-logo">SIM<span>PM</span></div>
    <div class="splash-title">Sistem Monitoring Performa Mesin &amp; Maintenance</div>
    <div class="splash-sub">PABRIK GULA RENDENG</div>
    <div class="loader"><span></span></div>
    <div class="splash-foot">Menyiapkan sistem<span class="dots"><i></i><i></i><i></i></span></div>
  </div>
</div>
<script>setTimeout(function(){window.location.href='{{ route('login') }}';},2200);</script>
</body>
</html>
