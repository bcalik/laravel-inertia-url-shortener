<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AppController extends Controller
{
    public function getIndex(Request $request)
    {
        $links = Link::orderBy('id', 'desc')->get();

        return Inertia::render('Links', [
            'links' => $links,
        ]);
    }

    public function getCreate(Request $request)
    {
        return Inertia::render('CreateLink');
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'slug' => [
                'nullable',
                'min:2',
                Rule::unique('links')->where(function ($query) {
                    return $query->where('slug', request()->input('slug'))
                        ->where('domain', url('/'));
                }),
            ],
            'app_url' => 'nullable|url',
            'android_url' => 'nullable|url',
            'ios_url' => 'nullable|url',
            'huawei_url' => 'nullable|url',
            'fallback_url' => 'required|url',
        ]);

        Link::create($validated);

        session()->flash('message', 'Link created');

        return redirect()->to('/app');
    }

    public function getEdit(Request $request, int $id)
    {
        $link = Link::findOrFail($id);

        return Inertia::render('CreateLink', compact('link'));
    }

    public function postEdit(Request $request, int $id)
    {
        $link = Link::findOrFail($id);

        $validated = $request->validate([
            'slug' => [
                'nullable',
                'min:2',
                Rule::unique('links')->where(function ($query) use ($link) {
                    return $query->where('slug', request()->input('slug'))
                        ->where('domain', $link->domain);
                })->ignore($link->id),
            ],
            'app_url' => 'nullable',
            'android_url' => 'nullable|url',
            'ios_url' => 'nullable|url',
            'huawei_url' => 'nullable|url',
            'fallback_url' => 'nullable|url',
        ]);

        $link->fill($validated);
        $link->save();

        session()->flash('message', 'Changes are saved.');

        return redirect()->to('/app/links/edit/'.$id);
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
        Link::whereIn('id', $request->input('ids'))
            ->get()
            ->each(function ($link) use (&$deleted) {
                $link->delete();
                $deleted++;
            });

        session()->flash('message', $deleted.' '.str('link')->plural($deleted).' deleted.');

        return redirect()->to('/app');
    }
}
