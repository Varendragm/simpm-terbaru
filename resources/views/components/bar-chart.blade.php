@props(['items', 'unit' => ''])
@php
  $max = collect($items)->max('value') ?: 1;
@endphp
<div class="bar-chart">
  @forelse($items as $item)
    <div class="bar-row">
      <span title="{{ $item['label'] }}">{{ \Illuminate\Support\Str::limit($item['label'], 16) }}</span>
      <div class="bar-track"><div class="bar-fill" style="width: {{ max(2, round(($item['value']/$max)*100)) }}%"></div></div>
      <span class="mono">{{ is_numeric($item['value']) ? rtrim(rtrim(number_format($item['value'],1,'.',''), '0'), '.') : $item['value'] }}{{ $unit }}</span>
    </div>
  @empty
    <p class="empty-state">Belum ada data untuk ditampilkan.</p>
  @endforelse
</div>
