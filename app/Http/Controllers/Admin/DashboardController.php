<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $service
    ) {}

    public function index()
    {
        $stats = $this->service->getStats();

        return view(
            'admin.dashboard',
            compact('stats')
        );
    }
}