<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Validation\rule;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::where('user_id', auth()->id())
            ->with('category')->latest()->get();

        return view('links.index', compact('links'));
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
                Rule::exists('categories', 'id')->where(function ($q)
                {
                    $q->where('user_id', auth()->id()) / => hd
                )}, // hdshy ki3ni the category must be exist f database o dyal haad l user
            ],
        ]);

        Link::create([
            'title' => $validated['title'],
            'url' => $validated['url'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
        ]);

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
        //
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
