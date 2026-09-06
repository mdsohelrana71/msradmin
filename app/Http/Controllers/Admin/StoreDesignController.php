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
        $templates = $this->service->getTemplates();
        $sections = $this->service->getSections();
        $activeTemplate = $this->service->getActiveTemplate();
        $selectedDesigns = $this->service->getSelectedDesigns();

        return view('admin.StoreDesign.index', compact(
            'templates',
            'sections',
            'activeTemplate',
            'selectedDesigns'
        ));
    }

    public function edit(string $section)
    {
        if ($section === 'template') {
            $templates = $this->service->getTemplates();
            $selectedDesign = $this->service->getActiveTemplate();

            return view('admin.StoreDesign.edit', [
                'section' => $section,
                'sectionData' => [
                    'label' => 'Store Template',
                ],
                'templates' => $templates,
                'selectedDesign' => $selectedDesign,
                'isTemplate' => true,
            ]);
        }

        $sectionData = $this->service->getSection($section);
        $templates = $this->service->getTemplates();
        $selectedDesign = $this->service->getSectionOverride($section);

        return view('admin.StoreDesign.edit', compact(
            'section',
            'sectionData',
            'templates',
            'selectedDesign'
        ) + ['isTemplate' => false]);
    }

    public function update(StoreDesignRequest $request, string $section)
    {
        $design = $request->validated()['design'] ?? null;

        if ($section === 'template') {
            $this->service->updateTemplate($design);
        } else {
            $this->service->updateSectionOverride($section, $design);
        }

        return redirect()
            ->route('admin.store-designs.edit', $section)
            ->with('success', 'Store design updated successfully.');
    }
}