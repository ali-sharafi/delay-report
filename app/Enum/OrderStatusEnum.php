<?php

namespace App\Enum;

enum OrderStatusEnum: string
{
    case PENDING = 'PENDING';
    case DELAY_QUEUE = 'DELAY_QUEUE';
    case ASSIGNED_AGENT = 'ASSIGNED_AGENT';
    case DELIVERED = 'DELIVERED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
