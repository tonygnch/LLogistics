<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Auth\Authentication;

class LoginController
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $viewPath = '/login/';

    protected $auth;

    public function __construct()
    {
        $this->auth = new Authentication();
    }

    /**
     * Login Action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function login(Request $request) {
        if($request->isMethod('POST')) {
            $auth = $this->auth->attempt($request->credential, $request->password);

            if(!$auth)
                return redirect(route('login'));

            return redirect($this->redirectTo);
        }

        return \view($this->viewPath . 'login');
    }

    public function resetPassword(Request $request) {
        if($request->isMethod('POST')) {
            /** @var User $user */
            $user = User::all()->where('reset_hash', '=', $request->hash)->first();
            $user->setPassword($request->password);
            $user->resetResetHash();
            $user->save();

            if(!$this->auth->attempt($user->email, $request->password)) {
                return redirect(route('login'));
            }

            return redirect($this->redirectTo);
        }

        return \view($this->viewPath . 'recover', array(
            'title' => 'Reset password',
            'hash' => $request->hash
        ));
    }

    /**
     * Logout user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        $this->auth->logout();
        return redirect('/login');
    }
}
