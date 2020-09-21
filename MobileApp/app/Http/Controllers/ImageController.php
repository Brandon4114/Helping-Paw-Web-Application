<?php

namespace App\Http\Controllers;

use App\Images;
use View;
use Session;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Images::all();
        return View::make('images.index')->with('images', $images);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('image');
        $type = explode('/',$file->getMimeType());
        $randomStr = Str::random(7);

        $name = $randomStr.".".$type[1];

        $file->storeAs('public',$name);

        $image = new Images;
        $image->animalID = $request->get('animalID');
        $image->imageName = $randomStr;
        $image->imageType = $type[1];
        $image->save();

        Session::flash('message','Image successfully stored');
        return Redirect::to('mobileapp/animals/'.$request->get('animalID').'/edit');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Images::find($id);
        return View::make('image.show')->with('image',$image);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $animalID)
    {

      $image = Images::find($id);
      return View::make('images.edit')->with(['image'=>$image,'animalID'=>$animalID]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request)
    {



        // $file = $request->file('image');
        // $type = explode('/',$file->getMimeType());
        // $imageId = $request->get('imageID');
        // $randomStr = Str::random(7);
        //
        //
        // $image = Images::find($request->get('imageID'));
        //
        // $filepath = app_path('public\\'.$image->ImageName.'.'.$image->imageType);
        //
        // if(File::exists($filepath)){
        //   dd(true);
        // } else dd(false);
        // File::delete($image->ImageName);
        //
        // $name = $image->animalID.'-'.$randomStr.'.'.$type[1];
        // $image->imageName = $name;
        // $image->save();


        // $file->storeAs('public',$name);

        // $image->imageName = Request::get('imageName');
        // $image->imageType = Request::get('imageType');
        // $image->save();

        Session::flash('message','Image successfully edited');
        return Redirect::to('images');

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
      $image = Images::find($id);
      $image->delete();

      // redirect
      Session::flash('message', 'Successfully deleted image');
      return Redirect::to('images');
    }
}
