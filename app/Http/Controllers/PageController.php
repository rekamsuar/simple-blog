<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $pages = $this->pageService->getAllPages($perPage);

        return response()->json($pages, 200);
    }

    public function show($slug)
    {
        $page = $this->pageService->getPageBySlug($slug);
        if (!$page) {
            return response()->json(['message' => 'page not found'], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Page retrieved successfully',
            'data' => $page
        ], 201);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string',
            'content'       => 'required',
            'short_desc'    => 'required',
            'status'        => 'in:published,draft/unpublish'
        ]);

        $data = [
            'title'      => $request->title,
            'content'    => $request->content,
            'short_desc' => $request->short_desc,
            'status'     => $request->status ?? 'draft',
            'views'      => 0,
            'reach'      => 0,
        ];

        $page = $this->pageService->createPage($data);

        return response()->json([
            'success' => true,
            'message' => 'Article created successfully',
            'data' => $page
        ], 201);
    }

    public function update(Request $request, $slug)
    {
        $page = $this->pageService->getPageBySlug($slug);
        if (!$page) {
            return response()->json(['message' => 'slug not found'], 404);
        }

        $this->pageService->updatePage($page, $request->all());
        return response()->json([
            'success' => true,
            'message' => 'Page updated successfully',
            'data' => $page
        ], 200);
    }

    public function destroy($slug)
    {
        $page = $this->pageService->getPageBySlug($slug);
        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $this->pageService->deletePage($page);
        return response()->json(['message' => 'Page deleted successfully'], 200);
    }
}
