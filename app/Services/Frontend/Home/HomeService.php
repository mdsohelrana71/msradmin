<?php

namespace App\Services\Frontend\Home;

use App\Services\Frontend\DesignManager;
use InvalidArgumentException;

class HomeService
{
    protected DesignManager $designManager;
    protected DesignOneHomeService $designOneHomeService;

    public function __construct(
        DesignManager $designManager,
        DesignOneHomeService $designOneHomeService
    ) {
        $this->designManager = $designManager;
        $this->designOneHomeService = $designOneHomeService;
    }

    public function getHomeData(): array
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneHomeService->getData(),
            default => throw new InvalidArgumentException('Home design service not found.'),
        };
    }
}