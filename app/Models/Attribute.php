<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = [
        'name',
    ];

    public function attributeOptions(): HasMany
    {
        return $this->hasMany(AttributeOption::class);
    }
}
