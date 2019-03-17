<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 26-Jan-19
 * Time: 21:16
 */

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $viewPath = '/clients/';

    /**
     * Index action for clients
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = Client::all()->where('deleted', '=', '0');

        return view($this->viewPath . 'index', [
            'title' => 'All Clients',
            'description' => 'Showing all clients',
            'data' => $data
        ]);
    }

    /**
     * Add action for clients
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $client = new Client();

            foreach($data as $property => $value) {
                $client->{$property} = $value;
            }

            $client->save();

            return redirect(route('clients'));
        } else {

            $inputs = [
                'Name' => (object) [
                    'name' => 'name',
                    'type' => 'text',
                    'required' => true
                ],

                'Email' => (object) [
                    'name' => 'email',
                    'type' => 'email',
                    'required' => false
                ],

                'Phone' => (object) [
                    'name' => 'phone',
                    'type' => 'text',
                    'phone' => true,
                    'required' => false
                ],

                'Address' => (object) [
                    'name' => 'address',
                    'type' => 'text',
                    'address' => true,
                    'required' => false
                ],

                'CF' => (object) [
                    'name' => 'cf',
                    'type' => 'text',
                    'cf' => true,
                    'required' => false
                ],

                'City' => (object) [
                    'name' => 'city',
                    'type' => 'text',
                    'city' => true,
                    'required' => false
                ],

                'Country' => (object) [
                    'name' => 'country',
                    'type' => 'text',
                    'country' => true,
                    'required' => false
                ],

                'VAT' => (object) [
                    'name' => 'vat',
                    'type' => 'text',
                    'vat' => true,
                    'required' => false
                ],

                '€/kg' => (object) [
                    'name' => 'weight_cost',
                    'type' => 'text',
                    'weight_cost' => true,
                    'required' => false
                ]
            ];

            return view($this->viewPath . 'add', [
                'title' => 'Add Client',
                'inputs' => $inputs,
                'action' => route('addClient'),
                'description' => 'Add new client'
            ]);
        }
    }

    /**
     * Modify action for clients
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function modify($id, Request $request)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);

            $client->update($data);

            return redirect(route('clients'));
        } else {
            if(!empty($client)){

                $inputs = [
                    'Name' => (object) [
                        'name' => 'name',
                        'type' => 'text',
                        'value' => $client->name,
                        'required' => true
                    ],

                    'Email' => (object) [
                        'name' => 'email',
                        'type' => 'email',
                        'value' => $client->email,
                        'required' => false
                    ],

                    'Phone' => (object) [
                        'name' => 'phone',
                        'type' => 'text',
                        'phone' => true,
                        'value' => $client->phone,
                        'required' => false
                    ],

                    'Address' => (object) [
                        'name' => 'address',
                        'type' => 'text',
                        'address' => true,
                        'value' => $client->address,
                        'required' => false
                    ],

                    'CF' => (object) [
                        'name' => 'cf',
                        'type' => 'text',
                        'cf' => true,
                        'value' => $client->cf,
                        'required' => false
                    ],

                    'City' => (object) [
                        'name' => 'city',
                        'type' => 'text',
                        'city' => true,
                        'value' => $client->city,
                        'required' => false
                    ],

                    'Country' => (object) [
                        'name' => 'country',
                        'type' => 'text',
                        'country' => true,
                        'client' => $client->country,
                        'required' => false
                    ],

                    'VAT' => (object) [
                        'name' => 'vat',
                        'type' => 'text',
                        'vat' => true,
                        'value' => $client->vat,
                        'required' => false
                    ],

                    '€/kg' => (object) [
                        'name' => 'weight_cost',
                        'type' => 'text',
                        'weight_cost' => true,
                        'value' => $client->weight_cost,
                        'required' => false
                    ]
                ];

                return view($this->viewPath . 'modify', [
                    'title' => 'Modify client',
                    'description' => 'Modify client ' . $client->name,
                    'data' => $client,
                    'inputs' => $inputs,
                    'action' => route('modifyClient', ['id' => $client->id])
                ]);
            } else {
                return redirect(route('clients'));
            }
        }
    }

    /**
     * Delete action for clients
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        /** @var Client $client */
        $client = Client::find($id);
        if(!empty($client)) {
            $client->delete();
        }

        return redirect(route('clients'));
    }
}