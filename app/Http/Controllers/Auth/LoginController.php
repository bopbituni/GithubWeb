<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use function GuzzleHttp\Promise\all;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $existingUser = User::whereEmail($user->getEmail())->first();
        if ($existingUser) {
            auth()->login($existingUser);
            return redirect($this->redirectPath());
        }
        User::create([
            'name' => $user->getNickname(),
            'email' => $user->getEmail(),
            'avatar' => $user->getAvatar(),
            'password' => bcrypt('54ceqcqc223adsx')
        ]);

        auth()->login($existingUser);

        return redirect($this->redirectPath());
    }
}
