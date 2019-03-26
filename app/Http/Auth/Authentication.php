<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 6/28/2018
 * Time: 7:23 PM
 */

namespace App\Http\Auth;


use App\User;

class Authentication
{
    /**
     * Get logged user
     * @return User
     */
    public function getLoggedUser()
    {
        if(isset($_SESSION['user']))
            return User::findOrFail($_SESSION['user']);
        else
            return null;
    }

    /**
     * Check if a user is logged
     * @return bool
     */
    public function isLoggedUser()
    {
        return isset($_SESSION['user']);
    }

    /**
     * Attempt to login user
     * @param string $credential
     * @param string $password
     * @return bool
     */
    public function attempt($credential, $password)
    {
        $user = User::all()->where('email', '=', $credential)->first();
        if(empty($user)) {
            $user = User::all()->where('username', '=', $credential)->first();
        }

        if(empty($user))
            return false;

        if($user->deleted)
            return false;

        if(password_verify($password, $user->password))
        {
            $_SESSION['user'] = $user->id;

            return true;
        }

        return false;
    }

    /**
     * Unset created session
     */
    public function logout()
    {
        unset($_SESSION['user']);
    }
}