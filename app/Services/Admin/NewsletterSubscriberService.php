<?php
namespace App\Services\Admin;
use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class NewsletterSubscriberService
{
    public function getSubscribers(array $filters = []): LengthAwarePaginator
    {
        return NewsletterSubscriber::query()
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('email', 'like', "%{$search}%");
            })
            ->when($filters['sort'] ?? null, function ($query, $sort) {
                match ($sort) {
                    'latest' => $query->latest('id'),
                    'oldest' => $query->oldest('id'),
                    'active' => $query->where('status', true)->latest('id'),
                    'inactive' => $query->where('status', false)->latest('id'),
                    default => $query->latest('id'),
                };
            }, function ($query) {
                $query->latest('id');
            })
            ->paginate(20)
            ->withQueryString();
    }
    public function update(NewsletterSubscriber $subscriber, array $data): NewsletterSubscriber
    {
        $subscriber->update($data);
        return $subscriber->refresh();
    }
    public function delete(NewsletterSubscriber $subscriber): void
    {
        $subscriber->delete();
    }
}