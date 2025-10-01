<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pages extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'short_desc',
        'status',
        'views',
        'reach'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }
}
