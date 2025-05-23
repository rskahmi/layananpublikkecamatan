@props([
    'modal' => '',
    'action' => '',
    'id' => "exampleModal",
    'isUpdate' => false,
    'class' => ''
])

@if ($action !== '')
    <form id="form-{{$id}}" action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($isUpdate)
            @method('PUT')
        @endif
@endif
<div class="modal fade admin" id="{{ $id }}" data-modal="{{ $modal }}" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ $class }}">
        <div class="modal-content">
            <div class="modal-header">
                {{ $slotHeader }}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slotBody }}
            </div>
            <div class="modal-footer">
                {{ $slotFooter }}
            </div>
        </div>
    </div>
</div>
@if ($action !== '')
    </form>
@endif
