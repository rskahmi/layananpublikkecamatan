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
<select
    class="form-select"
    id="{{ $name }}"
    name="{{$name}}"
    >
    <option selected>{{ $placeholder }}</option>
    {{ $slot }}
</select>
