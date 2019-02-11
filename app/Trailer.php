<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trailer extends Model
{
    protected $table = 'trailers';

    public $timestamps = false;

    protected $fillable = [
        'plate',
        'make',
        'model',
        'taken',
        'deleted'
    ];

    /**
     * Take trailer
     * @return void
     */
    public static function takeTrailer($id) {
        $trailer = Trailer::find($id);
        if(!empty($trailer)){
            $trailer->taken = 1;
            $trailer->save();
        }
    }

    /**
     * Release trailer
     * @return void
     */
    public static function releaseTrailer($id) {
        $trailer = Trailer::find($id);
        if(!empty($trailer)){
            $trailer->taken = 0;
            $trailer->save();
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
