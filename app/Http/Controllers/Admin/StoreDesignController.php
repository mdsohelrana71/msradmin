<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDesignRequest;
use App\Services\Admin\StoreDesignService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StoreDesignController extends Controller implements HasMiddleware
{
    protected StoreDesignService $service;

    public function __construct(StoreDesignService $service)
    {
        $this->service = $service;
    }

    /**
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:store-designs.view', only: ['index', 'edit']),
            new Middleware('permission:store-designs.edit', only: ['update']),
        ];
    }

    public function index()
    {
        $sections = $this->service->getSections();
        $selectedDesigns = $this->service->getSelectedDesigns();

        return view('admin.StoreDesign.index', compact('sections', 'selectedDesigns'));
    }

    public function edit(string $section)
    {
        $sectionData = $this->service->getSection($section);
        $designs = $this->service->getDesigns($section);
        $selectedDesign = $this->service->getSelectedDesign($section);

        return view('admin.StoreDesign.edit', compact(
            'section',
            'sectionData',
            'designs',
            'selectedDesign'
        ));
    }

    public function update(StoreDesignRequest $request, string $section)
    {
        $this->service->updateDesign($section, $request->validated()['design']);

        return redirect()
            ->route('admin.store-designs.edit', $section)
            ->with('success', 'Store design updated successfully.');
    }
}