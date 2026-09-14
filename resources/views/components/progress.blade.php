@props(['value', 'color' => 'blue', 'label' => null])
<div>
  @if($label)<div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:4px;"><span>{{ $label }}</span><span class="mono">{{ $value !== null ? number_format($value,1).'%' : 'Belum tersedia' }}</span></div>@endif
  <div class="progress-track"><div class="progress-fill {{ $color }}" style="width: {{ $value !== null ? min(100,$value) : 0 }}%"></div></div>
</div>
