@props([
    'id' => 'search',
    'placeholder' => 'Search...',
])

<div class="ms-auto module-header-search-box">
    <div class="input-group">
        <span class="input-group-text">
            <i class="fa fa-search"></i>
        </span>

        <input
            type="text"
            id="{{ $id }}"
            class="form-control"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
        >

        <button
            type="button"
            id="clear{{ ucfirst($id) }}"
            class="btn btn-light d-none"
            title="Clear search"
        >
            <i class="fa fa-times"></i>
        </button>
    </div>
</div>