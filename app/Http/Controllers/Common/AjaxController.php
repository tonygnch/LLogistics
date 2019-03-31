<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/16/19
 * Time: 2:51 PM
 */

namespace App\Http\Controllers\Common;


use App\Client;
use App\Cost;
use App\Driver;
use App\Http\Controllers\Controller;
use App\Trip;
use App\Truck;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    /**
     * Get table last id
     * @param string $table
     * @return int|mixed
     */
    public function getTableLastId($table) {
        return $this->getTableLastId($table);
    }

    /**
     * Delete cost
     * @param int $id
     * @return void
     */
    public function deleteCost($id) {
        $cost = Cost::find($id);
        if(!empty($cost))
            $cost->delete();
    }

    /**
     * Get driver truck
     * @param int $driver
     * @return int
     */
    public function getDriverTruck($driver) {
        $driver = Driver::find($driver);
        return $driver->truck;
    }

    /**
     * Get truck trailer
     * @param int $truck
     * @return int
     */
    public function getTruckTrailer($truck) {
        $truck = Truck::find($truck);
        return $truck->trailer;
    }

    /**
     * Get client trips
     * @param int $client
     * @return array
     */
    public function getClientTrips($client) {
        $client = Client::find($client);
        $trips = Trip::all()->where('client', '=', $client->id)->where('deleted', '=', 0)->where('invoiced', '=', 0);
        $tripsArr = array();
        if(!empty($trips) and !empty($client)){
            foreach($trips as $trip) {
                $tripsArr[$trip->id] = [
                    'id' => $trip->id,
                    'client' => $client->name,
                    'route' => $trip->start_point . ' - ' . $trip->end_point,
                    'departed' => date('d M Y', strtotime($trip->departed))
                ];
            }
        }
        return $tripsArr;
    }
}