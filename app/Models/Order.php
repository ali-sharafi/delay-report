<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function trip()
    {
        return $this->hasOne(Trip::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function scopeForAgent($query, $agent)
    {
        return $query->where('agent_id', $agent);
    }
}
