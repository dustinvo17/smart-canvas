<?php

namespace App\Http\Controllers;

use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use Response;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *

     */
    function user(){
        if(Auth::check()){
            return Auth::user();
        }
        return null;
    }
    public function index()
    {   
        
   
        return $this->user()->files;
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'file' => 'mimes:pdf'
        ]);
        $path = $request->file('file')->store('files','s3');
        Storage::disk('s3')->setVisibility($path,'public');
        $file = new File();
        if($request->has('title')){
            $file->title = $request->input('title');

        }

        $file->file_path = Storage::disk('s3')->url($path);
        $file->file_name = basename($path);
        $file->user_id = $this->user()->id;
        $file->save();
    
        return $file;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //

        if($file->user_id != $this->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }
        return $file;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
        $this->validate($request, [
            'favorite' => 'required'
        ]);
        $file->favorite = $request->input('favorite');
        $file->save();
        return $file;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    
        $deleted_id = $file->id;
        if($file->user_id != $this->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }
     
        Storage::disk('s3')->delete('files/' . $file->file_name);
        $file = File::where([
            ['user_id',$this->user()->id],
            ['id',$file->id]
        ])->delete();
        return $deleted_id;

    }

    public function favorite(){
        $favorite_files = File::where([
            ['user_id', $this->user()->id],
            ['favorite',1]
        ])->get();
        return response()->json($favorite_files);
    }
}
