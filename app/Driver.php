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
        'phone',
        'deleted'
    ];

    /**
     * Get truck
     * @return Truck
     */
    public function truck(){
        if($this->truck) {
            return Truck::find($this->truck);
        } else {
            return null;
        }
    }

    /**
     * Delete driver
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }
}
