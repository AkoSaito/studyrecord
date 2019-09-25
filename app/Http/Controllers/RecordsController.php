<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
use App\Category;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class RecordsController extends Controller
{
    //初期表示用関数
    public function index()
    {
          $records = Record::latest()->paginate(10);
          $records->load('category');

          return view('records.index')->with('records', $records);
    }

    //新規登録画面表示用関数
    public function create()
    {
          $categories = DB::table('categories')->distinct()->where('is_deleted', '=', false)->get();

          return view('records.create')->with('categories', $categories);
    }

    //登録・更新用関数（当日の同じ言語の学習時間は合算する）
    public function store(Request $request)
    {
        $today_ymd = Carbon::now()->toDateString();
        $isToday_ymd = $today_ymd . " " . "00:00:00";

        //当日中で同じカテゴリのデータを取得
        $sameRecord = Record::select('id', 'category_id', 'time')->where('category_id', '=', $request->category)->where('created_at', '>=', $isToday_ymd)->get();

        $records = new Record();

        //当日中で同じカテゴリがない場合は、新規追加
        if($sameRecord->isEmpty()){

            $records->time = $request->time;
            $records->category_id = $request->category;

        }else{
           //当日中で同じカテゴリがある場合は、時間を合算して更新

            $records->time = $request->time + $sameRecord[0]['time'];
            $records->category_id = $request->category;

            // 当日の過去データを削除
            Record::find($sameRecord[0]['id'])->delete();
        }
        $records->save();

        return redirect('/');
    }

     //削除用関数
    public function destroy(Request $request)
    {
        Record::find($request->id)->delete();
        return redirect('/');
    }
}
