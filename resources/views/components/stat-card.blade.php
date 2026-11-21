@props(['label', 'value', 'detail' => null])
<div {{ $attributes->class(['tp-panel', 'tp-stat-card']) }}>
    <div class="tp-eyebrow">{{ $label }}</div>
    <div class="tp-stat-value">{{ $value }}</div>
    @if($detail)<p class="muted">{{ $detail }}</p>@endif
</div>
