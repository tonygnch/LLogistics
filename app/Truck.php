<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $table = 'truck';

    public $timestamps = false;

    protected $fillable = [
        'plate',
        'make',
        'model',
        'trailer',
        'deleted'
    ];

    /**
     * Get trailer
     * @return Trailer
     */
    public function trailer(){
        if($this->trailer) {
            return Trailer::find($this->trailer);
        } else {
            return null;
        }
    }

    /**
     * Take truck
     * @return void
     */
    public static function takeTruck($id) {
        $truck = Truck::find($id);
        if(!empty($truck)){
            $truck->taken = 1;
            $truck->save();
        }
    }

    /**
     * Release truck
     * @return void
     */
    public static function releaseTruck($id) {
        $truck = Truck::find($id);
        if(!empty($truck)){
            $truck->taken = 0;
            $truck->save();
        }
    }

    /**
     * Delete truck
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }
}
