<?php

namespace App\Services\Frontend;

use App\Models\Option;
use InvalidArgumentException;

class DesignManager
{
    public function getTemplates(): array
    {
        return config('store_design.templates', []);
    }

    public function getSections(): array
    {
        return config('store_design.sections', []);
    }

    public function getTemplate(string $template): array
    {
        $templates = $this->getTemplates();

        if (!isset($templates[$template])) {
            throw new InvalidArgumentException('Invalid store design template.');
        }

        return $templates[$template];
    }

    public function getSection(string $section): array
    {
        $sections = $this->getSections();

        if (!isset($sections[$section])) {
            throw new InvalidArgumentException('Invalid store design section.');
        }

        return $sections[$section];
    }

    public function getActiveTemplate(): string
    {
        $config = config('store_design.template', []);
        $optionName = $config['option_name'] ?? 'store_design.template';
        $default = $config['default'] ?? array_key_first($this->getTemplates());
        $option = Option::where('option_name', $optionName)->first();

        return $option?->option_value ?: $default;
    }

    public function getSectionDesign(string $section): string
    {
        $config = $this->getSection($section);
        $option = Option::where('option_name', $config['option_name'])->first();

        return $option?->option_value ?: $this->getActiveTemplate();
    }

    public function getPageView(string $page): string
    {
        $template = $this->getTemplate($this->getActiveTemplate());

        if (!isset($template['pages'][$page])) {
            throw new InvalidArgumentException('Store design page view not found.');
        }

        return $template['pages'][$page];
    }

    public function getSectionView(string $section): string
    {
        $this->getSection($section);

        $design = $this->getSectionDesign($section);
        $template = $this->getTemplate($design);

        if (!isset($template['sections'][$section])) {
            throw new InvalidArgumentException('Store design section view not found.');
        }

        return $template['sections'][$section];
    }

    public function render(string $section, array $data = []): string
    {
        return view($this->getSectionView($section), $data)->render();
    }

    public function getTemplateCss(string $file): string
    {
        return asset("frontend/css/templates/{$this->getActiveTemplate()}/{$file}.css");
    }

    public function getSectionCss(string $section): string
    {
        $design = $this->getSectionDesign($section);
        $group = match ($section) {
            'product_card' => 'product/card',
            'blog_card' => 'blog/card',
            default => $section,
        };
        return asset("frontend/css/sections/{$group}/{$design}.css");
    }
    
}