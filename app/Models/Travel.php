<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    use HasFactory, Sluggable, HasUuids;
    protected $table = 'travels';

    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'description',
        'number_of_days'
    ];

    public function tours(): HasMany
    {
        return $this->hasMany(Tours::class);
    }



    //*?for unique behaviour of the slug
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function numberOfNights(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['number_of_days'] - 1
        );
    }

    //? old method accessors or use new method above
    //? public function getNumberOfNightsAttribute()
    // {
    //     return $this->number_of_days - 1;
    // }
}