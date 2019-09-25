<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
use App\Category;
use DB;
class SearchController extends Controller
{
    //
    public function search(){

        /*if($request->has('name')){
            $query->where('name', 'like', '%'.$request->get('name').'%');
        }

        foreach($request->only(['name', 'week', 'month', 'year']) as $key => $value){
            $query->where($key, 'like', '%'.value.'%');
        }

        $records = query->get();
        return view('records.search')->with('records', $records);*/
    }
}
