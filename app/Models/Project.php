<?php

namespace App\Models;

use App\Models\AttributeValue;
use App\Enums\ProjectStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status'];

    protected function casts()
    {
        return [
            'status' => ProjectStatusEnum::class,
        ];
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_project');
    }

    public function timeSheets(): HasMany
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'entity_id');
    }
}
