<?php

namespace App\Http\Controllers;

use App\Client;
use App\Cost;
use App\Driver;
use App\Trailer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $constants;

    public function __construct()
    {
        $this->constants = $this->getConstants();
        View::share('menus', json_decode(json_encode($this->constants['menus']), FALSE));
    }

    public function getConstants() {
        return require(__DIR__ . '../../../../config/constants.php');
    }

    /**
     * Get trailers as object
     * @return \stdClass
     */
    public function getTrailersAsObject(){
        $trailersModels = Trailer::all()->where('deleted', '=', 0)->where('taken', '=', 0);
        $trailers = [];
        foreach($trailersModels as $trailer) {
            $trailers[$trailer->id]['value'] = $trailer->id;
            $trailers[$trailer->id]['option'] = $trailer->plate . ' ' . $trailer->make;
        }
        return json_decode(json_encode($trailers), FALSE);
    }

    /**
     * Get truck makes as object
     * @return \stdClass
     */
    public function getTruckMakesAsObject(){
        $makes = [];
        foreach ($this->constants['trucks']['makes'] as $key => $make) {
            $makes[$key]['value'] = $make;
            $makes[$key]['option'] = $make;
        }
        return json_decode(json_encode($makes), FALSE);
    }

    /**
     * Get trailer makes as object
     * @return \stdClass
     */
    public function getTrailerMakesAsObject(){
        $makes = [];
        foreach ($this->constants['trailers']['makes'] as $key => $make) {
            $makes[$key]['value'] = $make;
            $makes[$key]['option'] = $make;
        }
        return json_decode(json_encode($makes), FALSE);
    }

    /**
     * Get trailer makes as object
     * @return \stdClass
     */
    public function getClientsAsObject(){
        $clients = Client::all()->where('deleted', '=', 0);
        $clientsArr = [];
        foreach ($clients as $key => $client) {
            $clientsArr[$key]['value'] = $client->id;
            $clientsArr[$key]['option'] = $client->name;
        }
        return json_decode(json_encode($clientsArr), FALSE);
    }

    /**
     * Get all available drivers as object
     * @return mixed
     */
    public function getDriversAsObject(){
        $drivers = Driver::all();
        $driversArr = [];
        foreach($drivers as $key => $driver) {
            $driversArr[$key]['value'] = $driver->id;
            $driversArr[$key]['option'] = $driver->name . ' ' . $driver->surname;
        }
        return json_decode(json_encode($driversArr), FALSE);
    }

    /**
     * Create new cost
     * @param array $attributes
     * return void
     */
    public function createCost($attributes)
    {
        $cost = new Cost();

        foreach($attributes as $property => $value)
            $cost->{$property} = $value;

        $cost->save();
    }

    /**
     * Get table next id
     * @param string $table
     * @return int|mixed
     */
    public function getTableLastId($table) {
        $nextId = DB::table($table)->max('id') + 1;

        return $nextId;
    }
}
