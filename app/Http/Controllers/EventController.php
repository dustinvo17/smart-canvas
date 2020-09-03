<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Auth;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function user(){
        if(Auth::check()){
            return Auth::user();
        }
        abort(403, 'Unauthorized action.');
    }
    public function index()
    {
        //
        return $this->user()->events;

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
        $request->validate([
            'title' => 'required',
            'date' => 'required',
        ]);
        $event = new Event();
        $event->title = $request->input('title');
        $event->date = $request->input('date');
        if($request->has('from')){
            $event->from = $request->input('from');
        }
        if($request->has('to')){
            $event->to = $request->input('to');
        }
        if($request->has('location')){
            $event->location = $request->input('location');
        }
        $event->user_id = $this->user()->id;
        $event->save();
        return $event;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
        $request->validate([
            'title' => 'required',
            'date' => 'required',
        ]);
        $input = $request->all();
        $event->fill($input)->save();
        return $event;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
        $deleted_id = $event->id;
        if($event->user_id != $this->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }
        $deleteEvent = Event::where([
            ['user_id',$this->user()->id],
            ['id',$event->id]
        ])->delete();
        return $deleted_id;
    }

    public function upcoming() {
        $up_coming_events = Event::where( [
            ['date','>=',date('Y-m-d')],
            [ 'user_id',$this->user()->id]
        ])->orderBy('date')->paginate(5);
        return response()->json($up_coming_events);
   
    }
}
