@php
    $hasChildren = $category->children->isNotEmpty();

    $isSelected = (int) $selectedCategory === (int) $category->id;

    $hasSelectedDescendant = function ($category) use (&$hasSelectedDescendant, $selectedCategory) {
        foreach ($category->children as $child) {
            if ((int) $child->id === (int) $selectedCategory) {
                return true;
            }

            if ($hasSelectedDescendant($child)) {
                return true;
            }
        }

        return false;
    };

    $isOpen = $isSelected || $hasSelectedDescendant($category);
@endphp

<div class="category-tree-item">
    <div class="category-option-row">
        <label class="category-option">
            <input
                type="radio"
                name="category_id"
                value="{{ $category->id }}"
                @checked($isSelected)
                required
            >

            <span class="category-check"></span>

            <span class="category-name">
                {{ $category->name }}
            </span>
        </label>

        @if ($hasChildren)
            <button
                type="button"
                class="category-toggle"
                data-bs-toggle="collapse"
                data-bs-target="#blog-category-{{ $category->id }}"
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
            >
                <i class="fas {{ $isOpen ? 'fa-minus' : 'fa-plus' }}"></i>
            </button>
        @endif
    </div>

    @if ($hasChildren)
        <div
            class="collapse category-children {{ $isOpen ? 'show' : '' }}"
            id="blog-category-{{ $category->id }}"
        >
            @foreach ($category->children as $child)
                @include('admin.Blog.partials.category-tree', [
                    'category' => $child,
                    'selectedCategory' => $selectedCategory,
                ])
            @endforeach
        </div>
    @endif
</div>