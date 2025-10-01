<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category']);

        // Filter params
        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('tag')) {
            $query->where('tag', 'like', '%' . $request->tag . '%');
        }
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $blogs = $query->paginate($perPage);
        return response()->json($blogs);
    }

    public function show($slug)
    {
        $blog = Blog::with(['author', 'category'])->where('slug', $slug)->first();
        if (!$blog) {
            return response()->json(['message' => 'slug not found'], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Article created successfully',
            'data' => $blog
        ], 201);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_desc' => 'required|string|max:500',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,webp|max:2048',
            // 'image_url' => 'nullable|url|max:500',
            'author_id' => 'required',
            'category_id' => 'required',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'published_date' => 'nullable|date'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blog-images', $imageName, 'public');
        }

        $data = [
            'title'          => $request->title,
            'slug'           => Str::slug($request->title),
            'short_desc'     => $request->short_desc,
            'content'        => $request->content,
            'image'          => $imagePath,
            'image_url'      => $request->image_url,
            'author_id'      => $request->author_id,
            'category_id'    => $request->category_id,
            'tags'           => $request->tags,
            'published_date' => $request->published_date ?? now(),
        ];

        $blog = $this->blogService->createBlog($data);
        return response()->json([
            'success' => true,
            'message' => 'Article created successfully',
            'data' => $blog
        ], 201);
    }

    public function update(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if (!$blog) {
            return response()->json(['message' => 'slug not found'], 404);
        }

        $this->blogService->updateBlog($blog, $request->all());
        return response()->json($blog, 200);
    }

    public function destroy($slug)
    {
        $blog = Blog::where('slug',  $slug)->first();
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        $this->blogService->deleteBlog($blog);
        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }
}
