<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockProductPop extends Model
{
    protected $table = 'stock_product_pop';

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
