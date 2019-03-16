<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 26-Jan-19
 * Time: 21:16
 */

namespace App\Http\Controllers;

use App\Trailer;
use App\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    protected $viewPath = '/trucks/';

    /**
     * Index action for trucks
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = Truck::all()->where('deleted', '=', '0');

        return view($this->viewPath . 'index', [
            'title' => 'All Trucks',
            'description' => 'Showing all trucks',
            'data' => $data
        ]);
    }

    /**
     * Add action for trucks
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            if($data['trailer'] == 0) {
                $data['trailer'] = null;
            }

            $truck = new Truck();

            foreach($data as $property => $value) {
                $truck->{$property} = $value;
            }

            $truck->save();
            Trailer::takeTrailer($data['trailer']);

            return redirect(route('trucks'));
        } else {
            $trailers = $this->getTrailersAsObject();
            $makes = $this->getTruckMakesAsObject();

            $inputs = [
                'Plate' => (object) [
                    'name' => 'plate',
                    'type' => 'text',
                    'required' => true
                ],

                'Make' => (object) [
                    'name' => 'make',
                    'type' => 'select',
                    'values' => $makes,
                    'required' => true
                ],

                'Model' => (object) [
                    'name' => 'model',
                    'type' => 'text',
                    'required' => false
                ],

                'Trailer' => (object) [
                    'name' => 'trailer',
                    'type' => 'select',
                    'default' => 'No Trailer',
                    'values' => $trailers,
                    'required' => false
                ]
            ];

            return view($this->viewPath . 'add', [
                'title' => 'Add Truck',
                'description' => 'Add new truck',
                'action' => route('addTruck'),
                'inputs' => $inputs,
            ]);
        }
    }

    /**
     * Modify action for trucks
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function modify($id, Request $request)
    {
        /** @var Truck $truck */
        $truck = Truck::find($id);

        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            if($data['trailer'] == 0) {
                $data['trailer'] = null;
                if($truck->trailer) Trailer::releaseTrailer($truck->trailer);
            } else {
                Trailer::takeTrailer($data['trailer']);
            }

            $truck->update($data);

            return redirect(route('trucks'));
        } else {
            if(!empty($truck)){
                $trailers = $this->getTrailersAsObject();
                $makes = $this->getTruckMakesAsObject();

                $inputs = [
                    'Plate' => (object) [
                        'name' => 'plate',
                        'type' => 'text',
                        'value' => $truck->plate,
                        'required' => true
                    ],

                    'Make' => (object) [
                        'name' => 'make',
                        'type' => 'select',
                        'check' => $truck->make,
                        'values' => $makes,
                        'required' => true
                    ],

                    'Model' => (object) [
                        'name' => 'model',
                        'type' => 'text',
                        'value' => $truck->model,
                        'required' => false
                    ],

                    'Trailer' => (object) [
                        'name' => 'trailer',
                        'type' => 'select',
                        'default' => 'No Trailer',
                        'selected' => $truck->trailer(),
                        'check' => $truck->trailer,
                        'values' => $trailers,
                        'required' => false
                    ]
                ];

                return view($this->viewPath . 'modify', [
                    'title' => 'Modify Truck',
                    'description' => 'Modify truck model ' . $truck->make . ' ' . $truck->model,
                    'data' => $truck,
                    'action' => route('modifyTruck', $truck->id),
                    'inputs' => $inputs,
                ]);
            } else {
                return redirect(route('trucks'));
            }
        }
    }

    /**
     * Delete action for trucks
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        /** @var Truck $truck */
        $truck = Truck::find($id);
        if(!empty($truck)) {
            $truck->delete();
        }

        return redirect(route('trucks'));
    }
}