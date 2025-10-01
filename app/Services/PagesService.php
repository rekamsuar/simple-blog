<?php

namespace App\Services;

use App\Models\Pages;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PagesService
{
    public function getAllPages(int $perPage = 10)
    {
        return Pages::paginate($perPage);
    }

    public function getPageBySlug(string $slug): ?Pages
    {
        return Pages::where('slug', $slug)->first();
    }
    public function createPage(array $data): Pages
    {
        return Pages::create($data);
    }

    public function upadatePage(Pages $page, array $data): bool
    {
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        return $page->update($data);
    }

    public function deletePage(Pages $page): bool
    {
        return $page->delete();
    }
}
