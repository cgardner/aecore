<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;
    
    protected $redirectTo = '/projects';
    
	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest');
	}

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {
        $credentials = \Input::only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = \Password::reset($credentials, function($user, $password)
        {
            $user->password = \Hash::make($password);
            $user->save();
        });

        switch ($response)
        {
            case \Password::INVALID_PASSWORD:
            case \Password::INVALID_TOKEN:
            case \Password::INVALID_USER:
                return \Redirect::back()->with('error', \Lang::get($response));

            case \Password::PASSWORD_RESET:
                return \Redirect::to('login')->with('passSuccess', 'Your password was successfully reset.<br>Please log in to your account.');
        }
    }
    
}
