@foreach ($categories as $category)
    <div class="category-item">
        <div class="category-row">
            {{-- Category Name + Expand --}}
            <div class="category-left">
                <span class="category-name">
                    {{ $category->name }}
                </span>

                @if ($category->children->isNotEmpty())
                    <button
                        type="button"
                        class="category-toggle"
                        data-bs-toggle="collapse"
                        data-bs-target="#category-children-{{ $category->id }}"
                        aria-expanded="false"
                        title="Show sub categories">
                        <i class="fas fa-plus"></i>
                    </button>
                @endif
            </div>

            {{-- Actions --}}
            <div class="category-actions">
                <a
                    href="{{ route(
                            'admin.blog-categories.edit',
                            $category
                        ) }}"
                    class="btn btn-sm btn-primary"
                    title="Edit">
                    <i class="fa fa-edit"></i>
                </a>

                <form
                    action="{{ route('admin.blog-categories.destroy', $category) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this category?')">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-sm btn-danger"
                        title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Children --}}
        @if ($category->children->isNotEmpty())
            <div class="collapse category-children" id="category-children-{{ $category->id }}">

                @include(
                'admin.Blog.Category.partials.tree',
                [
                'categories' => $category->children
                ]
                )

            </div>
        @endif
    </div>
@endforeach