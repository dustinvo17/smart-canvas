<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SinglePageController extends Controller
{
    //

    public function index(){
        $user = Auth::user();
        
        $user->tokens()->delete();
        $token = $user->createToken($user->name);
        $access_token = $token->plainTextToken;
        return view('dashboard',[
            'access_token' => $access_token
        ]);
    }
}
