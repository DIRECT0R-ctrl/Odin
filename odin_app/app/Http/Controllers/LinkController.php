<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Link::where('user_id', auth()->id())
            ->with(['category', 'tags'])
            ->latest();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('title', 'ilike', "%{$q}%"); // pgsql
             // ila kant  mysql: ->where('title', 'like', "%{$q}%")
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('tag')) {
            $tag = mb_strtolower(trim($request->input('tag')));
            $query->whereHas('tags', fn ($tq) => $tq->where('name', $tag));
        }

        $links = $query->get();

        $categories = Category::where('user_id', auth()->id())->orderBy('name')->get();

        return view('links.index', compact('links', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('links.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where(function ($q)
                {
                    $q->where('user_id', auth()->id()); // => hd to lt7t
                }), // hdshy ki3ni the category must be exist f database o dyal haad l user
            ],
            'tags' => ['nullable', 'string', 'max:255']
        ]);

        $link = Link::create([
            'title' => $validated['title'],
            'url' => $validated['url'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
        ]);

        $raw = $validated['tags'] ?? '';
        $names = collect(explode(',', $raw))
            ->map(fn ($t) => trim($t))
            ->filter() // remove empty
            ->map(fn ($t) => mb_strtolower($t))
            ->unique()
            ->values();

        if ($names->isNotEmpty()) {
            $tagIds = $names->map(function ($name) {
            return Tag::firstOrCreate(['name' => $name])->id;
        });

            $link->tags()->sync($tagIds->all());
        }

        return redirect()->route('links.index')->with('success', 'link created succefully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
