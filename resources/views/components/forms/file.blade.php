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
<div class="custom-file-input">
    <div class="icon">
        <x-svg.icon.cloud />
    </div>
    <input
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        style="display: none;"
        >
    <label
        id="fileLabel"
        class="{{$name}} text-break"
        for="{{ $name }}">
        {{ $placeholder }}
    </label>
</div>
