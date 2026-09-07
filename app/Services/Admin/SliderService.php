<?php

namespace App\Services\Admin;

use App\Models\Slider;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SliderService
{
    public function getSliders(Request $request)
    {
        return Slider::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('subtitle', 'like', "%{$search}%")
                        ->orWhere('button_text', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('sort'), function ($query) use ($request) {
                match ($request->sort) {
                    'a_z' => $query->orderBy('title'),
                    'z_a' => $query->orderByDesc('title'),
                    'latest' => $query->latest('id'),
                    'oldest' => $query->oldest('id'),
                    'active' => $query->where('status', true)->orderBy('sort_order'),
                    'inactive' => $query->where('status', false)->orderBy('sort_order'),
                    default => $query->orderBy('sort_order')->latest('id'),
                };
            }, function ($query) {
                $query->orderBy('sort_order')->latest('id');
            })
            ->paginate(15)
            ->withQueryString();
    }

    public function create(array $data, ?UploadedFile $image = null, ?UploadedFile $mobileImage = null): Slider
    {
        if ($image) {
            $data['image'] = $image->store('sliders', 'public');
        }

        if ($mobileImage) {
            $data['mobile_image'] = $mobileImage->store('sliders', 'public');
        }

        return Slider::create($data);
    }

    public function update(Slider $slider, array $data, ?UploadedFile $image = null, ?UploadedFile $mobileImage = null): Slider
    {
        if ($image) {
            $this->deleteImage($slider->image);
            $data['image'] = $image->store('sliders', 'public');
        }

        if ($mobileImage) {
            $this->deleteImage($slider->mobile_image);
            $data['mobile_image'] = $mobileImage->store('sliders', 'public');
        }

        $slider->update($data);

        return $slider->refresh();
    }

    public function delete(Slider $slider): bool
    {
        $this->deleteImage($slider->image);
        $this->deleteImage($slider->mobile_image);

        return $slider->delete();
    }

    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}