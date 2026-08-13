@props([
    'submitText' => 'Save',
    'cancelUrl' => null,
    'cancelText' => 'Cancel',
])

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save me-1"></i>
        {{ $submitText }}
    </button>

    @if ($cancelUrl)
        <a href="{{ $cancelUrl }}" class="btn btn-secondary">
            {{ $cancelText }}
        </a>
    @endif
</div>