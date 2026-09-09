<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PromoRequest;
use App\Models\Promo;
use App\Services\Admin\PromoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PromoController extends Controller implements HasMiddleware
{
    public function __construct(
        protected PromoService $promoService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:promos.view', only: ['index', 'show', 'edit']),
            new Middleware('permission:promos.create', only: ['create', 'store']),
            new Middleware('permission:promos.edit', only: ['update']),
            new Middleware('permission:promos.delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View|JsonResponse
    {
        $promos = $this->promoService->getAll();
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.Promos.partials.table', compact('promos'))->render(),
            ]);
        }
        return view('admin.Promos.index', compact('promos'));
    }

    public function create(): View
    {
        return view('admin.Promos.create');
    }

    public function store(PromoRequest $request): RedirectResponse
    {
        $this->promoService->create($request->validated());

        return redirect()
            ->route('admin.promos.index')
            ->with('success', 'Promo created successfully.');
    }

    public function show(Promo $promo): View
    {
        $promo = $this->promoService->getById($promo->id);

        return view('admin.Promos.show', compact('promo'));
    }

    public function edit(Promo $promo): View
    {
        $promo = $this->promoService->getById($promo->id);

        return view('admin.Promos.edit', compact('promo'));
    }

    public function update(PromoRequest $request, Promo $promo): RedirectResponse
    {
        $this->promoService->update($promo, $request->validated());

        return redirect()
            ->route('admin.promos.index')
            ->with('success', 'Promo updated successfully.');
    }

    public function destroy(Promo $promo): RedirectResponse
    {
        $this->promoService->delete($promo);

        return redirect()
            ->route('admin.promos.index')
            ->with('success', 'Promo deleted successfully.');
    }
}