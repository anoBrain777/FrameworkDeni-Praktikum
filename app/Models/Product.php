<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'unit',
        'type',
        'information',
        'qty',
        'supplier_id',
        'producer',
    ];
    
    public function supplier(){
        return $this->belongsTo(supplier::class);
    }
}
