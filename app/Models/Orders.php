<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory, SoftDeletes;

    public function business(): HasMany
    {
        return $this->hasMany(Business::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function orderItems(): HasOne
    {
        return $this->hasOne(OrderItems::class);
    }
}
