<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();

        // 2) WHAT? -> fetch only his categories
        $categories = Category::where('user_id', $userId)
            ->orderBy('name')
            ->get();


        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        Category::create([
            'name' => $validated['name'],
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('categories.index');
            ->with('success', 'categorie cree .');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->ensureOwnership($category);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $requested->validate([
            'name' => ['required', 'string', 'max:200'],
        ]);

        $category->update([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('categories.index')->with('success', 'updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->ensureOwnership($category-);

        $category->destroy();

        return redirect()->route('categories.index')->with('sucess', 'removed succesfully');
    }

    private function ensureOwnership(Category $category)
    {
        if ($category->user_id !== auth()->id())
        {
            abort(403);
        }
    }
}
