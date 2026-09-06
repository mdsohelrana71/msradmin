<?php

namespace App\Services\Admin;

use App\Models\Option;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StoreDesignService
{
    public function getSections(): array
    {
        return config('store_design.sections', []);
    }

    public function getSection(string $section): array
    {
        $sections = $this->getSections();

        if (!isset($sections[$section])) {
            throw new InvalidArgumentException('Invalid store design section.');
        }

        return $sections[$section];
    }

    public function getSelectedDesign(string $section): string
    {
        $config = $this->getSection($section);
        $option = Option::where('option_name', $config['option_name'])->first();

        return $option?->option_value ?: array_key_first($config['designs']);
    }

    public function updateDesign(string $section, string $design): bool
    {
        $config = $this->getSection($section);

        if (!array_key_exists($design, $config['designs'])) {
            throw new InvalidArgumentException('Invalid store design option.');
        }

        return DB::transaction(function () use ($config, $design) {
            $option = Option::where('option_name', $config['option_name'])->first();

            if ($option) {
                return Option::where('option_name', $config['option_name'])
                    ->update(['option_value' => $design]);
            }

            Option::create([
                'option_name' => $config['option_name'],
                'option_value' => $design,
                'autoload' => 'yes',
            ]);

            return true;
        });
    }

    public function getSelectedDesigns(): array
    {
        $selectedDesigns = [];

        foreach ($this->getSections() as $key => $section) {
            $selectedDesigns[$key] = $this->getSelectedDesign($key);
        }

        return $selectedDesigns;
    }

    public function getDesigns(string $section): array
    {
        return $this->getSection($section)['designs'];
    }
}