<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getIndex()
    {
        return redirect('default');
    }

    public function getSlug(Request $request, string $slug)
    {
        $link = Link::query()
            ->whereSlug($slug)
            ->useRequestDomain()
            ->firstOrFail();
        $link->visit();

        return view('link', compact('link'));
    }

    public function getHealth(Request $request)
    {
        return response()->json(['pong']);
    }
}
