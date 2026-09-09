<?php

namespace App\Services\Admin;

use App\Models\Promo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromoService
{
    public function getAll()
    {
        $query = Promo::with('buttons');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        match (request('sort')) {
            'a_z' => $query->orderBy('title'),
            'z_a' => $query->orderByDesc('title'),
            'latest' => $query->latest('id'),
            'oldest' => $query->oldest('id'),
            'active' => $query->where('status', true)->orderBy('sort_order'),
            'inactive' => $query->where('status', false)->orderBy('sort_order'),
            default => $query->orderBy('sort_order')->latest('id'),
        };
        return $query->paginate(10)->withQueryString();
    }

    public function getById(int $id): Promo
    {
        return Promo::with('buttons')->findOrFail($id);
    }

    public function create(array $data): Promo
    {
        return DB::transaction(function () use ($data) {
            $buttons = $data['buttons'] ?? [];
            unset($data['buttons']);
            $data['created_by'] = Auth::id();
            $promo = Promo::create($data);
            $this->syncButtons($promo, $buttons);
            return $promo->load('buttons');
        });
    }

    public function update(Promo $promo, array $data): Promo
    {
        return DB::transaction(function () use ($promo, $data) {
            $buttons = $data['buttons'] ?? [];
            unset($data['buttons']);
            $data['updated_by'] = Auth::id();
            $promo->update($data);
            $this->syncButtons($promo, $buttons);
            return $promo->load('buttons');
        });
    }

    public function delete(Promo $promo): bool
    {
        return DB::transaction(function () use ($promo) {
            return $promo->delete();
        });
    }

    private function syncButtons(Promo $promo, array $buttons): void
    {
        $existingButtonIds = [];
        foreach ($buttons as $buttonData) {
            $buttonId = $buttonData['id'] ?? null;
            unset($buttonData['id']);
            if ($buttonId) {
                $button = $promo->buttons()->findOrFail($buttonId);
                $buttonData['updated_by'] = Auth::id();
                $button->update($buttonData);
                $existingButtonIds[] = $button->id;
            } else {
                $buttonData['created_by'] = Auth::id();
                $button = $promo->buttons()->create($buttonData);
                $existingButtonIds[] = $button->id;
            }
        }
        if (empty($existingButtonIds)) {
            $promo->buttons()->delete();
        } else {
            $promo->buttons()->whereNotIn('id', $existingButtonIds)->delete();
        }
    }
}