<?php

namespace App\Services\Frontend\Home;

use App\Services\Frontend\DesignManager;
use App\Services\Frontend\Global\FrontendService;
use InvalidArgumentException;

class HomeService
{
    protected DesignManager $designManager;
    protected FrontendService $frontendService;
    protected DesignOneHomeService $designOneHomeService;
    protected DesignTwoHomeService $designTwoHomeService;

    public function __construct(
        DesignManager $designManager,
        FrontendService $frontendService,
        DesignOneHomeService $designOneHomeService,
        DesignTwoHomeService $designTwoHomeService
    ) {
        $this->designManager = $designManager;
        $this->frontendService = $frontendService;
        $this->designOneHomeService = $designOneHomeService;
        $this->designTwoHomeService = $designTwoHomeService;
    }

    public function getHomeData(): array
    {
        $data = match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneHomeService->getData(),
            'design-2' => $this->designTwoHomeService->getData(),
            default => throw new InvalidArgumentException('Home design service not found.'),
        };

        return array_merge($data, $this->frontendService->getHomeData());
    }
}