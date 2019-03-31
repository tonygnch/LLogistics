<?php

namespace App\Http\Controllers;

use App\ActivityLog;
use App\Client;
use App\Cost;
use App\Driver;
use App\Http\Auth\Authentication;
use App\InvoiceTrip;
use App\Role;
use App\Setting;
use App\Trailer;
use App\Trip;
use App\Truck;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $constants;
    public $activityLog;
    public $user;

    public function __construct()
    {
        $auth = new Authentication();

        $oneWeekAgoDate = date("Y-m-d", strtotime( "previous monday"));

        $this->user = $auth->getLoggedUser();
        $this->constants = $this->getConstants();
        $this->activityLog = new ActivityLog();

        $this->defineSettings();
        $driversCount = Driver::all()->where('deleted', '=', 0)->count();
        $clientsCount = Client::all()->where('deleted', '=', 0)->count();
        $tripsCount = Trip::all()->where('departed', '>', $oneWeekAgoDate)->where('deleted', '=', 0)->count();

        $homeTrips = Trip::all()->where('departed', '>', $oneWeekAgoDate)->where('deleted', '=', 0);

        View::share('menus', json_decode(json_encode($this->constants['menus']), FALSE));
        View::share('driversCount', $driversCount);
        View::share('clientsCount', $clientsCount);
        View::share('tripsCount', $tripsCount);
        View::share('homeTrips', $homeTrips);
        View::share('user', $this->user);
    }

    public function getConstants() {
        return require(__DIR__ . '../../../../config/constants.php');
    }

    /**
     * Get trailers as object
     * @param int $withTrailer
     * @return \stdClass
     */
    public function getTrailersAsObject($withTrailer = null){
        $trailersModels = Trailer::all()->where('deleted', '=', 0)->where('taken', '=', 0);
        if(!empty($withTrailer))
            $trailersModels->add(Trailer::find($withTrailer));
        $trailers = [];
        foreach($trailersModels as $trailer) {
            $trailers[$trailer->id]['value'] = $trailer->id;
            $trailers[$trailer->id]['option'] = $trailer->plate . ' ' . $trailer->make;
        }
        return json_decode(json_encode($trailers));
    }

    /**
     * Get all trailers as object
     * @return \stdClass
     */
    public function getTakenTrailersAsObject(){
        $trailersModels = Trailer::all()->where('deleted', '=', 0)->where('taken', '=', 1);
        $trailers = [];
        foreach($trailersModels as $trailer) {
            $trailers[$trailer->id]['value'] = $trailer->id;
            $trailers[$trailer->id]['option'] = $trailer->plate . ' ' . $trailer->make;
        }
        return json_decode(json_encode($trailers));
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
        return json_decode(json_encode($makes));
    }

    /**
     * Get trucks as object
     * @param int $withTruck
     * @return \stdClass
     */
    public function getTrucksAsObject($withTruck = null){
        $trucks = Truck::all()->where('deleted', '=', 0)->where('taken', '=', 0);
        if(!empty($withTruck))
            $trucks->add(Truck::find($withTruck));
        $trucksArr = [];
        foreach ($trucks as $key => $truck) {
            $trucksArr[$key]['value'] = $truck->id;
            $trucksArr[$key]['option'] = $truck->plate . ' - ' . $truck->make;
        }
        return json_decode(json_encode($trucksArr));
    }

    /**
     * Get all trucks as object
     * @return \stdClass
     */
    public function getAllTrucksWithTrailersAsObject(){
        $trucks = Truck::all()->where('deleted', '=', 0)->where('trailer', '!=', null);
        $trucksArr = [];
        foreach ($trucks as $key => $truck) {
            $trucksArr[$key]['value'] = $truck->id;
            $trucksArr[$key]['option'] = $truck->plate . ' - ' . $truck->make;
        }
        return json_decode(json_encode($trucksArr));
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
        return json_decode(json_encode($makes));
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
        return json_decode(json_encode($clientsArr));
    }

    /**
     * Get all available drivers as object
     * @return mixed
     */
    public function getDriversAsObject(){
        $drivers = Driver::all()->where('deleted', '=', 0);
        $driversArr = [];
        foreach($drivers as $key => $driver) {
            $driversArr[$key]['value'] = $driver->id;
            $driversArr[$key]['option'] = $driver->name . ' ' . $driver->surname;
        }
        return json_decode(json_encode($driversArr));
    }

    /**
     * Get all available drivers as object
     * @return mixed
     */
    public function getTripsAsObject(){
        $trips = Trip::all()->where('deleted', '=', 0);
        $tripsArr = [];
        foreach($trips as $key => $trip) {
            $tripsArr[$key]['value'] = $trip->id;
            $tripsArr[$key]['option'] = $trip->client()->name . ' | ' . $trip->start_point . ' - ' . $trip->end_point . ' | ' . date('d M Y', strtotime($trip->departed));
        }
        return json_decode(json_encode($tripsArr));
    }

    /**
     * Get all roles as object
     * @return mixed
     */
    public function getRolesAsObject(){
        $roles = Role::all();
        $rolesArr = [];
        foreach($roles as $key => $role) {
            $rolesArr[$key]['value'] = $role->id;
            $rolesArr[$key]['option'] = $role->title;
        }

        return json_decode(json_encode($rolesArr));
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
     * Create invoice trip
     * @param int $invoice
     * @param int $trip
     * @return void
     */
    public function createInvoiceTripItem($invoice, $trip) {
        $invoiceTrip = new InvoiceTrip();

        $invoiceTrip->invoice = $invoice;
        $invoiceTrip->trip = $trip;

        $invoiceTrip->save();

        /** @var Trip $trip */
        $trip = Trip::find($trip);
        $trip->invoice();
    }

    /**
     * Delete all invoice trips
     * @param int $invoice
     * @throws \Exception
     * @return void
     */
    public function deleteAllInvoiceTrips($invoice) {
        $invoiceTrips = InvoiceTrip::all()->where('invoice', '=', $invoice);

        /** @var InvoiceTrip $invoiceTrip */
        foreach($invoiceTrips as $invoiceTrip)
            $invoiceTrip->delete();
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

    /**
     * Define settings
     * @return void
     */
    public function defineSettings(){
        $settings = Setting::all();

        foreach($settings as $setting) {
            define($setting->title, $setting->value);
        }
    }
}
