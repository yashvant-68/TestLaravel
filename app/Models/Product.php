<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $appends = ['product_id'];

    public function getProductIdAttribute()
    {
        return $this->attributes['id'];
    }
}
