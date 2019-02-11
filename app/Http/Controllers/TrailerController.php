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

            return redirect(route('trailers'));
        } else {
            $trailersModel = new Trailer();
            $makes = $this->constants['trailers']['makes'];

            return view($this->viewPath . 'add', [
                'title' => 'Add Trailer',
                'description' => 'Add new trailer',
                'makes' => $makes,
                'data' => $trailersModel->getFillable()
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

            return redirect(route('trailers'));
        } else {
            $makes = $this->constants['trailers']['makes'];

            if(!empty($trailer)){
                return view($this->viewPath . 'modify', [
                    'title' => 'Modify trailer',
                    'description' => 'Modify trailer model ' . $trailer->make . ' ' . $trailer->model,
                    'makes' => $makes,
                    'data' => $trailer
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
        }

        return redirect(route('trailers'));
    }
}