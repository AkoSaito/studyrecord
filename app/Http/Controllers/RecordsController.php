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
    //************************
    // 初期表示（トップ画面）
    //************************
    // 学習時間の一覧を表示する。
    // カテゴリ・表示期間で絞り込み可
    // 1ページ10件、作成日時の昇順で表示
    // CircleProgress：
    //    学習時間が100時間未満もしくは絞り込み検索時は、100時間で1周
    //    学習時間が100時間以上は1000時間で1周
    // ProgressBar：
    //    100時間で100％（のちのち24時間で100%にしたい・・・）
    /* @param $request
     * @return categories:カテゴリー検索用 Categoriesテーブル
     *         records:一覧表示用 Recordsテーブル,Categoriesテーブル
     *         selectedCategory: int GET category_id（カテゴリ検索）
     *         selectedPeriod: string GET inlineRadioOptions(表示期間検索)
     *         sum: 合計学習時間
     *         sumForProgress: 合計学習時間（CircleProgress用100分の1の時間）
     */
    public function index(Request $request)
    {
        //カテゴリ絞り込み検索表示用
        $categories = DB::table('categories')->distinct()->get();
        //GETで送られてきたカテゴリーID
        $selectedCategory = $request->category;

        //学習時間合計値
        $sum = Record::sum("time");

        /* 一覧表示用
        * 最新日付順・10件ずつ表示
        */
        $records = Record::latest();

        //カテゴリ絞り込み検索
        if($selectedCategory){
            $records = $records->where('category_id', $selectedCategory);

            //合計時間
            $sum = DB::table('records')->where('category_id', $selectedCategory)->sum("time");
        }

        //GETで送られてきた期間
        $selectedPeriod = $request->inlineRadioOptions;

        //日別表示
        if($selectedPeriod === "day"){
            $today = Carbon::now()->toDateString();
            $isToday = $today . " " . "00:00:00";
            $records = $records->where('created_at', '>=', $isToday);

            //学習時間合計値
            $sum = DB::table('records')->where('created_at', '>=', $isToday)->sum('time');
            if($selectedCategory){
                $sum = DB::table('records')->where('created_at', '>=', $isToday)->where('category_id', $selectedCategory)->sum('time');
            }

         }

         //週別表示
        if($selectedPeriod === "week"){
            $today = Carbon::now();
            $startOfWeek = $today->startOfWeek();
            $formattedStartOfWeek = $startOfWeek . " " . "00:00:00";
            $endOfWeek = $today->endOfWeek();
            $formattedEndOfWeek = $endOfWeek . " " . "00:00:00";

            $records = $records->where('created_at', '>=', $formattedStartOfWeek)
                                 ->where('created_at', '<=', $formattedEndOfWeek);
             //学習時間合計値
             $sum = DB::table('records')->where('created_at', '>=', $formattedStartOfWeek)
                                  ->where('created_at', '<=', $formattedEndOfWeek)->sum('time');

             if($selectedCategory){
                $sum = DB::table('records')->where('created_at', '>=', $formattedStartOfWeek)
                    ->where('created_at', '<=', $formattedEndOfWeek)->where('category_id', $selectedCategory)->sum('time');
             }
        }

        //月別表示
        if($selectedPeriod === 'month'){
            $today = Carbon::now();
            $startOfMonth = $today->startOfMonth();
            $formattedStartOfMonth = $startOfMonth . " " . "00:00:00";
            $endOfMonth = $today->endOfMonth();
            $formattedEndOfMonth = $endOfMonth . " " . "00:00:00";

            $records = $records->where('created_at', '>=', $formattedStartOfMonth)
                               ->where('created_at', '<=', $formattedEndOfMonth);

            //学習時間合計値
            $sum = DB::table('records')->where('created_at', '>=', $formattedStartOfMonth)
                                       ->where('created_at', '<=', $formattedEndOfMonth)->sum('time');
            if($selectedCategory){
                 $sum = DB::table('records')->where('created_at', '>=', $formattedStartOfMonth)
                 ->where('created_at', '<=', $formattedEndOfMonth)->where('category_id', $selectedCategory)->sum('time');
            }
        }

        //年別表示
        if($selectedPeriod === 'year'){
            $today = Carbon::now();
            $startOfYear = $today->startOfYear();
            $formattedStartOfYear = $startOfYear . " " . "00:00:00";
            $endOfYear = $today->endOfYear();
            $formattedEndOfYear = $endOfYear . " " . "00:00:00";

            $records = $records->where('created_at', '>=', $formattedStartOfYear)
                               ->where('created_at', '<=', $formattedEndOfYear);

            //学習時間合計値
            $sum = DB::table('records')->where('created_at', '>=', $formattedStartOfYear)
                                ->where('created_at', '<=', $formattedEndOfYear)->sum('time');
            if($selectedCategory){
                 $sum = DB::table('records')->where('created_at', '>=', $formattedStartOfYear)
                 ->where('created_at', '<=', $formattedEndOfYear)->where('category_id', $selectedCategory)->sum('time');
            }
        }
        $records->with('category');
        $records = $records->paginate(10);

        $records->appends([
            'category' => $selectedCategory,
            'inlineRadioOptions' => $selectedPeriod
            ]
        );

        /* circleProgress用
         * 全体表示時：100時間未満→100時間で1周
         *             100時間以上→1000時間で1周するよう、上2桁のみ取得
         * 各絞りこみ時：100時間で1周
         */
        $sumForProgress = substr($sum, 0, 2);

        return view('records.index', [
            'categories' => $categories,
            'records' => $records,
            'selectedCategory' => $selectedCategory,
            'selectedPeriod' => $selectedPeriod,
            'sum' => $sum,
            'sumForProgress' => $sumForProgress
        ]);
    }

    //*********************************************
    // 今日の記録（学習記録新規登録） 登録フォーム
    //*********************************************
    // 今日の学習時間を登録する。
    /* @param none
     * @return categories:カテゴリー検索用 Categoriesテーブル
     */
    public function create()
    {
        $categories = DB::table('categories')->distinct()->get();

        return view('records.create')->with('categories', $categories);
    }

    //******************************************
    // 今日の記録（学習記録新規登録） 登録処理
    //******************************************
    // 今日の学習時間を新規登録する。
    // 同日に同じカテゴリの学習時間を登録した場合、
    // レコードを更新し、時間を加算する。
    // 登録・更新後、トップ画面へリダイレクトする。
    // time： 必須、2桁まで（のちのち24までしかいれられないようにしたい・・・）
    /* @param int POST category_id
     *        int POST 時間
     * @return none
     */
    public function store(Request $request)
    {
        //時間：入力必須
        $validate = $this->validate($request, [
            "time" => "required|max:2"
        ]);
        //今日の日付をDBに格納できる形式で取得
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

    //******************************************
    // 学習記録削除処理
    //******************************************
    // トップ画面の学習記録を削除する。
    // 削除処理後、トップ画面へリダイレクトする。
    /* @param int POST id
     *        int POST 時間
     * @return none
     */
     //削除用関数
    public function destroy(Request $request)
    {
        Record::find($request->id)->delete();
        return redirect('/');
    }
}
