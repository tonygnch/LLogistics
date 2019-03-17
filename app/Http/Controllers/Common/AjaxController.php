<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/16/19
 * Time: 2:51 PM
 */

namespace App\Http\Controllers\Common;


use App\Cost;
use App\Driver;
use App\Http\Controllers\Controller;
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
}