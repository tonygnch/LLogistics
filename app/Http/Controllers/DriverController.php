<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/16/19
 * Time: 12:45 AM
 */

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    protected $viewPath = '/drivers/';

    /**
     * Index action for drivers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = Driver::all()->where('deleted', '=', '0');

        return view($this->viewPath . 'index', [
            'title' => 'All Drivers',
            'description' => 'Showing all drivers',
            'data' => $data
        ]);
    }

    /**
     * Add action for drivers
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $trip = new Driver();

            foreach($data as $property => $value) {
                $trip->{$property} = $value;
            }

            $trip->save();

            return redirect(route('drivers'));
        } else {
            $trucks = $this->getTruckMakesAsObject();

            $inputs = [
                'Name' => (object) [
                    'name' => 'name',
                    'type' => 'text',
                    'required' => true
                ],

                'Surname' => (object) [
                    'name' => 'surname',
                    'type' => 'text',
                    'required' => true
                ],

                'Truck' => (object) [
                    'name' => 'truck',
                    'type' => 'select',
                    'values' => $trucks,
                    'required' => true
                ]
            ];

            return view($this->viewPath . 'add', [
                'title' => 'Add Driver',
                'inputs' => $inputs,
                'action' => route('addDriver'),
                'description' => 'Add new driver'
            ]);
        }
    }
}