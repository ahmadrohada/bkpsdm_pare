<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Models\User;
use App\Models\Social;
use App\Models\Role;
use App\Models\Profile;
use App\Traits\CaptchaTrait;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use Gravatar;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	protected $username = 'username';


	use AuthenticatesAndRegistersUsers
    {
        getLogout as authLogout;
    }
	use CaptchaTrait;
	use ThrottlesLogins;
    protected $auth;
    protected $userRepository;
	protected $redirectPath = '/dashboard';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, UserRepository $userRepository)
	{
		$this->middleware('guest',
			['except' =>
				['getLogout', 'resendEmail', 'activateAccount']]);

        $this->auth = $auth;
        $this->userRepository = $userRepository;
	}

    /**
     * Overwrite getLogout method of trait AuthenticatesUsers;
     * @return Response
     */
    public function getLogout()
    {
	    \Auth::logout();
	    return redirect('auth/login')->with('status',  \Lang::get('auth.loggedOut'));
    }

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'id_pegawai' 	=> 'required|max:255|unique:users',
			'username' 		=> 'required|max:255|unique:users',
			'password' 		=> 'required|confirmed|min:6',
		]);
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
	    if($this->captchaCheck() == false)
	    {
	        return redirect()->back()->withErrors(['Sorry, Wrong Captcha'])->withInput();
	    }

		$validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

		$activation_code 		= str_random(60) . $request->input('nip');
		$user 					= new User;
		$user->nama 			= $request->input('nama');
		$user->nip 				= $request->input('nip');
		$user->first_name 		= $request->input('first_name');
		$user->last_name 		= $request->input('last_name');
		$user->photo 			= $request->input('isi');
		//$user->nip 			= $request->input('nip');
		$user->password 		= bcrypt($request->input('password'));

		// GET GRAVATAR
		$user->gravatar 		= Gravatar::get($request->input('nip'));

		// GET ACTIVATION CODE
		$user->activation_code 	= $activation_code;

		// GET IP ADDRESS
		$userIpAddress 				= new CaptureIp;
		$user->signup_ip_address	= $userIpAddress->getClientIp();

		// SAVE THE USER
		if ($user->save()) {

			$this->sendEmail($user);
	        $user_role = Role::whereName('user')->first();
	        $user->assignRole($user_role);

            $profile = new Profile;
            $user->profile()->save($profile);

			$attemptsAllowed 		= 2;

			return view('auth.activateAccount')
			    ->with('nip', $user->id_pegawai)
			    ->with('username', $user->username)
			    ->with('attempts', $user->resent)
			    ->with('remaining', ($attemptsAllowed - ($user->resent)));

		} else {

			\Session::flash('message', \Lang::get('notCreated') );
			return redirect()->back()->withInput();
		}

	}
	


}
