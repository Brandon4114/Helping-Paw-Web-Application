<?php
namespace App\Http\Controllers;
use App\Animals;
use App\Progress;
use App\Images;
use App\Sponsor_Animals;
class APIController extends Controller{

  public function index($id)
      {

          $sponsor_animals = Sponsor_Animals::where('SponsorID',$id)->pluck('animalID');

          $animals = Animals::whereIn('animals.id',$sponsor_animals)->get();


          return response()->json($animals, 201);

      }

    public function progress($id){

      $sponsor_animals = Sponsor_Animals::where('SponsorID',$id)->pluck('animalID');

      $animals = Animals::whereIn('id',$sponsor_animals)->get();

      $progress = Progress::whereIn('animalID', $sponsor_animals)->get();

      return response()->json($progress, 201);
    }

    public function gallery($id){
      $sponsor_animals = Sponsor_Animals::where('SponsorID',$id)->pluck('animalID');

      $animals = Animals::whereIn('id',$sponsor_animals)->get();

      $images = Images::whereIn('animalID',$sponsor_animals)->get();

      return response()->json($images,201);
    }
}
