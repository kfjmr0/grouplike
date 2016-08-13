<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatReadRemark extends Model
{
  protected $fillable = [
    'topic_id',
    'user_id',
    'hasRead',
  ];

  //relations


}
