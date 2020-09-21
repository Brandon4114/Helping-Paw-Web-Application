<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor_Animals extends Model
{
  public $table = "sponsor_animals";
  protected $fillable = [
    'SponsorID',
    'animalID'
  ];
}
