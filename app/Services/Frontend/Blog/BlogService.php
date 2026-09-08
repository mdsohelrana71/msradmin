<?php
namespace App\Services\Frontend\Blog;
use App\Services\Frontend\DesignManager;
use InvalidArgumentException;
class BlogService
{
    protected DesignManager $designManager;
    protected DesignOneBlogService $designOneBlogService;
    protected DesignTwoBlogService $designTwoBlogService;
    public function __construct(
        DesignManager $designManager,
        DesignOneBlogService $designOneBlogService,
        DesignTwoBlogService $designTwoBlogService
    ) {
        $this->designManager = $designManager;
        $this->designOneBlogService = $designOneBlogService;
        $this->designTwoBlogService = $designTwoBlogService;
    }
    public function getBlogs()
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneBlogService->getBlogs(),
            'design-2' => $this->designTwoBlogService->getBlogs(),
            default => throw new InvalidArgumentException('Blog design service not found.'),
        };
    }
    public function getBlog($blog)
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneBlogService->getBlog($blog),
            'design-2' => $this->designTwoBlogService->getBlog($blog),
            default => throw new InvalidArgumentException('Blog design service not found.'),
        };
    }
}