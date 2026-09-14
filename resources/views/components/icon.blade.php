@props(['name'])
@php
$icons = [
  'dashboard' => 'M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z',
  'monitor' => 'M3 4h18v12H3zM8 20h8M12 16v4',
  'detail' => 'M4 4h16v16H4zM8 9h8M8 13h5',
  'station' => 'M4 21V9l8-6 8 6v12M9 21v-6h6v6',
  'schedule' => 'M4 5h16v16H4zM4 9h16M8 3v4M16 3v4',
  'check' => 'M20 6L9 17l-5-5',
  'history' => 'M3 12a9 9 0 1 0 3-6.7M3 4v5h5',
  'report' => 'M6 3h9l5 5v13H6zM14 3v5h5M8 13h8M8 17h8',
  'calendar' => 'M4 5h16v16H4zM4 9h16M8 3v4M16 3v4',
  'profile' => 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM4 21a8 8 0 0 1 16 0',
  'logout' => 'M9 21H4V3h5M16 17l5-5-5-5M20 12H9',
];
$d = $icons[$name] ?? $icons['dashboard'];
@endphp
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $d }}"/></svg>
