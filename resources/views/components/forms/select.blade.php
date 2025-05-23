@props([
    'label',
    'name',
    'placeholder',
    'isRequired' => true
])

<x-forms.label
    name="{{ $name }}"
    isRequired="{{ $isRequired }}"
    label="{{ $label }}"
    />
{{-- <select class="form-select" id="{{ $name }}" name="{{$name}}">
    <option selected>{{ $placeholder }}</option>
    {{ $slot }}
</select> --}}




<select {{ $attributes }}  id="{{ $name }}" name="{{ $name }}" class="form-control form-select">
    {{ $slot }}
</select>
