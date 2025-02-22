@props([
    'header' => 'Jumlah Terprogram',
    'value' => 5000,
    'color' => 'green',
    'footer' => 'dari Program di tahun ini',
    'id' => ''
])

<div class="card summary">
    <div class="card-header">
        {{ $header }}
    </div>
    <div class="card-body d-flex align-items-center">
        {{ $slot }}
        <h5 class="{{ $color }}" @if ($id!=="")
        id="{{ $id }}"
        @endif>{{ $value }}</h5>
    </div>
    <div class="card-footer">
        {{ $footer ?? '' }}
    </div>
</div>
