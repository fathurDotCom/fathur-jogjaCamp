<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Jobs\MailJob;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::orderByDesc('created_at')->get();

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->is_publish = $request->is_publish ?? false;
        $category->save();

        $user = User::find(1);
        $tipe = "create";
        $job = dispatch(new MailJob($tipe, $user, $category));

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
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
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->is_publish = $request->is_publish ?? false;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $user = User::find(1);
        $tipe = "delete";
        $job = dispatch(new MailJob($tipe, $user));

        $category->delete();


        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
