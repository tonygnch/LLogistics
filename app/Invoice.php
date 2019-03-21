<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    public $timestamps = false;

    protected $fillable = [
        'date',
        'due_date',
        'client',
        'cmr',
        'cmr_file',
        'place',
        'number',
        'deleted'
    ];

    /**
     * Get invoice client
     * @return mixed
     */
    public function client(){
        return Client::find($this->client);
    }

    /**
     * Delete invoice
     * @return bool|null|void
     */
    public function delete(){
        $this->deleted = 1;
        $this->save();
    }
}
