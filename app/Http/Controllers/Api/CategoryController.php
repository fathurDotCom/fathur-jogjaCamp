<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories, 200);
        return new CategoryResource(200, 'success', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:categories',
            'is_publish' => 'boolean',
        ]);

        $category = Category::create($validatedData);
        
        $message =  'Kategori ' . $category->name . ' telah ditambahkan';
        $job = new MailJob($user, $category);

        dispatch($job);

        return response()->json($category, 201);
        // return new CategoryResource(201, 'success', $category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json($category, 200);
        return new CategoryResource(200, 'success', $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'is_publish' => 'boolean',
        ]);

        $category->update($validatedData);

        return response()->json($category, 200);
        // return new CategoryResource(200, 'success', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $message =  'Kategori ' . $category->name . ' telah dihapus';

        $category->delete();

        $job = new MailJob($user, $category);
        dispatch($job);

        return response()->json($category, 204);
        // return new CategoryResource(204, 'success');
    }
}
