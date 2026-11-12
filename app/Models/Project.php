<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'category_id',
        'description',
        'thumbnail',
        'status',
        'project_date',
        'is_featured',
        'project_url',
        'repository_url',
    ];

    protected $casts = [
        'project_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
