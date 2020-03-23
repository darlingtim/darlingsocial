<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Note;
use App\Task;
use App\Article;

class Post extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User', 'id');
    }

    public function note(){
        return $this->belongsTo('App\Note', 'id');
    }

    public function task(){
        return $this->belongsTo('App\Task', 'id');
    }

    public function article(){
        return $this->belongsTo('App\Article', 'id');
    }
}
