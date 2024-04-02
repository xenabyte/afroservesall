<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ActiveHour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_type_id',
        'week_days',
        'opening_hours',
        'closing_hours',
    ];
}
