<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    public $timestamps = false;

    protected $fillable = [
        'option_name',
        'option_value',
        'autoload',
    ];

    protected $casts = [
        'autoload' => 'string',
    ];

    /**
     * Get an option value.
     */
    public static function getOption(
        string $name,
        mixed $default = null
    ): mixed {
        $value = static::where('option_name', $name)
            ->value('option_value');

        return $value ?? $default;
    }

    /**
     * Create or update an option.
     */
    public static function setOption(
        string $name,
        mixed $value,
        string $autoload = 'yes'
    ): static {
        return static::updateOrCreate(
            [
                'option_name' => $name,
            ],
            [
                'option_value' => $value,
                'autoload' => $autoload,
            ]
        );
    }

    /**
     * Get multiple settings.
     */
    public static function getSettings(
        array $names,
        array $defaults = []
    ): object {
        $options = static::whereIn('option_name', $names)
            ->pluck('option_value', 'option_name')
            ->all();

        $settings = array_merge(
            array_fill_keys($names, ''),
            $defaults,
            $options
        );

        return (object) $settings;
    }
}