@props([
    'id' => 'confirmModal',
    'formId' => null,
    'confirmAction' => null,
    'title' => 'Are you sure?',
    'message' => 'Are you sure you want to continue?',
    'confirmText' => 'Yes, Continue',
    'confirmClass' => 'btn-danger',
])

<div class="modal fade confirm-modal" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered confirm-modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="confirm-icon mb-2">
                    <i class="fa fa-exclamation"></i>
                </div>

                <h4 class="confirm-title mb-2" id="{{ $id }}Label">
                    {{ $title }}
                </h4>

                <p class="confirm-message mb-4">
                    {{ $message }}
                </p>

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn confirm-cancel-btn" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn {{ $confirmClass }} confirm-action-btn"
                        @if ($formId) onclick="document.getElementById('{{ $formId }}').submit()"
                        @elseif($confirmAction)
                            onclick="{{ $confirmAction }}" @endif>
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
