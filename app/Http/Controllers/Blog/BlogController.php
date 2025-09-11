<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        return response()->json(Blog::all());
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if (!$blog) {
            return response()->json(['message' => 'slug not found'], 404);
        }
        return response()->json($blog, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'desc_short' => 'required|string|max:255',
            'description' => 'required',
            'author' => 'required'
        ]);
        $blog = Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'desc_short' => $request->desc_short,
            'description' => $request->description,
            'image' => $request->image,
            'author' => $request->author,
            'tag' => $request->tag,
            'published_date' => $request->published_date
        ]);
        return response()->json($blog, 201);
    }
    public function update(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if (!$blog) {
            return response()->json(['message' => 'slug not found'], 404);
        }
        $blog->update($request->all());
        return response()->json($blog, 200);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }
}
