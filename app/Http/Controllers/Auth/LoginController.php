<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

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

    protected $viewPath = '/login/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login Action
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function login(Request $request) {
        if($request->isMethod("POST")) {
//            $data = $request->post();
//            $user = DB::selectOne('SELECT * FROM `users` WHERE `username` = "' . $data['username'] . '"');
            return redirect('/');

        }
        return \view($this->viewPath . 'login', ['title' => 'LogIn']);
    }
}
