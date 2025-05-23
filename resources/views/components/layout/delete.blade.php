@props(['action'])

<a href="##delete" class="btnDeleteData d-flex align-items-center justify-content-center">
    <form action="{{ $action }}" method="POST">
        @csrf
        @method('DELETE')
        <x-svg.icon.trash />
    </form>
</a>
