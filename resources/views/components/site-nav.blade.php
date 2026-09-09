@props(['items'])

<nav {{ $attributes->merge(['class' => 'nav']) }}>
    @foreach($items as $item)
        <a href="{{ $item['href'] }}" @class(['is-active' => $item['active'] ?? $loop->first])>{{ $item['label'] }}</a>
    @endforeach
</nav>
