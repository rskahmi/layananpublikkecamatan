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
<div class="input-with-icon">
    <i class="icon">
        <x-svg.icon.calendar />
    </i>
    <input
        type="text"
        name="{{$name}}"
        id="{{$name}}"
        class="form-control"
        placeholder="{{ $placeholder }}"
        autocomplete="off"
        data-toggle="datepicker"
        @if ($isRequired)
            required
        @endif
        >
</div>

