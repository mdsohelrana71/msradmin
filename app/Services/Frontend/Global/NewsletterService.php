<?php
namespace App\Services\Frontend\Global;
use App\Models\NewsletterSubscriber;
use Carbon\Carbon;
class NewsletterService
{
    public function subscribe(string $email): array
    {
        $subscriber = NewsletterSubscriber::where('email', $email)->first();
        if ($subscriber) {
            if ($subscriber->status) {
                return [
                    'success' => false,
                    'message' => 'This email is already subscribed to our newsletter.',
                ];
            }
            $subscriber->update([
                'status' => true,
                'subscribed_at' => Carbon::now(),
                'unsubscribed_at' => null,
            ]);
            return [
                'success' => true,
                'message' => 'You have successfully subscribed to our newsletter.',
            ];
        }
        NewsletterSubscriber::create([
            'email' => $email,
            'status' => true,
            'subscribed_at' => Carbon::now(),
            'unsubscribed_at' => null,
        ]);
        return [
            'success' => true,
            'message' => 'You have successfully subscribed to our newsletter.',
        ];
    }
}