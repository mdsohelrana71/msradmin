<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\NewsletterSubscribeRequest;
use App\Services\Frontend\Global\NewsletterService;
class NewsletterController extends Controller
{
    public function __construct(
        protected NewsletterService $newsletterService
    ) {}
    public function subscribe(NewsletterSubscribeRequest $request)
    {
        $result = $this->newsletterService->subscribe(
            $request->validated('email')
        );
        return response()->json($result);
    }
}