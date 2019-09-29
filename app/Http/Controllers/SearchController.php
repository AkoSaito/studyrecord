<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
use App\Category;
use DB;
class SearchController extends Controller
{

    public function categorySearch(Request $request){
        $categories = DB::table('categories')->distinct()->get();
        $records = Record::where($request->category_id)->latest()->paginate(10);
        $records->load('category');

        return view('records.index', [
              'categories' => $categories,
              'records' => $records
        ]);
    }
}
