<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\DesignManager;
use App\Services\Frontend\Home\HomeService;

class HomeController extends Controller
{
    protected DesignManager $designManager;
    protected HomeService $homeService;

    public function __construct(
        DesignManager $designManager,
        HomeService $homeService
    ) {
        $this->designManager = $designManager;
        $this->homeService = $homeService;
    }

    public function index()
    {
        $data = $this->homeService->getHomeData();

        return view(
            $this->designManager->getPageView('home'),
            $data
        );
    }
}