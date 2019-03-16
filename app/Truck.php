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
     * Delete truck
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }
}
