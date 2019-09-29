<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'id',
        'category_id',
        'time'
    ];

    //このカテゴリを所有する学習記録を取得
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
