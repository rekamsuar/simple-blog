<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Collection;

class BlogService
{
    public function getAllBlogs(): Collection
    {
        return Blog::with('category')->get();
    }

    public function createBlog(array $data): Blog
    {
        return Blog::create($data);
    }

    public function getBlogById(int $id): ?Blog
    {
        return Blog::with('category')->findOrFail($id);
    }

    public function updateBlog(Blog $blog, array $data): bool
    {
        return $blog->update($data);
    }

    public function deleteBlog(Blog $blog): bool
    {
        return $blog->delete();
    }
}
