<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;
use App\Models\UserAllow;
use Auth;
use Session;

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
    protected $redirectTo = '/home';

    protected $emailDomain = '@nassaucountyny.gov';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $this->prepareCredentialArry($request->only(['username', 'password']));

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $ldap = Adldap::search()->users()->whereMail($user->username)->first();
            $userUid = $ldap->employeeid[0];

            if ($userUid == 'CONTRACTOR') {
                $userUid = 777;
            }

            $userAllow = new UserAllow();
            $userClearance = $userAllow->GetUserClearance($userUid);

            if (empty($userClearance[0])) {
                Session::flush();
                Auth::logout();
                $this->redirectLogin();
            }

            $user = Auth::user();

            return redirect()->to('home')
                ->withMessage('Logged in!');
        }

        return redirect()->to('login')
            ->withMessage('Hmm... Your username or password is incorrect');
    }

    private function redirectLogin()
    {
        return redirect()->to('login')
            ->withMessage('Hmm... Your username or password is incorrect');

    }

    private function prepareCredentialArry(array $credentials)
    {
        $userName = $this->safeAddeEmailDomail($credentials['username']);
        return ['username' => $userName, 'password' => $credentials['password']];
    }

    private function safeAddeEmailDomail($username)
    {
        if (strpos($username, $this->emailDomain) == false) {
            return $username . $this->emailDomain;
        }
        return $username;
    }

}
