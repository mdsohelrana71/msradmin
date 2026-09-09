<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsletterSubscriberRequest;
use App\Models\NewsletterSubscriber;
use App\Services\Admin\NewsletterSubscriberService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class NewsletterSubscriberController extends Controller implements HasMiddleware
{
    public function __construct(
        protected NewsletterSubscriberService $newsletterSubscriberService
    ) {}
    public static function middleware(): array
    {
        return [
            new Middleware('permission:newsletter-subscribers.view', only: ['index', 'show', 'edit']),
            new Middleware('permission:newsletter-subscribers.edit', only: ['update']),
            new Middleware('permission:newsletter-subscribers.delete', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {
        $subscribers = $this->newsletterSubscriberService->getSubscribers([
            'search' => $request->get('search'),
            'sort' => $request->get('sort'),
        ]);
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.Newsletter.partials.table', compact('subscribers'))->render(),
            ]);
        }
        return view('admin.Newsletter.index', compact('subscribers'));
    }
    public function show(NewsletterSubscriber $newsletterSubscriber)
    {
        return view('admin.Newsletter.show', compact('newsletterSubscriber'));
    }
    public function edit(NewsletterSubscriber $newsletterSubscriber)
    {
        return view('admin.Newsletter.edit', compact('newsletterSubscriber'));
    }
    public function update(NewsletterSubscriberRequest $request, NewsletterSubscriber $newsletterSubscriber)
    {
        $this->newsletterSubscriberService->update(
            $newsletterSubscriber,
            $request->validated()
        );
        return redirect()->route('admin.newsletter-subscribers.index')
            ->with('success', 'Newsletter subscriber updated successfully.');
    }
    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $this->newsletterSubscriberService->delete($newsletterSubscriber);
        return redirect()->route('admin.newsletter-subscribers.index')
            ->with('success', 'Newsletter subscriber deleted successfully.');
    }
}