<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageUser extends Model
{
  protected $table = 'message_user';

  protected $fillable = [
      'message_id',
      'user_id',
  ];


}
