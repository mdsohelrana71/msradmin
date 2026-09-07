<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\Slider;
use App\Services\Admin\SliderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SliderController extends Controller implements HasMiddleware
{
    public function __construct(
        private SliderService $sliderService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:sliders.view', only: ['index', 'edit']),
            new Middleware('permission:sliders.create', only: ['create', 'store']),
            new Middleware('permission:sliders.edit', only: ['update']),
            new Middleware('permission:sliders.delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View|JsonResponse
    {
        $sliders = $this->sliderService->getSliders($request);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.Sliders.partials.table', compact('sliders'))->render(),
            ]);
        }

        return view('admin.Sliders.index', compact('sliders'));
    }

    public function create(): View
    {
        return view('admin.sliders.create');
    }

    public function store(SliderRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        $this->sliderService->create(
            $data,
            $request->file('image'),
            $request->file('mobile_image')
        );

        return redirect()
            ->route('admin.sliders.index')
            ->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(SliderRequest $request, Slider $slider): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        $this->sliderService->update(
            $slider,
            $data,
            $request->file('image'),
            $request->file('mobile_image')
        );

        return redirect()
            ->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        $this->sliderService->delete($slider);

        return redirect()
            ->route('admin.sliders.index')
            ->with('success', 'Slider deleted successfully.');
    }
}