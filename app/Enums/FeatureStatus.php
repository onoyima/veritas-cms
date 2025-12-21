<?php

namespace App\Enums;

enum FeatureStatus: int
{
    case FEATURED = 1;
    case STANDARD = 0;

    public function label(): string
    {
        return match($this) {
            self::FEATURED => 'Featured',
            self::STANDARD => 'Standard',
        };
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
