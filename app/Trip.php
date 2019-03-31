<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = 'trip';

    public $timestamps = false;

    protected $fillable = [
        'driver',
        'client',
        'weight',
        'truck',
        'trailer',
        'description',
        'departed',
        'arrived',
        'start_point',
        'end_point',
        'distance',
        'invoiced',
        'deleted'
    ];

    /**
     * Get client object
     * @return Client|null
     */
    public function client(){
        if($this->client) {
            return Client::find($this->client);
        } else {
            return null;
        }
    }

    /**
     * Get driver object
     * @return Driver|null
     */
    public function driver(){
        if($this->driver) {
            return Driver::find($this->driver);
        } else {
            return null;
        }
    }

    /**
     * Get truck object
     * @return Truck|null
     */
    public function truck(){
        if($this->truck) {
            return Truck::find($this->truck);
        } else {
            return null;
        }
    }

    /**
     * Get trailer object
     * @return Trailer|null
     */
    public function trailer(){
        if($this->trailer) {
            return Trailer::find($this->trailer);
        } else {
            return null;
        }
    }

    /**
     * Delete trip
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }

    public function invoice(){
        $this->invoiced = 1;
        $this->save();
    }
}
