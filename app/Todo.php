<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
  
    
   protected $fillable = [
       'item'
   ];
   
    function user(){
        return $this->belongsTo('App\User');
    }
}
