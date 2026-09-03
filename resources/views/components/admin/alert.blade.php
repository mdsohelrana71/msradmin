@if (session('success'))
    <div
        class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow"
        id="successAlert"
        style="z-index: 9999; min-width: 300px;"
        role="alert"
    >
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
@endif

@if ($errors->any())
    <div
        class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow"
        id="errorAlert"
        style="z-index: 9999; min-width: 350px; max-width: 500px;"
        role="alert"
    >
        <div class="fw-medium mb-2">
            <i class="fas fa-exclamation-circle me-2"></i>
            Please fix the following errors:
        </div>

        <ul class="mb-0 ps-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
@endif