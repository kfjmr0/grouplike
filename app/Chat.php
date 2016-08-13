<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
  protected $fillable = [
    'topic_id',
    'user_id',
    'body',
  ];

  //relations
  public function topic()
  {
    return $this->belongsTo(Topic::class);
  }

}
