@props([
    'label',
    'name',
    'type' => 'js-states',
    'isRequired' => true
])

<x-forms.label
    name="{{ $name }}"
    isRequired="{{ $isRequired }}"
    label="{{ $label }}"
    />
<select
    class="form-select form-control {{ $type }}"
    style="width: 100%;"
    name="{{ $name }}"
    id="{{ $name }}"
>
    <option value=""></option>
    {{ $slot }}
</select>
