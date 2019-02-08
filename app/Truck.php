<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $table = 'trucks';

    public $timestamps = false;

    protected $fillable = [
        'plate',
        'make',
        'model',
        'trailer',
        'deleted'
    ];

    /**
     * Delete truck
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }
}
