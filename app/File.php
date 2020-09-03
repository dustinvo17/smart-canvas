<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //

    function user(){
        return $this->belongsTo('App\User');
    }
}
