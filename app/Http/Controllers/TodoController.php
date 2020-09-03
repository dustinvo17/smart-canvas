<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Auth;
use App\Todo;
class TodoController extends Controller
{
    
    function user(){
        if(Auth::check()){
            return Auth::user();
        }
        return null;
    }
    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->user()->todos;
       
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
      
        $validateData = $request->validate(
            ['item' => 'required']);
        $todo = new Todo();
        $todo->item = $request->input('item');

        if($request->has('due_day')){
            $todo->due_day = $request->input('due_day');
        }
        try {
            $this->user()->todos()->save($todo);

        }catch (Throwable $e) {
            return $e->getMessage();
        }
        return $todo;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
      
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $todo = Todo::where([
            ['user_id',$this->user()->id],
            ['id',$id]
        ])->first();
        $todo->item = $request->input('item');
        if($request->has('due_day')){
        $todo->due_day = $request->input('due_day');
        }
        $todo->save();
        return $this->user()->todos;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $todo = Todo::where([
            ['user_id',$this->user()->id],
            ['id',$id]
        ])->delete();
        return $this->user()->todos;
    }
}
