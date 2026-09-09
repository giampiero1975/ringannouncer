@props(['previousLabel', 'nextLabel'])

<div class="carousel-controls">
    <button class="carousel-btn" type="button" data-carousel-prev aria-label="{{ $previousLabel }}">‹</button>
    <button class="carousel-btn" type="button" data-carousel-next aria-label="{{ $nextLabel }}">›</button>
</div>
