<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }
}
