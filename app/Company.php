<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/17/19
 * Time: 7:03 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'city',
        'email',
        'phone',
        'iban_bgn',
        'iban_eur',
        'swift',
        'bank'
    ];
}