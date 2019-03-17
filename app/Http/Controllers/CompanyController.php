<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 3/17/19
 * Time: 7:03 PM
 */

namespace App\Http\Controllers;


use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $viewPath = '/company/';

    public function index(Request $request){
        $company = Company::all()->first();

        if ($request->isMethod('POST')) {
            $data = $request->post();
            $company = Company::all()->first();
            if(!empty($company)) {
                foreach($data['company'] as $property => $value) {
                    $company->{$property} = $value;
                }
                $company->save();
            }
        }

        $inputs = [
            'Name' => (object) [
                'name' => 'name',
                'type' => 'text',
                'value' => $company->name,
                'required' => true
            ],

            'Email' => (object) [
                'name' => 'email',
                'type' => 'email',
                'value' => $company->email,
                'required' => false
            ],

            'Phone' => (object) [
                'name' => 'phone',
                'type' => 'text',
                'phone' => true,
                'value' => $company->phone,
                'required' => false
            ],

            'Address' => (object) [
                'name' => 'address',
                'type' => 'text',
                'address' => true,
                'value' => $company->address,
                'required' => true
            ],

            'CF' => (object) [
                'name' => 'cf',
                'type' => 'text',
                'cf' => true,
                'value' => $company->cf,
                'required' => true
            ],

            'City' => (object) [
                'name' => 'city',
                'type' => 'text',
                'city' => true,
                'value' => $company->city,
                'required' => true
            ],

            'Country' => (object) [
                'name' => 'country',
                'type' => 'text',
                'country' => true,
                'value' => $company->country,
                'required' => true
            ],

            'VAT' => (object) [
                'name' => 'vat',
                'type' => 'text',
                'vat' => true,
                'value' => $company->vat,
                'required' => true
            ],

            'IBAN BGN' => (object) [
                'name' => 'iban_bgn',
                'type' => 'text',
                'iban_bgn' => true,
                'value' => $company->iban_bgn,
                'required' => true
            ],

            'IBAN EUR' => (object) [
                'name' => 'iban_eur',
                'type' => 'text',
                'iban_eur' => true,
                'value' => $company->iban_eur,
                'required' => true
            ],

            'Swift' => (object) [
                'name' => 'swift',
                'type' => 'text',
                'swift' => true,
                'value' => $company->swift,
                'required' => true
            ],

            'Bank' => (object) [
                'name' => 'bank',
                'type' => 'text',
                'bank' => true,
                'value' => $company->bank,
                'required' => false
            ]
        ];

        return view($this->viewPath . 'index', [
            'title' => 'Modify client',
            'description' => 'Modify client company',
            'data' => $company,
            'inputs' => $inputs
        ]);
    }
}