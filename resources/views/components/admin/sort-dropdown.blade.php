@props([
    'options' => [],
    'label' => 'Sort By',
    'icon' => 'fa fa-sort',
    'query' => 'sort',
])

<div class="dropdown">
    <button
        class="btn btn-light border dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        <i class="{{ $icon }} me-1"></i>
        {{ $label }}
    </button>

    <ul class="dropdown-menu dropdown-menu-end">
        @foreach ($options as $value => $text)
            <li>
                <a
                    class="dropdown-item {{ request($query) === $value ? 'active' : '' }}"
                    href="{{ request()->fullUrlWithQuery([$query => $value]) }}"
                >
                    {{ $text }}
                </a>
            </li>
        @endforeach
    </ul>
</div>