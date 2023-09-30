<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\DeleteImageTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    use UploadImageTrait, DeleteImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $request = request();
        $categories = Category::with('parent')
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $parents = Category::all();
        $category = new Category();
        return view('admin.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'categories');
        }
        Category::query()->create($data);
        return redirect()->route('admin.categories.index')->with('success', 'category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::query()->select(['id', 'name', 'slug'])->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $category = Category::query()->findOrFail($id);
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')->orWhere('parent_id', '<>', $id);
            })->get();
        return view('admin.categories.edit', compact('category', 'parents'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $old_image = $category->image;
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $this->deleteImage($old_image);
            $data['image'] = $this->uploadImage($request->file('image'), 'category');
        }
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        if ($category->image) {
            $this->deleteImage($category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('deleted', 'category deleted');
    }
}
