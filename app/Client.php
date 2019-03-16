<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'cf',
        'deleted'
    ];

    /**
     * Delete client
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }
}
