<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/16/19
 * Time: 12:45 AM
 */

namespace App\Http\Controllers;

use App\Driver;
use App\Truck;
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

            if($data['truck'] == 0) {
                $data['truck'] = null;
            }

            $driver = new Driver();

            foreach($data as $property => $value) {
                $driver->{$property} = $value;
            }

            $driver->save();
            Truck::takeTruck($data['truck']);

            return redirect(route('drivers'));
        } else {
            $trucks = $this->getTrucksAsObject();

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
                    'default' => 'No Truck',
                    'values' => $trucks,
                    'required' => false
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

    /**
     * Add action for drivers
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modify($id, Request $request)
    {
        /** @var driver $driver */
        $driver = driver::find($id);

        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            if($data['truck'] == 0) {
                $data['truck'] = null;
                if($driver->truck) Truck::releaseTruck($driver->truck);
            } else {
                Truck::releaseTruck($driver->truck);
                Truck::takeTruck($data['truck']);
            }

            $driver->update($data);

            return redirect(route('drivers'));
        } else {
            if(!empty($driver)){
                $trucks = $this->getTrucksAsObject($driver->truck);

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
                        'default' => 'No Truck',
                        'values' => $trucks,
                        'required' => false
                    ]
                ];

                return view($this->viewPath . 'modify', [
                    'title' => 'Modify driver',
                    'description' => 'Modify driver ' . $driver->name,
                    'data' => $driver,
                    'action' => route('modifyDriver', $driver->id),
                    'inputs' => $inputs,
                ]);
            } else {
                return redirect(route('drivers'));
            }
        }
    }

    /**
     * Delete action for drivers
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        /** @var Driver $driver */
        $driver = Driver::find($id);
        if(!empty($driver)) {
            $driver->delete();
        }

        return redirect(route('drivers'));
    }
}