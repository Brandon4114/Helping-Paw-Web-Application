<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Animals extends Model
{
  use HasApiTokens, Notifiable;
   protected $fillable = [
     'animalName',
     'animalDescription',
     'imageName',
     'imageType'
   ];


}
