<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{
    public function index() {
        $page = $_GET['page'] ??= 1;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
        $categories = Category::query();
        $categories = $categories->orderBy('name', 'desc')->paginate(10);
        
        return view('category.index', compact('categories'));
    }

    public function create() {
        $category = new Category();
        return view('category.create', compact('category'));
    }

    public function edit(Category $category) {
        return view('category.edit', compact('category'));
    }

    public function show(Category $category) {
        return view('category.show', compact('category'));
    }

    public function storeEdit(CategoryRequest $request, Category $category = null) {
        $category = $category ?? new Category();
        $category->name = $request->name;
        $category->color = $request->color;
        $category->save();
        return redirect()->route('category.show', $category->id);
    }

    public function destroy(Category $category) {
        $category->delete();
        return redirect()->route('category.index');
    }
}
