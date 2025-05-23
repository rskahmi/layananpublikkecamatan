@props([
    'label',
    'name',
    'isRequired' => true
])

<label
    for="{{ $name }}"
    class="form-label{{ ($isRequired) ? ' isRequired' : '' }}">
    {{ $label }}
</label>
