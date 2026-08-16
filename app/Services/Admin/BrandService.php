<?php

namespace App\Services\Admin;

use App\Models\Brand;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandService
{
    public function getBrands(array $filters = []): LengthAwarePaginator
    {
        $query = Brand::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        match ($filters['sort'] ?? 'latest') {
            'a_z' => $query->orderBy('name'),
            'z_a' => $query->orderByDesc('name'),
            'latest' => $query->latest('created_at'),
            'oldest' => $query->oldest('created_at'),
            'active' => $query
                ->where('status', true)
                ->latest('created_at'),
            'inactive' => $query
                ->where('status', false)
                ->latest('created_at'),
            default => $query->latest('created_at'),
        };

        $perPage = (int) ($filters['per_page'] ?? 10);

        return $query
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Brand
    {
        $data['slug'] = $this->generateSlug($data['name']);

        if (
            isset($data['logo']) &&
            $data['logo'] instanceof UploadedFile
        ) {
            $data['logo'] = $data['logo']->store(
                'brands',
                'public'
            );
        }

        return Brand::create($data);
    }

    public function update(Brand $brand, array $data): Brand
    {
        if ($brand->name !== $data['name']) {
            $data['slug'] = $this->generateSlug(
                $data['name'],
                $brand->id
            );
        }

        if (
            isset($data['logo']) &&
            $data['logo'] instanceof UploadedFile
        ) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }

            $data['logo'] = $data['logo']->store(
                'brands',
                'public'
            );
        }

        $brand->update($data);

        return $brand->refresh();
    }

    public function delete(Brand $brand): bool
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        return $brand->delete();
    }

    protected function generateSlug(
        string $name,
        ?int $brandId = null
    ): string {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (
            Brand::query()
                ->where('slug', $slug)
                ->when(
                    $brandId,
                    fn ($query) => $query->where('id', '!=', $brandId)
                )
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}