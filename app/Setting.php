<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/17/19
 * Time: 4:49 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'value'
    ];
}