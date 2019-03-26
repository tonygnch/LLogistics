<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'profile_picture',
        'role',
        'password',
        'reset_hash'
    ];

    public function setResetHash($email) {
        $this->reset_hash = md5($email);
    }

    public function role() {
        return Role::find($this->role);
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function resetResetHash() {
        $this->reset_hash = null;
    }

    public function delete() {
        $this->deleted = 1;
        $this->save();
    }
}
