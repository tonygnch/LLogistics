<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 26-Jan-19
 * Time: 21:16
 */

namespace App\Http\Controllers;

use App\Cost;
use App\Driver;
use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    protected $viewPath = '/trips/';

    /**
     * Index action for trips
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = Trip::all()->where('deleted', '=', '0');

        return view($this->viewPath . 'index', [
            'title' => 'All Trips',
            'description' => 'Showing all trips',
            'data' => $data
        ]);
    }

    /**
     * Add action for trips
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $data['departed'] = date("Y-m-d", strtotime($data['departed']));
            $data['arrived'] = date("Y-m-d", strtotime($data['arrived']));

            $trip = new Trip();

            foreach($data as $property => $value) {
                if(!is_array($value))
                    $trip->{$property} = $value;
            }

            $trip->save();

            foreach($data['costs'] as $cost) {
                $cost['trip'] = $trip->id;
                $this->createCost($cost);
            }

            return redirect(route('trips'));
        } else {
            $drivers = $this->getDriversAsObject();
            $clients = $this->getClientsAsObject();
            $trucks = $this->getTruckMakesAsObject();
            $trailers = $this->getTrailerMakesAsObject();

            $inputs = [
                'Driver' => (object) [
                    'name' => 'driver',
                    'type' => 'select',
                    'values' => $drivers,
                    'required' => true
                ],

                'Client' => (object) [
                    'name' => 'client',
                    'type' => 'select',
                    'values' => $clients,
                    'required' => true
                ],

                'Truck' => (object) [
                    'name' => 'truck',
                    'type' => 'select',
                    'values' => $trucks,
                    'required' => true
                ],

                'Trailer' => (object) [
                    'name' => 'trailer',
                    'type' => 'select',
                    'values' => $trailers,
                    'required' => true
                ],

                'Description' => (object) [
                    'name' => 'description',
                    'type' => 'text',
                    'required' => false
                ],

                'Departed' => (object) [
                    'name' => 'departed',
                    'type' => 'date',
                    'required' => false
                ],

                'Arrived' => (object) [
                    'name' => 'arrived',
                    'type' => 'date',
                    'required' => false
                ],

                'Start Point' => (object) [
                    'name' => 'start_point',
                    'type' => 'text',
                    'start_point' => true,
                    'required' => false
                ],

                'End Point' => (object) [
                    'name' => 'end_point',
                    'type' => 'text',
                    'end_point' => true,
                    'required' => true
                ],

                'Distance (km)' => (object) [
                    'name' => 'distance',
                    'type' => 'text',
                    'number' => true,
                    'required' => false
                ]
            ];

            return view($this->viewPath . 'add', [
                'title' => 'Add Trip',
                'inputs' => $inputs,
                'action' => route('addTrip'),
                'description' => 'Add new trip',
                'costs' => true,
                'costsLastId' => $this->getTableLastId('cost')
            ]);
        }
    }

    /**
     * Modify action for trips
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function modify($id, Request $request)
    {
        /** @var Trip $trip */
        $trip = Trip::find($id);

        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $data['departed'] = date("Y-m-d", strtotime($data['departed']));
            $data['arrived'] = date("Y-m-d", strtotime($data['arrived']));

            if(isset($data['costs'])) {
                $costs = $data['costs'];
                unset($data['costs']);
            }
            if(isset($data['newCosts'])) {
                $newCosts = $data['newCosts'];
                unset($data['newCosts']);
            }

            $trip->update($data);

            if(isset($costs)) {
                foreach($costs as $key => $values) {
                    /** @var Cost $cost */
                    $cost = Cost::find($key);
                    if(!empty($cost)) {
                        $cost->update($values);
                    }
                }
            }

            if(isset($newCosts)) {
                foreach($newCosts as $cost) {
                    /** @var array $cost */
                    $cost['trip'] = $trip->id;
                    $this->createCost($cost);
                }
            }

            return redirect(route('trips'));
        } else {
            if(!empty($trip)){
                $drivers = $this->getDriversAsObject();
                $clients = $this->getClientsAsObject();
                $trucks = $this->getTruckMakesAsObject();
                $trailers = $this->getTrailerMakesAsObject();

                $inputs = [
                    'Driver' => (object) [
                        'name' => 'driver',
                        'type' => 'select',
                        'values' => $drivers,
                        'required' => true
                    ],

                    'Client' => (object) [
                        'name' => 'client',
                        'type' => 'select',
                        'values' => $clients,
                        'required' => true
                    ],

                    'Truck' => (object) [
                        'name' => 'truck',
                        'type' => 'select',
                        'values' => $trucks,
                        'required' => true
                    ],

                    'Trailer' => (object) [
                        'name' => 'trailer',
                        'type' => 'select',
                        'values' => $trailers,
                        'required' => true
                    ],

                    'Description' => (object) [
                        'name' => 'description',
                        'type' => 'text',
                        'required' => false
                    ],

                    'Departed' => (object) [
                        'name' => 'departed',
                        'type' => 'date',
                        'required' => false
                    ],

                    'Arrived' => (object) [
                        'name' => 'arrived',
                        'type' => 'date',
                        'required' => false
                    ],

                    'Start Point' => (object) [
                        'name' => 'start_point',
                        'type' => 'text',
                        'start_point' => true,
                        'required' => false
                    ],

                    'End Point' => (object) [
                        'name' => 'end_point',
                        'type' => 'text',
                        'end_point' => true,
                        'required' => true
                    ],

                    'Distance (km)' => (object) [
                        'name' => 'distance',
                        'type' => 'text',
                        'number' => true,
                        'required' => false
                    ]
                ];

                $costs = Cost::all()->where('trip', '=', $trip->id)->where('deleted', '=', 0);;

                return view($this->viewPath . 'modify', [
                    'data' => $trip,
                    'title' => 'Modify trip',
                    'description' => 'Modify trip ' . $trip->name,
                    'inputs' => $inputs,
                    'action' => route('modifyTrip', ['id' => $trip->id]),
                    'costs' => $costs,
                    'costsLastId' => $this->getTableLastId('cost')
                ]);
            } else {
                return redirect(route('trips'));
            }
        }
    }

    /**
     * Delete action for trips
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        /** @var Trip $trip */
        $trip = Trip::find($id);
        if(!empty($trip)) {
            $trip->delete();
        }

        return redirect(route('trips'));
    }
}