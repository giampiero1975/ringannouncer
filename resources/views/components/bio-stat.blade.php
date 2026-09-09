@props(['icon', 'value', 'label'])

<div class="stat">
    <i>{{ $icon }}</i>
    <div>
        <strong>{{ $value }}</strong>
        <span>{{ $label }}</span>
    </div>
</div>
