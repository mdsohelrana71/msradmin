<?php

namespace App\Services\Admin;

use App\Models\Option;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StoreDesignService
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

    public function updateTemplate(string $template): bool
    {
        $this->getTemplate($template);

        return $this->saveOption(
            config('store_design.template.option_name', 'store_design.template'),
            $template
        );
    }

    public function getSectionOverride(string $section): ?string
    {
        $config = $this->getSection($section);
        $option = Option::where('option_name', $config['option_name'])->first();

        return $option?->option_value;
    }

    public function updateSectionOverride(string $section, ?string $design): bool
    {
        $config = $this->getSection($section);

        if ($design !== null) {
            $template = $this->getTemplate($design);

            if (!isset($template['sections'][$section])) {
                throw new InvalidArgumentException('Invalid store design override.');
            }
        }

        return $this->saveOption($config['option_name'], $design);
    }

    public function getResolvedDesign(string $section): string
    {
        $this->getSection($section);

        return $this->getSectionOverride($section) ?: $this->getActiveTemplate();
    }

    public function getSelectedDesigns(): array
    {
        $selectedDesigns = [];

        foreach ($this->getSections() as $section => $config) {
            $selectedDesigns[$section] = $this->getResolvedDesign($section);
        }

        return $selectedDesigns;
    }

    public function getSectionView(string $section): string
    {
        $design = $this->getResolvedDesign($section);
        $template = $this->getTemplate($design);

        if (!isset($template['sections'][$section])) {
            throw new InvalidArgumentException('Store design view not found.');
        }

        return $template['sections'][$section];
    }

    protected function saveOption(string $optionName, ?string $value): bool
    {
        return DB::transaction(function () use ($optionName, $value) {
            $option = Option::where('option_name', $optionName)->first();

            if ($option) {
                return (bool) $option->update([
                    'option_value' => $value,
                ]);
            }

            Option::create([
                'option_name' => $optionName,
                'option_value' => $value,
                'autoload' => 'yes',
            ]);

            return true;
        });
    }
}