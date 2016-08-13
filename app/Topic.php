<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  protected $fillable = [
      'title',
  ];

  //relations
  public function chats()
  {
    return $this->hasMany(Chat::class);
  }

}
