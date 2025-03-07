<?php

namespace App\Models;

use App\Enums\AttributeTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type'];

    protected function casts()
    {
        return [
            'type' => AttributeTypeEnum::class,
        ];
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
