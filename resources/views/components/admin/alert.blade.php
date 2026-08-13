@if (session('success'))
    <div
        class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow"
        id="successAlert"
        style="z-index: 9999; min-width: 300px;"
        role="alert"
    >
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif