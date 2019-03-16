<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 26-Jan-19
 * Time: 21:16
 */

namespace App\Http\Controllers;

use App\Cost;
use App\Invoice;
use App\InvoiceTrip;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $viewPath = '/invoices/';

    /**
     * Index action for invoices
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = Invoice::all()->where('deleted', '=', '0');

        return view($this->viewPath . 'index', [
            'title' => 'All Invoices',
            'description' => 'Showing all invoices',
            'data' => $data
        ]);
    }

    /**
     * Add action for invoices
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $data['date'] = date('Y-m-d H:i:s', strtotime($data['date']));

            $invoice = new Invoice();

            foreach($data as $property => $value) {
                if(!is_array($value))
                    $invoice->{$property} = $value;
            }

            $invoice->save();

            if(isset($data['costs'])) {
                foreach($data['costs'] as $cost) {
                    $cost['invoice'] = $invoice->id;
                    $this->createCost($cost);
                }
            }

            if(isset($data['trips'])) {
                foreach($data['trips'] as $trip) {
                    $this->createInvoiceTripItem($invoice->id, $trip);
                }
            }

            return redirect(route('invoices'));
        } else {
            $clients = $this->getClientsAsObject();
            $trips = $this->getTripsAsObject();

            $inputs = [
                'Number' => (object) [
                    'name' => 'number',
                    'type' => 'text',
                    'number' => true,
                    'required' => true
                ],

                'Date' => (object) [
                    'name' => 'date',
                    'type' => 'date',
                    'required' => true
                ],

                'Client' => (object) [
                    'name' => 'client',
                    'type' => 'select',
                    'values' => $clients,
                    'required' => true
                ],

                'Trips' => (object) [
                    'name' => 'trips[]',
                    'type' => 'multipleSelect',
                    'values' => $trips,
                    'required' => true
                ]
//
//                'CMR' => (object) [
//                    'name' => 'cmr',
//                    'type' => 'file',
//                    'required' => false
//                ]
            ];

            return view($this->viewPath . 'add', [
                'title' => 'Add Invoice',
                'description' => 'Add new invoice',
                'inputs' => $inputs,
                'action' => route('addInvoice'),
                'costs' => true,
                'costsLastId' => $this->getTableLastId('cost')
            ]);
        }
    }

    /**
     * Modify action for invoices
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function modify($id, Request $request)
    {
        /** @var Invoice $invoice */
        $invoice = Invoice::find($id);

        if($request->isMethod('POST')){
            $data = $request->post();
            unset($data['_token']);

            $data['date'] = date('Y-m-d H:i:s', strtotime($data['date']));

            if(isset($data['costs'])) {
                $costs = $data['costs'];
                unset($data['costs']);
            }
            if(isset($data['newCosts'])) {
                $newCosts = $data['newCosts'];
                unset($data['newCosts']);
            }
            if(isset($data['trips'])) {
                $trips = $data['trips'];
                unset($data['trips']);
            }

            $invoice->update($data);

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
                    $cost['invoice'] = $invoice->id;
                    $this->createCost($cost);
                }
            }

            if(isset($trips)) {
                $this->deleteAllInvoiceTrips($invoice->id);
                foreach($trips as $trip) {
                    $this->createInvoiceTripItem($invoice->id, $trip);
                }
            }

            return redirect(route('invoices'));
        } else {
            if(!empty($invoice)){
                $clients = $this->getClientsAsObject();
                $trips = $this->getTripsAsObject();

                $inputs = [
                    'Number' => (object) [
                        'name' => 'number',
                        'type' => 'text',
                        'value' => $invoice->number,
                        'number' => true,
                        'required' => false
                    ],

                    'Date' => (object) [
                        'name' => 'date',
                        'type' => 'date',
                        'value' => $invoice->date,
                        'required' => true
                    ],

                    'Client' => (object) [
                        'name' => 'client',
                        'type' => 'select',
                        'values' => $clients,
                        'check' => $invoice->client,
                        'required' => true
                    ],

                    'Trips' => (object) [
                        'name' => 'trips[]',
                        'type' => 'multipleSelect',
                        'check' => InvoiceTrip::all()->where('invoice', '=', $invoice->id),
                        'values' => $trips,
                        'required' => true
                    ]

//                    'CMR' => (object) [
//                        'name' => 'cmr',
//                        'type' => 'file',
//                        'value' => $invoice->cmr,
//                        'required' => false
//                    ]
                ];

                $costs = Cost::all()->where('invoice', '=', $invoice->id)->where('deleted', '=', 0);

                return view($this->viewPath . 'modify', [
                    'data' => $invoice,
                    'title' => 'Modify invoice',
                    'description' => 'Modify invoice ' . $invoice->name,
                    'inputs' => $inputs,
                    'action' => route('modifyInvoice', $invoice->id),
                    'costs' => $costs,
                    'costsLastId' => $this->getTableLastId('cost')
                ]);
            } else {
                return redirect(route('invoices'));
            }
        }
    }

    /**
     * Delete action for invoices
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        /** @var Invoice $invoice */
        $invoice = Invoice::find($id);
        if(!empty($invoice)) {
            $invoice->delete();
        }

        return redirect(route('invoices'));
    }
}