<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageInbox extends Model
{
  protected $table = 'message_inbox';

  protected $fillable = [
      'message_id',
      'user_id',
  ];


}
