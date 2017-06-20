<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Response;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        flash()->success('Successfully logged in.');
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * @return mixed
     */
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallbackFacebook(Request $request)
    {
        if (isset($request->error)) {
            return redirect()->action('Auth\LoginController@showLoginForm');
        }

        $fbUser = Socialite::driver('facebook')->user();
//        dd($fbUser);

//        check if user is in system
        $systemUser = UserService::getByFacebookID($fbUser->id);
        if ($systemUser == null && isset($fbUser->email)) {
            $systemUser = UserService::getByEmail($fbUser->email);
            if ($systemUser != null) {
                $systemUser = UserService::update($systemUser, ['facebook_id' => $fbUser->id]);
            }
        }
        if ($systemUser == null) {
            $systemUser = UserService::create([
                'name'        => $fbUser->name,
                'surname'     => count(explode(' ', $fbUser->name)) > 1 ? explode(' ', $fbUser->name)[1] : $fbUser->name,
                'email'       => isset($fbUser->email) ? $fbUser->email : null,
                'password'    => bcrypt(uniqid()),
                'nickname'    => isset($fbUser->email) ? $fbUser->email : explode(' ', $fbUser->name)[0].$fbUser->id,
                'facebook_id' => $fbUser->id,
                'agreement'   => true,
                'gender'      => $fbUser->user['gender'] == 'male' ? 'MAN' : 'WOMAN',
                'role'        => 'USER',
            ]);
        }

        \Auth::login($systemUser);

        return redirect()->to($this->redirectTo);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallbackGoogle(Request $request)
    {
        if (isset($request->error)) {
            return redirect()->action('Auth\LoginController@showLoginForm');
        }

        $googleUser = Socialite::driver('google')->user();
//        dd($googleUser);

        $systemUser = UserService::getByGoogleID($googleUser->id);
        if ($systemUser == null && isset($googleUser->email)) {
            $systemUser = UserService::getByEmail($googleUser->email);
            if ($systemUser != null) {
                $systemUser = UserService::update($systemUser, ['google_id' => $googleUser->id]);
            }
        }
        if ($systemUser == null) {
            $systemUser = UserService::create([
                'name'      => $googleUser->name,
                'surname'   => count(explode(' ', $googleUser->name)) > 1 ? explode(' ', $googleUser->name)[1] : $googleUser->name,
                'email'     => isset($googleUser->email) ? $googleUser->email : null,
                'password'  => bcrypt(uniqid()),
                'nickname'  => isset($googleUser->email) ? $googleUser->email : explode(' ', $googleUser->name)[0].$googleUser->id,
                'google_id' => $googleUser->id,
                'agreement' => true,
                'gender'    => $googleUser->user['gender'] == 'male' ? 'MAN' : 'WOMAN',
                'role'      => 'USER',
            ]);
        }

        \Auth::login($systemUser);

        return redirect()->to($this->redirectTo);
    }
}
