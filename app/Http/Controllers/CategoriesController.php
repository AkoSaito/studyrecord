<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Category;
use DB;
class CategoriesController extends Controller
{
    //
    public function maintenance()
    {
        $categories = DB::table('categories')->distinct()->where('is_deleted', '=', false)->get();

        return view('categories.maintenance')->with('categories', $categories);
    }
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect('/categories/maintenance');
    }
    public function destroy(Request $request)
    {
        Category::find($request->id)->delete();
        return redirect('/categories/maintenance');
    }
}
