@props(['id'])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-tutup-modal" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
