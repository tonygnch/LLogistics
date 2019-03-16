<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/16/19
 * Time: 11:22 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $table = 'cost';

    public $timestamps = false;

    protected $fillable = [
        'amount',
        'trip',
        'invoice',
        'description',
        'deleted'
    ];

    /**
     * Delete cost
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }
}