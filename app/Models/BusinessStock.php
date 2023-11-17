<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessStock extends Model
{
    protected $table = 'business_stock';

    use HasFactory, SoftDeletes;
}
