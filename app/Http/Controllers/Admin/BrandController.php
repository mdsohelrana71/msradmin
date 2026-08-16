<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\BrandService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\BrandRequest;

class BrandController extends Controller
{
    public function __construct(
        protected BrandService $brandService
    ) {}

    public function index(Request $request)
    {
        $brands = $this->brandService->getBrands($request->all());

        if ($request->ajax()) {
            $html = view(
                'admin.Brand.partials.table',
                compact('brands')
            )->render();

            return response()->json(['html' => $html]);
        }

        return view('admin.Brand.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.Brand.create');
    }

    public function store(BrandRequest $request): RedirectResponse
    {
        $this->brandService->create($request->validated());

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand): View
    {
        return view('admin.Brand.show', compact('brand'));
    }

    public function edit(Brand $brand): View
    {
        return view('admin.Brand.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        $this->brandService->update($brand, $request->validated());

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $this->brandService->delete($brand);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}