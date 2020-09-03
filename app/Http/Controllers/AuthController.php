<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\User;
class AuthController extends Controller
{
    //

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->with(["prompt" => "select_account"])->redirect();
    }


    public function handleProviderCallback($provider)
    {
        try {
            $userSocial = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return Redirect::to('auth/' + $provider);
        }
  
        $authUser = $this->findOrCreateUser($userSocial,$provider);

        Auth::login($authUser, true);

        return redirect('/');
    }



    public function findOrCreateUser($userSocial,$provider){
        $user = User::where('email',$userSocial->getEmail())->first();
        if(!$user){
            $newUser = User::create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'avatar' => $userSocial->getAvatar(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider

            ]);
            $newUser->save();
            return $newUser;
        }
        else {
            return $user;
        }
    }
    public function handleLogOut(){
        $user = Auth::user();
        $user->tokens()->delete();
        Auth::logout();
        
        return redirect('/');
    }

   
}
