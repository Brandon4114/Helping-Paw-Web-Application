<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
  public $table = "progress";
  protected $fillable = [
    'animalID',
    'animalPoint',
    'progressDescription'
  ];
}
