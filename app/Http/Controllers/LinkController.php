<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function getSlug(Request $request, string $slug)
    {
        $link = Link::query()
            ->whereSlug($slug)
            ->useRequestDomain()
            ->firstOrFail();
        $link->visit();

        return view('link', compact('link'));
    }
}
