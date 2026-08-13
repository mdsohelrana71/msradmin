<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    /**
     * Get category tree.
     */
    public function getTree(string $type): Collection
    {
        $categories = Category::query()
            ->where('type', $type)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return $this->buildTree($categories);
    }


    /**
     * Create category.
     */
    public function create(
        array $data,
        string $type
    ): Category {
        $this->validateParent(
            $data['parent_id'] ?? null,
            $type
        );

        $data['type'] = $type;

        $data['slug'] = $this->generateUniqueSlug(
            $data['name'],
            $type
        );

        return Category::create($data);
    }


    /**
     * Update category.
     */
    public function update(
        Category $category,
        array $data,
        string $type
    ): Category {
        $this->validateParent(
            $data['parent_id'] ?? null,
            $type,
            $category
        );

        $data['slug'] = $this->generateUniqueSlug(
            $data['name'],
            $type,
            $category
        );

        $category->update($data);

        return $category->fresh();
    }


    /**
     * Delete category.
     */
    public function delete(Category $category): bool
    {
        if ($category->children()->exists()) {
            throw ValidationException::withMessages([
                'category' =>
                    'This category has sub-categories. Delete or move them first.',
            ]);
        }

        return $category->delete();
    }


    /**
     * Get descendant category IDs.
     *
     * Used when editing a category so that
     * the category and its children cannot
     * be selected as its own parent.
     */
    public function getDescendantIdsForEdit(
        Category $category
    ): array {
        $categories = Category::query()
            ->where('type', $category->type)
            ->get();

        return $this->getDescendantIds(
            $categories,
            $category->id
        );
    }


    /**
     * Build unlimited category tree.
     */
    private function buildTree(
        Collection $categories,
        ?int $parentId = null
    ): Collection {
        return $categories
            ->where('parent_id', $parentId)
            ->map(function (Category $category) use ($categories) {

                $category->setRelation(
                    'children',
                    $this->buildTree(
                        $categories,
                        $category->id
                    )
                );

                return $category;
            })
            ->values();
    }


    /**
     * Validate parent category.
     */
    private function validateParent(
        ?int $parentId,
        string $type,
        ?Category $category = null
    ): void {
        /*
        |--------------------------------------------------------------------------
        | No Parent
        |--------------------------------------------------------------------------
        */

        if (!$parentId) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Parent must belong to the same category type
        |--------------------------------------------------------------------------
        */

        $parent = Category::query()
            ->where('id', $parentId)
            ->where('type', $type)
            ->first();


        if (!$parent) {
            throw ValidationException::withMessages([
                'parent_id' => 'Invalid parent category.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Category cannot be its own parent
        |--------------------------------------------------------------------------
        */

        if (
            $category &&
            $parent->id === $category->id
        ) {
            throw ValidationException::withMessages([
                'parent_id' =>
                    'A category cannot be its own parent.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Category cannot be moved inside its own descendant
        |--------------------------------------------------------------------------
        */

        if ($category) {

            $descendantIds = $this->getDescendantIdsForEdit(
                $category
            );

            if (in_array(
                $parent->id,
                $descendantIds,
                true
            )) {
                throw ValidationException::withMessages([
                    'parent_id' =>
                        'A category cannot be moved inside its own child category.',
                ]);
            }
        }
    }


    /**
     * Get all descendant IDs recursively.
     */
    private function getDescendantIds(
        Collection $categories,
        int $parentId
    ): array {
        $ids = [];

        foreach (
            $categories->where('parent_id', $parentId)
            as $child
        ) {

            $ids[] = $child->id;

            $ids = array_merge(
                $ids,
                $this->getDescendantIds(
                    $categories,
                    $child->id
                )
            );
        }

        return $ids;
    }


    /**
     * Generate unique slug.
     */
    private function generateUniqueSlug(
        string $name,
        string $type,
        ?Category $category = null
    ): string {
        $slug = Str::slug($name);

        $original = $slug;

        $counter = 1;


        while (
            Category::query()
                ->where('type', $type)
                ->where('slug', $slug)
                ->when(
                    $category,
                    fn ($query) =>
                        $query->where(
                            'id',
                            '!=',
                            $category->id
                        )
                )
                ->exists()
        ) {
            $slug = $original . '-' . $counter;

            $counter++;
        }


        return $slug;
    }
}