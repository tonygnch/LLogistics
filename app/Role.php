<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/23/19
 * Time: 10:46 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    public $timestamps = false;

    protected $fillable = [
        'title'
    ];
}