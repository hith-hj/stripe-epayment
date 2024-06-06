<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description','price'];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value/100,
        );
    }
}
