<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $table= 'notes';

    protected $hidden = ['user_id'];

    protected $fillable = ['title','body', 'published'];

    public function user(){

        return $this->belongsto('App\User');
    }

    public function getTitle(){
        return $this->title;
    }

    public function getBody(){
        return $this->body;
    }

   

}
