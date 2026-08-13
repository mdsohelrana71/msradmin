@foreach ($categories as $category)
    @if (!in_array($category->id, $excludedIds))
        @php
            $hasChildren = $category->children->isNotEmpty();
            $isSelected = (int) $selectedParent === (int) $category->id;

            $hasSelectedChild = $category->children->contains(function ($child) use ($selectedParent, $excludedIds) {
                if (in_array($child->id, $excludedIds)) {
                    return false;
                }

                if ((int) $child->id === (int) $selectedParent) {
                    return true;
                }

                return $child->children->contains(function ($nestedChild) use ($selectedParent, $excludedIds) {
                    return !in_array($nestedChild->id, $excludedIds)
                        && (int) $nestedChild->id === (int) $selectedParent;
                });
            });
        @endphp

        <div class="category-tree-item">
            <div class="category-option-row">
                <label class="category-option">
                    <input
                        type="radio"
                        name="parent_id"
                        value="{{ $category->id }}"
                        @checked($isSelected)
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
                        data-bs-target="#parent-category-{{ $category->id }}"
                        aria-expanded="{{ $hasSelectedChild ? 'true' : 'false' }}"
                    >
                        <i class="fas {{ $hasSelectedChild ? 'fa-minus' : 'fa-plus' }}"></i>
                    </button>
                @endif
            </div>

            @if ($hasChildren)
                <div
                    class="collapse category-children {{ $hasSelectedChild ? 'show' : '' }}"
                    id="parent-category-{{ $category->id }}"
                >
                    @include(
                        'admin.Product.Category.partials.parent-tree',
                        [
                            'categories' => $category->children,
                            'selectedParent' => $selectedParent,
                            'excludedIds' => $excludedIds,
                        ]
                    )
                </div>
            @endif
        </div>
    @endif
@endforeach