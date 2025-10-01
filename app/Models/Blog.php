<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'short_desc',
        'content',
        'image',
        'author_id',
        'category_id',
        'tags',
        'published_date',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_date' => 'date',
    ];

    protected $appends = ['image_url'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}
