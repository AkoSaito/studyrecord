<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id', 'name'];

    //学習記録を取得
    public function records(){
        return $this->hasMany('App\Record');
    }
}
