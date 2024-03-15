<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use HasFactory, SoftDeletes;

    const PRODUCT_TYPE_FOOD = 'Food';
    const PRODUCT_TYPE_HAIR = 'Hair';

    protected $fillable = [
        'type',
    ];

     /**
     * Get all of the posts for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

    public static function getProductTypeId ( $type ) {
        $type = self::where('type', $type)->first();
        return $type['id'];
    }
}
