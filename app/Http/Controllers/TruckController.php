<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 26-Jan-19
 * Time: 21:16
 */

namespace App\Http\Controllers;

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

            $truck = new Truck();

            foreach($data as $property => $value) {
                $truck->{$property} = $value;
            }

            $truck->save();

            return redirect(route('trucks'));
        } else {
            $trucksModel = new Truck();
            $makes = $this->constants['makes'];

            return view($this->viewPath . 'add', [
                'title' => 'Add Truck',
                'description' => 'Add new truck',
                'makes' => $makes,
                'data' => $trucksModel->getFillable()
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

            $truck->update($data);

            return redirect(route('trucks'));
        } else {

            if(!empty($truck)){
                return view($this->viewPath . 'modify', [
                    'title' => 'Modify truck',
                    'description' => 'Modify truck model ' . $truck->make . ' ' . $truck->model,
                    'data' => $truck
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