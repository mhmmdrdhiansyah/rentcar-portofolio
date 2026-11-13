<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_category_id',
        'brand',
        'model',
        'name',
        'slug',
        'description',
        'main_image',
        'gallery',
        'specifications',
        'with_driver',
        'self_drive',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'specifications' => 'array',
        'with_driver' => 'boolean',
        'self_drive' => 'boolean',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function vehicleCategory(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true)->where('is_published', true);
    }

    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('sort_order');
    }
}
