@props([
    'label',
    'name',
    'placeholder',
    'isRequired' => true,
    'type' => 'text',
    'value' => null
])

<x-forms.label
    name="{{ $name }}"
    isRequired="{{ $isRequired }}"
    label="{{ $label }}"
    />
<input
    type="{{ $type }}"
    class="form-control"
    id="{{ $name }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"

    @if ($isRequired)
    required
    @endif

    @if ($value != null)
        value="{{ $value }}"
    @endif
>


