<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 26-Jan-19
 * Time: 21:16
 */

namespace App\Http\Controllers;

use App\Trailer;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    protected $viewPath = '/trailers/';

    /**
     * Index action for trailers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = Trailer::all()->where('deleted', '=', '0');

        return view($this->viewPath . 'index', [
            'title' => 'All Trailers',
            'description' => 'Showing all trailers',
            'data' => $data
        ]);
    }

    /**
     * Add action for trailers
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $trailer = new Trailer();

            foreach($data as $property => $value) {
                $trailer->{$property} = $value;
            }

            $trailer->save();

            $this->activityLog::addAddActivityLog('Add trailer "' . $data['plate'] . '"', $this->user->id);

            return redirect(route('trailers'));
        } else {
            $makes = $this->getTrailerMakesAsObject();

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
            ];

            return view($this->viewPath . 'add', [
                'title' => 'Add Trailer',
                'description' => 'Add new trailer',
                'action' => route('addTrailer'),
                'inputs' => $inputs
            ]);
        }
    }

    /**
     * Modify action for trailers
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function modify($id, Request $request)
    {
        /** @var Trailer $trailer */
        $trailer = Trailer::find($id);

        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $trailer->update($data);

            $this->activityLog::addModifyActivityLog('Modify trailer "' . $data['plate'] . '"', $this->user->id);

            return redirect(route('trailers'));
        } else {

            if(!empty($trailer)){
                $makes = $this->getTrailerMakesAsObject();

                $inputs = [
                    'Plate' => (object) [
                        'name' => 'plate',
                        'type' => 'text',
                        'value' => $trailer->plate,
                        'required' => true
                    ],

                    'Make' => (object) [
                        'name' => 'make',
                        'type' => 'select',
                        'check' => $trailer->make,
                        'values' => $makes,
                        'required' => true
                    ],

                    'Model' => (object) [
                        'name' => 'model',
                        'type' => 'text',
                        'value' => $trailer->model,
                        'required' => false
                    ],
                ];

                return view($this->viewPath . 'modify', [
                    'title' => 'Modify Trailer',
                    'description' => 'Modify trailer model ' . $trailer->make . ' ' . $trailer->model,
                    'data' => $trailer,
                    'action' => route('modifyTrailer', ['id' => $trailer->id]),
                    'inputs' => $inputs
                ]);
            } else {
                return redirect(route('trailers'));
            }
        }
    }

    /**
     * Delete action for trailers
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        /** @var Trailer $trailer */
        $trailer = Trailer::find($id);
        if(!empty($trailer)) {
            $trailer->delete();
            $this->activityLog::addDeleteActivityLog('Delete trailer "' . $trailer->plate . '"', $this->user->id);
        }

        return redirect(route('trailers'));
    }
}