<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //mass assignable
    protected $fillable = [
        'user_id',
        'name',
        'date',
        'start_time',
        'end_time',
    ];

    //relations
    public function user()
    {
      return $this->belongsTo(User::class);
    }


}
