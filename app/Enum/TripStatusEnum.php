<?php

namespace App\Enum;

enum TripStatusEnum: string
{
    case DELIVERED = 'DELIVERED';
    case PICKED = 'PICKED';
    case AT_VENDOR = 'AT_VENDOR';
    case ASSIGNED = 'ASSIGNED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
