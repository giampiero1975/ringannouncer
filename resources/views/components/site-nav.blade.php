@props(['items'])

<nav {{ $attributes->merge(['class' => 'nav']) }}>
    @foreach($items as $item)
        <a href="{{ $item['href'] }}" @class(['is-active' => $item['active'] ?? false])>{{ $item['label'] }}</a>
    @endforeach
</nav>
