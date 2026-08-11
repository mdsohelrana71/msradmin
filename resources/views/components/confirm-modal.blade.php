@props([
    'id' => 'confirmModal',
    'formId' => null,
    'title' => 'Are you sure?',
    'message' => 'Are you sure you want to continue?',
    'confirmText' => 'Yes, Continue',
    'confirmClass' => 'btn-danger',
])

<div class="modal fade confirm-modal"
     id="{{ $id }}"
     tabindex="-1"
     aria-labelledby="{{ $id }}Label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered confirm-modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                {{-- Icon --}}
                <div class="confirm-icon mb-2">
                    <i class="fa fa-exclamation"></i>
                </div>

                {{-- Title --}}
                <h4 class="confirm-title mb-2" id="{{ $id }}Label">
                    {{ $title }}
                </h4>

                {{-- Message --}}
                <p class="confirm-message mb-4">
                    {{ $message }}
                </p>

                {{-- Buttons --}}
                <div class="d-flex justify-content-center gap-2">
                    <button type="button"
                            class="btn confirm-cancel-btn"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button"
                            class="btn {{ $confirmClass }} confirm-action-btn"
                            onclick="document.getElementById('{{ $formId }}').submit()">
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>