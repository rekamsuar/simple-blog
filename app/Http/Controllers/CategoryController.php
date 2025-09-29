<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $category=Category::create([
            'name'=>$request->name,
            'slug'=> Str::slug($request->name),
        ]);
        return response()->json($category, 200);
    }

    public function show($id)
    {
        $category=Category::findOrFail($id);
        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $category= Category::findOrFail($id);
        $request->validate([
            'name'=>'required|string|unique:categories,name' .$category->id
        ]);

        $category->update([
            'name'=>$request->name,
            'slug'=> Str::slug($request->name),
        ]);

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
