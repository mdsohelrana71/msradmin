@foreach ($categories as $category)
    <div class="category-item">
        <div class="category-row">
            <div class="category-left">
                <span class="category-name">
                    <span class="category-title">
                        {{ $category->name }}
                    </span>

                    @if (!$category->status)
                        <span class="badge bg-warning ms-2">
                            Inactive
                        </span>
                    @endif
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

            <div class="category-actions">
                @can('blog_categories.edit')
                    <a
                        href="{{ route('admin.blog-categories.edit', $category) }}"
                        class="btn btn-sm btn-primary"
                        title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                @endcan

                @can('blog_categories.delete')
                    <form
                        id="deleteCategoryForm{{ $category->id }}"
                        action="{{ route('admin.blog-categories.destroy', $category) }}"
                        method="POST"
                        class="d-inline"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            title="Delete"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCategoryModal{{ $category->id }}"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>

                    <x-confirm-modal
                        id="deleteCategoryModal{{ $category->id }}"
                        formId="deleteCategoryForm{{ $category->id }}"
                        title="Delete Category?"
                        message="Are you sure you want to delete this category?"
                        confirmText="Yes, Delete"
                        confirmClass="btn-danger"
                    />
                @endcan
            </div>
        </div>

        @if ($category->children->isNotEmpty())
            <div
                class="collapse category-children"
                id="category-children-{{ $category->id }}">

                @include('admin.Blog.Category.partials.tree', [
                    'categories' => $category->children
                ])

            </div>
        @endif
    </div>
@endforeach