@foreach ($categories as $category)
    @if (!in_array($category->id, $excludedIds))
        <div class="category-tree-item">
            <div class="category-option-row">
                <label class="category-option">
                    <input
                        type="radio"
                        name="parent_id"
                        value="{{ $category->id }}"
                        {{ (string) $selectedParent === (string) $category->id
                            ? 'checked'
                            : '' }}
                    >
                    <span class="category-check"></span>
                    <span class="category-name">
                        {{ $category->name }}
                    </span>
                </label>

                @if ($category->children->isNotEmpty())
                    <button
                        type="button"
                        class="category-toggle"
                        data-bs-toggle="collapse"
                        data-bs-target="#parent-category-{{ $category->id }}"
                    >
                        <i class="fas fa-plus"></i>
                    </button>
                @endif
            </div>

            @if ($category->children->isNotEmpty())
                <div class="collapse category-children" id="parent-category-{{ $category->id }}">
                    @include(
                        'admin.Blog.Category.partials.parent-tree',
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