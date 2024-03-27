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
        // Check if $type is not null before accessing its properties
        if ($type) {
            return $type['id'];
        }

        // Return null or handle the case where $type is null
        return null;
            // return $type['id'];

    }
}
