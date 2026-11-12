@props(['label', 'value', 'color' => 'text-blue-600'])

<div class="info-card stat-card">
    <div class="stat-label">{{ $label }}</div>
    <div class="stat-value {{ $color }}">{{ $value }}</div>
</div>
