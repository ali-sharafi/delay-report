<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayReport extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function scopeDateBetween($query, string $startDate, string $endDate)
    {
        return $query->whereBetween('date_at', [$startDate, $endDate]);
    }
}
