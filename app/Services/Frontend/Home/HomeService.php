<?php
namespace App\Services\Frontend\Home;
use App\Services\Frontend\DesignManager;
use InvalidArgumentException;
class HomeService
{
    protected DesignManager $designManager;
    protected DesignOneHomeService $designOneHomeService;
    protected DesignTwoHomeService $designTwoHomeService;
    public function __construct(
        DesignManager $designManager,
        DesignOneHomeService $designOneHomeService,
        DesignTwoHomeService $designTwoHomeService
    ) {
        $this->designManager = $designManager;
        $this->designOneHomeService = $designOneHomeService;
        $this->designTwoHomeService = $designTwoHomeService;
    }
    public function getHomeData(): array
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneHomeService->getData(),
            'design-2' => $this->designTwoHomeService->getData(),
            default => throw new InvalidArgumentException('Home design service not found.'),
        };
    }
}