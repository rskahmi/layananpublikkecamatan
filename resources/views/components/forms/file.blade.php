{{-- @props([
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

<div class="custom-file-input ">
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
</div> --}}






{{-- @props([
    'label',
    'name',
    'placeholder' => 'Pilih file',
    'isRequired' => true,
])

<x-forms.label
    name="{{ $name }}"
    isRequired="{{ $isRequired }}"
    label="{{ $label }}"
/>

<div class="custom-file-input-wrapper">
    <input
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $isRequired ? 'required' : '' }}
        class="custom-file-input"
    >

    <label for="{{ $name }}" class="custom-file-label {{ $name }} text-break">
        <x-svg.icon.cloud /> {{ $placeholder }}
    </label>
</div>

<style>
.custom-file-input-wrapper {
    position: relative;
    width: 100%;
    height: 60px;
    margin-top: 0.5rem;
}

.custom-file-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 2;
    cursor: pointer;
}

.custom-file-label {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 0.5rem;
    z-index: 1;
    pointer-events: none;
    font-weight: 500;
}
</style> --}}




@props([
    'label',
    'name',
    'placeholder' => 'Upload File',
    'isRequired' => true,
])

<x-forms.label
    name="{{ $name }}"
    isRequired="{{ $isRequired }}"
    label="{{ $label }}"
/>

<div class="custom-file-input-wrapper">
    <input
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $isRequired ? 'required' : '' }}
        class="custom-file-input"
    >

    <label for="{{ $name }}" class="custom-file-label {{ $name }} text-break">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon-cloud" viewBox="0 0 24 24">
            <path fill="blue" d="M19 15a4 4 0 0 0 0-8 5.373 5.373 0 0 0-1.242.14A6.006 6.006 0 0 0 6 9a4 4 0 1 0 1 7.874V17h11v-2h1z"/>
        </svg>
        <span class="file-placeholder">{{ $placeholder }}</span>
    </label>
</div>

<style>
.custom-file-input-wrapper {
    position: relative;
    width: 100%;
    height: 60px;
    margin-top: 0.5rem;
}

.custom-file-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 2;
    cursor: pointer;
    
}

.custom-file-label {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    padding-left: 1rem;
    gap: 10px;
    background: #ffffff;
    border: 1px solid #ccc;
    border-radius: 10px;
    z-index: 1;
    pointer-events: none;
    color: #666;
}

.custom-file-label .icon-cloud {
    width: 24px;
    height: 24px;
    fill: blue;
}

.custom-file-label .file-placeholder {
    font-weight: normal; /* Ini membuat tulisan tidak bold */
}
</style>

