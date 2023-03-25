<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use App\Jobs\MailJob;
use App\Models\Category;
use App\Models\User;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories',
            'is_publish' => 'boolean',
        ],[
            'name.required' => 'Bidang nama wajib terisi.',
            'name.string' => 'Bidang nama harus berupa text.',
            'name.max' => 'Jumlah karakter pada bidang nama melewati kapasitas',
            'name.unique' => 'Nama telah terpakai',
            'is_publish.boolean' => 'Bidang publish harus berupa boolean (true/false)',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::create($validator->validated());

        $user = User::find(1);

        $tipe = "create";
        $job = dispatch(new MailJob($tipe, $user, $category));

        return response()->json($category, 201);
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
    public function update(CategoryRequest $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'is_publish' => 'boolean',
        ],[
            'name.required' => 'Bidang nama wajib terisi.',
            'name.string' => 'Bidang nama harus berupa text.',
            'name.max' => 'Jumlah karakter pada bidang nama melewati kapasitas',
            'name.unique' => 'Nama telah terpakai',
            'is_publish.boolean' => 'Bidang publish harus berupa boolean (true/false)',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->update($validator->validated());

        return response()->json($category, 200);
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

        return response()->json(null, 204);
    }
}
