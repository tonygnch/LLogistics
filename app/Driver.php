<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'driver';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'surname',
        'truck',
        'deleted'
    ];

    /**
     * Delete driver
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }
}
