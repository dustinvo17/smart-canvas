<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class PageController extends Controller
{
    //

    public function handleLandingPage() {
        if(Auth::check()){
            return redirect('/dashboard/home');
        }
        else {
            return view('welcome');
        }
    }
}
