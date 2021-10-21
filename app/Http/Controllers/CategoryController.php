<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::orderByDesc('created_at')->get();
        return view('pages.category.index', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        Category::create($request->all());
        return back()->withSuccess('Kategori berhasil ditambah');
    }

    public function delete($category_id) {
        Category::find($category_id)->delete();
        return back()->withSuccess('Kategori berhasil dihapus');
    }
}
