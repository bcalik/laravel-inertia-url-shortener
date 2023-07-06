<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LinkController extends Controller
{
    public function getIndex(Request $request)
    {
        $links = Link::orderBy('id', 'desc')->get();

        return Inertia::render('Links', compact('links'));
    }

    public function getCreate()
    {
        return Inertia::render('CreateLink');
    }

    public function postCreate(LinkRequest $request)
    {
        Link::create($request->validated());

        session()->flash('message', 'Link created');

        return redirect()->to('/app');
    }

    public function getEdit(Link $link)
    {
        return Inertia::render('CreateLink', compact('link'));
    }

    public function postEdit(LinkRequest $request, Link $link)
    {
        $link->fill($request->validated());
        $link->save();

        session()->flash('message', 'Changes are saved.');

        return redirect()->to('/app/links/edit/'.$link->id);
    }

    public function postDelete(Request $request, int $id)
    {
        $link = Link::findOrFail($id);
        $link->delete();

        session()->flash('message', 'Link deleted.');

        return redirect()->to('/app');
    }

    public function postDeleteBatch(Request $request)
    {
        $deleted = 0;

        DB::beginTransaction();
        Link::whereIn('id', $request->input('ids'))
            ->get()
            ->each(function ($link) use (&$deleted) {
                $link->delete();
                $deleted++;
            });
        DB::commit();

        session()->flash('message', $deleted.' '.str('link')->plural($deleted).' deleted.');

        return redirect()->to('/app');
    }
}
