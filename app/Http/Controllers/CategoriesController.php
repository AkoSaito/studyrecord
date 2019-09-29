<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Category;
use DB;

class CategoriesController extends Controller
{
    //*****************
    // カテゴリ一覧
    //*****************
    //カテゴリの一覧を表示する
    /* @param none
     * @return Categoriesテーブル（カテゴリ検索）
     */
    public function maintenance()
    {
        $categories = DB::table('categories')->distinct()->get();

        return view('categories.maintenance')->with('categories', $categories);
    }
    public function create()
    {
        return view('categories.create');
    }

    //*****************
    // カテゴリ登録
    //*****************
    //カテゴリを新規登録する。
    //新規登録後、カテゴリ一覧へ遷移する。
    //カテゴリ名：必須
    /* @param string POST カテゴリ名
     * @return none
     */
    public function store(Request $request)
    {
        //カテゴリ名：必須
        $this->validate($request, [
          'category_name' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->category_name;
        $category->save();

        return redirect('/categories/maintenance');
    }

    //*****************
    // カテゴリ削除
    //*****************
    //カテゴリを削除する。
    //削除後、カテゴリ一覧へ遷移する。
    /* @param int POST Category.id
     * @return none
     */
    public function destroy(Request $request)
    {
        Category::find($request->id)->delete();
        return redirect('/categories/maintenance');
    }
}
