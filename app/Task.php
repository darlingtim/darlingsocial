<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * @var array
     */
    protected $hidden = ['user_id'];
    protected $fillable = ['title','status', 'start_date', 'end_date','description'];

    /**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getTitle(){
        return $this->title;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getStartDate(){
        return $this->start_date;
    }

    public function getEndDate(){
        return $this->end_date;
    }

    public function getDescription(){
        return $this->description;
    }
}
