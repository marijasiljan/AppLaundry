<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use HasFactory, SoftDeletes;

    public function business(): HasMany
    {
        return $this->hasMany(Business::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
