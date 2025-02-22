@props(['id' => 'dataTable'])

<div class="table-responsive">
    <table id="{{ $id }}" class="display table dataTable">
        <thead>
            {{ $slotHeading }}
        </thead>
        <tbody>
            {{ $slotBody }}
        </tbody>
    </table>
</div>
