<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SIMPM PG Rendeng</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
.splash{min-height:100vh;background:#1f2933;color:#fff;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}.splash:before{content:'';position:absolute;inset:auto -10% -28%;height:55%;background:#26333d;transform:skewY(-5deg)}.splash-inner{position:relative;text-align:center;z-index:1;padding:30px}.splash-logo{font:600 72px 'Barlow Condensed',sans-serif;letter-spacing:1px}.splash-logo span{color:#6ea5d8}.splash-title{margin:8px 0 0;font:500 18px 'Barlow Condensed',sans-serif;color:#d5dbe0}.splash-sub{margin:7px 0 0;color:#8f9ba6;font-size:11px;letter-spacing:.04em}.loader{width:240px;height:3px;background:#35434e;border-radius:10px;margin:42px auto 0;overflow:hidden}.loader span{display:block;width:35%;height:100%;background:#6ea5d8;animation:load 1.8s ease-in-out infinite}@keyframes load{0%{transform:translateX(-120%)}100%{transform:translateX(700%)}}.splash-foot{margin-top:14px;color:#687580;font-size:10px}@media(max-width:600px){.splash-logo{font-size:58px}.splash-title{font-size:16px}}
</style>
</head>
<body>
<div class="splash">
  <div class="splash-inner">
    <div class="splash-logo">SIM<span>PM</span></div>
    <div class="splash-title">Sistem Monitoring Performa Mesin &amp; Maintenance</div>
    <div class="splash-sub">PABRIK GULA RENDENG</div>
    <div class="loader"><span></span></div>
    <div class="splash-foot">Menyiapkan sistem...</div>
  </div>
</div>
<script>setTimeout(function(){window.location.href='{{ route('login') }}';},1800);</script>
</body>
</html>
