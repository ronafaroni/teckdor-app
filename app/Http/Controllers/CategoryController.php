<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function dataCategory()
    {
        $data_category = Category::orderBy('created_at', 'desc')->get();
        return view('category.data-category', compact('data_category'));
    }

    public function addCategory()
    {
        return view('category.add-category');
    }

    public function saveCategory(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:categories,name_category',
            ],
            [
                'name.unique' => 'The name has already been taken.',
            ]
        );

        $category = new Category;
        $category->name_category = $request->name;
        $category->save();

        return redirect()->route('data-category')->with('success', 'Data saved successfully.');
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        return view('category.edit-category', compact('category'));
    }

    public function updateCategory(Request $request)
    {
        $request->validate(
            [
                'name_category' => 'required|unique:categories,name_category',
            ],
            [
                'name_category.unique' => 'The name has already been taken.',
            ]
        );

        $category = Category::findOrFail($request->id);
        $category->name_category = $request->name_category;
        $category->update();

        return redirect()->route('data-category')->with('updated', 'Data updated successfully.');
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('data-category')->with('deleted', 'Data deleted successfully.');
    }
}
