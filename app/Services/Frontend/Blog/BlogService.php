<?php

namespace App\Services\Frontend\Blog;

use App\Services\Frontend\DesignManager;
use InvalidArgumentException;

class BlogService
{
    protected DesignManager $designManager;
    protected DesignOneBlogService $designOneBlogService;

    public function __construct(
        DesignManager $designManager,
        DesignOneBlogService $designOneBlogService
    ) {
        $this->designManager = $designManager;
        $this->designOneBlogService = $designOneBlogService;
    }

    public function getBlogs()
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneBlogService->getBlogs(),
            default => throw new InvalidArgumentException('Blog design service not found.'),
        };
    }

    public function getBlog($blog)
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneBlogService->getBlog($blog),
            default => throw new InvalidArgumentException('Blog design service not found.'),
        };
    }
}