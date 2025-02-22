@props([
    'title' => '',
    'subtitle'  => '',
    'id'  => ''
])

<div class="popup-text">
    <h6>{{ $title }}</h6>
    <p
        @if ($id !== "")
            id="{{ $id }}"
        @endif
    >
    {!! $subtitle !!}</p>
</div>
