<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/16/19
 * Time: 11:22 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class InvoiceTrip extends Model
{
    protected $table = 'invoice_trip';

    public $timestamps = false;

    protected $fillable = [
        'invoice',
        'trip'
    ];
}