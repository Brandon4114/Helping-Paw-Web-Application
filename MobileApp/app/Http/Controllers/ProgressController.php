<?php

namespace App\Http\Controllers;

use Request;
use App\Progress;
use View;
use App\Animals;
use Redirect;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progress = Progress::all();
        return View::make('progress.index')->with('progress', $progress);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $animals = Animals::pluck('animalName','id')->toArray();
        return View::make('progress.create')->with('animals',$animals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
          'animalID'  =>  'required',
          'progressDescription' => 'required',

        );
        $validator = Validator::make(Request::all(), $rules);

        $points = Progress::all()->where('animalID','=',Request::get('animalID'));
        if($points->isEmpty())
        {
          $animalPoint = 1;
        } else{
          $currentPoint = Progress::where('animalID','=',Request::get('animalID'))->orderBy('animalPoint','desc')->take(1)->get();
          $animalPoint = $currentPoint[0]->animalPoint +1;
        }


        if ($validator->fails()){
          return Redirect::to('progress/create')
            ->withErrors($validator)
            ->withInput(Request::except('password'));
        } else {
          $progress= new Progress;
          $progress->progressDescription = Request::get('progressDescription');
          $progress->animalID = Request::get('animalID');
          $progress->animalPoint = $animalPoint;
          $progress->save();

          Session::flash('message','progress successfully stored');
          return Redirect::to('mobileapp/animals/'. Request::get('animalID').'/edit');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $progress= Progress::find($id);
        return View::make('progress.show')->with('progress',$progress);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $progress= Progress::find($id);
      $animals = Animals::pluck('animalName','id')->toArray();
      $selected = Request::get('animalID');

      return View::make('progress.edit')->with(['progress'=>$progress, 'animals'=> $animals,'selected'=> $selected]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( )
    {

      $rules = array(
        'animalID'  =>  'required',
        'progressDescription' => 'required',
        'progressID'  => 'required'

      );

      $id = Request::get('progressID');

      $validator = Validator::make(Request::all(), $rules);

      if ($validator->fails()){
        return Redirect::to('mobileapp/progress/'.$id.'create')
          ->withErrors($validator)
          ->withInput(Request::except('password'));
      } else {


        $progress= Progress::find($id);
        $progress->progressDescription = Request::get('progressDescription');
        $progress->animalID = Request::get('animalID');
        $progress->save();

        Session::flash('message','progress point successfully edited');
        return Redirect::to('mobileapp/animals/'. Request::get('animalID').'/edit');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // delete
      $progress= Progress::find($id);


      $progressPoints = Progress::where('animalID', $progress->animalID)
                                  ->where('animalPoint','>',$progress->animalPoint)
                                  ->get();
      $progress->delete();
      $this->resetProgress($progressPoints);
      // redirect
      Session::flash('message', 'Successfully deleted progress point');
      return Redirect::to('mobileapp/animals/'. Request::get('animalID').'/edit');
    }

    public function resetProgress($progressPoints){

        foreach ($progressPoints as $key => $value) {
            $value->animalPoint = $value->animalPoint-1;
            $value->save();
        }
      }

}
