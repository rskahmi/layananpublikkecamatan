@props([
    'label',
    'name',
    'placeholder',
    'isRequired' => false,
    'value' => null
])

<x-forms.label
    name="{{ $name }}"
    isRequired="{{ $isRequired }}"
    label="{{ $label }}"
/>

<textarea
    class="form-control"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    style="height: 100px"
    id="{{ $name }}"
    @if ($isRequired) required @endif
>{{ old($name, $value) }}</textarea>
