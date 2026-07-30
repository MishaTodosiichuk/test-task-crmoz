<?php

namespace App\Enums;

enum Stage: string
{
    case QUALIFICATION = 'Qualification';
    case NEEDS_ANALYSIS = 'Needs Analysis';
    case VALUE_PROPOSITION = 'Value Proposition';
    case CLOSED_WON = 'Closed Won';
    case CLOSED_LOST = 'Closed Lost';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_map(
            fn (self $case) => [
                'label' => $case->value,
                'value' => $case->value,
            ],
            self::cases()
        );
    }
}
