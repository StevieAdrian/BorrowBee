<div class="toast-container position-absolute top-0 end-0 p-3">
    <div class="toast {{ $type === 'success' ? 'text-white' : 'bg-danger text-white' }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="10000" style="background-color: {{ $type === 'success' ? '#199d45' : '#dc3545' }};">
        <div class="d-flex">
            <div class="toast-body fw-semibold">
                {{ $message }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
