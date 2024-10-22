<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'contact',
        'address',
        'comment',
    ];
}
