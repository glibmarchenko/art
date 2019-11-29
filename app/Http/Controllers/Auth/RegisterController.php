<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mail;
use Socialite;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            //'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        if($user){
            $user = User::find($user->id);
            // Save URL from which the user started the registration
            $user->registered_from_url = $request->server('HTTP_REFERER');
            $user->email_confirmed = 0;
            $user->token = md5($user->password. ' '. $user->email);
            $user->save();
            $user->touchLastLoginDate();

            Session::put('dialog-box','registration_success');

            Mail::send('web.emails.register', ['token' => $user->token], function($message) use ($user){
                $message->to($user->email)->subject('Успешная регистрация.');
            });

            return response()->json([
                'status' => 'success',
                'id' => $user->id,
                'redirect' => url('/')
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'error_message' => 'Error when register user',
            ]);
        }

    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }



    /**
     * Redirect the user to the Social authentication page.
     *
     * @return Response
     */
    public function redirectToSocialProvider($social)
    {
        if($social=='google'||$social=='facebook'){
            return Socialite::driver($social)->redirect();
        }else
            return redirect('/');

    }

    /**
     * Obtain the user information from Social.
     *
     * @return Response
     */
    public function handleSocialProviderCallback($social,Request $request)
    {

        $params = [
            'social'=>null,
            'social_id'=>null,
            'email'=>null,
            'name'=>null
        ];

        if($social=='google'||$social=='facebook'){
            $user = Socialite::driver($social)->user();
            $email = null;
            if(isset($user->email))
                $email = $user->email;
            if(isset($user->id)){
                $params = [
                    'social'=>$social,
                    'social_id'=>$user->id,
                    'email'=>$email,
                    'name'=>$user->name
                ];
            }
        }else
            return redirect('/');

        return $this->socialAuthOrRegisterUser($params);

    }

    /**
     * Auth or register user with social params
     *
     * @param $params
     * @return mixed
     */
    private function socialAuthOrRegisterUser($params){
        //$params['email'] = null; //test null email
        $userModel = new User();
        $user = $userModel->socialCheckExistUser($params);
        if($user){
            Auth::login($user,true);
            return redirect(route('home'));
        }else{

            $userName = $this->separateNameSurname($params['name']);
            $userInfo = [
                'name' => $userName['name'],
                'surname' => $userName['surname'],
                'password' => bcrypt(time()),
                'soc_'.$params['social'] => $params['social_id'],
                'no_password' => 1
            ];

            if(!$params['email']){
                $userInfo['temp_email'] = 1;
                $params['email'] = md5(rand(555,5555).time()).'@tempmail.com';
            }
            $userInfo['email'] = $params['email'];

            $newUser = User::create($userInfo);
            if($newUser){
                Auth::login($newUser,true);
                if(!$newUser->temp_email){
                    /*Mail::send('web.emails.register', [], function($message) use ($newUser){
                        $message->to($newUser->email)->subject('Успешная регистрация.');
                    });*/
                }
            }

            return redirect(route('register.main'));
        }

    }

    /**
     * Separate name and surname params
     *
     * @param $name
     * @return array
     */
    private function separateNameSurname($name){
        $userName = [];
        $nameArr = explode(' ', $name);
        $userName['name'] = $nameArr[0];
        if(isset($nameArr[1]))
            $userName['surname'] = $nameArr[1];
        else
            $userName['surname'] = null;

        return $userName;
    }

}
