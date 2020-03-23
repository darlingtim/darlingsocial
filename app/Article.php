<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
class Article extends Model
{
    //
    protected $hidden = ['user_id'];
    protected $fillable = ['title', 'body','picture_url','audio_url','video_url'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
