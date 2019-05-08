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

    public function getDistance($from, $to){
//        return 'test';
        $res = $this->callAPI('GET', 'https://www.distance24.org/route.json?stops="' . $from . '|' . $to . '"');
        $res = json_decode($res);
        return $res->distance;
    }

    private function callAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}