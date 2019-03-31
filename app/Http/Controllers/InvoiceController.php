<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 26-Jan-19
 * Time: 21:16
 */

namespace App\Http\Controllers;

use App\Client;
use App\Company;
use App\Cost;
use App\Invoice;
use App\InvoiceTrip;
use App\Trip;
use Illuminate\Http\Request;
use TCPDF;

class InvoiceController extends Controller
{
    protected $viewPath = '/invoices/';

    /**
     * Index action for invoices
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = Invoice::all()->where('deleted', '=', '0')->sortByDesc('date');

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
        if ($request->isMethod('POST')) {
            $data = $request->post();
            unset($data['_token']);
            unset($data['multiselect']);

            $data['date'] = date('Y-m-d H:i:s', strtotime($data['date']));
            if(isset($data['due_date'])) {
                $data['due_date'] = date('Y-m-d H:i:s', strtotime($data['due_date']));
            }

            $invoice = new Invoice();

            foreach ($data as $property => $value) {
                if (!is_array($value))
                    $invoice->{$property} = $value;
            }

            $invoice->save();

            if (isset($data['costs'])) {
                foreach ($data['costs'] as $cost) {
                    $cost['invoice'] = $invoice->id;
                    $this->createCost($cost);
                }
            }

            if (isset($data['trips'])) {
                foreach ($data['trips'] as $trip) {
                    $this->createInvoiceTripItem($invoice->id, $trip);
                }
            }

            $this->activityLog::addAddActivityLog('Add invoice "' . $data['number'] . '"', $this->user->id);

            return redirect(route('invoices'));
        } else {
            $clients = $this->getClientsAsObject();
            $trips = $this->getTripsAsObject();
            $lastInvoice = Invoice::all()->sortByDesc('number')->where('deleted', '=', '0')->first();
            $lastInvoiceNumber = 1;
            if(!empty($lastInvoice))
                $lastInvoiceNumber = $lastInvoice->number + 1;

            $inputs = [
                'Number' => (object)[
                    'name' => 'number',
                    'type' => 'text',
                    'number' => true,
                    'value' => $lastInvoiceNumber,
                    'required' => true
                ],

                'Date' => (object)[
                    'name' => 'date',
                    'type' => 'date',
                    'required' => true
                ],

                'Payment Due Date' => (object) [
                    'name' => 'due_date',
                    'type' => 'date',
                    'required' => true,
                ],

                'Client' => (object)[
                    'name' => 'client',
                    'type' => 'select',
                    'values' => $clients,
                    'required' => true
                ],

                'CMR' => (object) [
                    'name' => 'cmr',
                    'type' => 'text',
                    'number' => 'number',
                    'cmr' => true,
                    'required' => false
                ],

                'Place' => (object)[
                    'name' => 'place',
                    'type' => 'text',
                    'address' => true,
                    'required' => false
                ],

                'Trips' => (object)[
                    'name' => 'trips[]',
                    'type' => 'multipleSelect',
                    'values' => $trips,
                    'required' => false
                ]
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

        if ($request->isMethod('POST')) {
            $data = $request->post();
            unset($data['_token']);

            $data['date'] = date('Y-m-d H:i:s', strtotime($data['date']));
            if(isset($data['due_date'])) {
                $data['due_date'] = date('Y-m-d H:i:s', strtotime($data['due_date']));
            }

            if (isset($data['costs'])) {
                $costs = $data['costs'];
                unset($data['costs']);
            }
            if (isset($data['newCosts'])) {
                $newCosts = $data['newCosts'];
                unset($data['newCosts']);
            }
            if (isset($data['trips'])) {
                $trips = $data['trips'];
                unset($data['trips']);
            }

            $invoice->update($data);

            if (isset($costs)) {
                foreach ($costs as $key => $values) {
                    /** @var Cost $cost */
                    $cost = Cost::find($key);
                    if (!empty($cost)) {
                        $cost->update($values);
                    }
                }
            }

            if (isset($newCosts)) {
                foreach ($newCosts as $cost) {
                    /** @var array $cost */
                    $cost['invoice'] = $invoice->id;
                    $this->createCost($cost);
                }
            }

            if (isset($trips)) {
                $this->deleteAllInvoiceTrips($invoice->id);
                foreach ($trips as $trip) {
                    $this->createInvoiceTripItem($invoice->id, $trip);
                }
            }

            $this->activityLog::addModifyActivityLog('Modify invoice "' . $data['number'] . '"', $this->user->id);

            return redirect(route('invoices'));
        } else {
            if (!empty($invoice)) {
                $clients = $this->getClientsAsObject();
                $trips = $this->getTripsAsObject();

                $inputs = [
                    'Number' => (object)[
                        'name' => 'number',
                        'type' => 'text',
                        'value' => $invoice->number,
                        'number' => true,
                        'required' => false
                    ],

                    'Date' => (object)[
                        'name' => 'date',
                        'type' => 'date',
                        'value' => $invoice->date,
                        'required' => true
                    ],

                    'Payment Due Date' => (object) [
                        'name' => 'due_date',
                        'type' => 'date',
                        'value' => $invoice->due_date,
                        'required' => true,
                    ],

                    'Client' => (object)[
                        'name' => 'client',
                        'type' => 'select',
                        'values' => $clients,
                        'check' => $invoice->client,
                        'required' => true
                    ],

                    'CMR' => (object) [
                        'name' => 'cmr',
                        'type' => 'text',
                        'number' => 'number',
                        'cmr' => true,
                        'value' => $invoice->cmr,
                        'required' => false
                    ],

                    'Place' => (object)[
                        'name' => 'place',
                        'type' => 'text',
                        'address' => true,
                        'value' => $invoice->place,
                        'required' => false
                    ],

                    'Trips' => (object)[
                        'name' => 'trips[]',
                        'type' => 'multipleSelect',
                        'check' => InvoiceTrip::all()->where('invoice', '=', $invoice->id),
                        'values' => $trips,
                        'required' => false
                    ]
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
        if (!empty($invoice)) {
            $invoice->delete();
            $this->activityLog::addDeleteActivityLog('Delete invoice "' . $invoice->number . '"', $this->user->id);
        }

        return redirect(route('invoices'));
    }

    /**
     * Generate pdf
     * @return void
     */
    public function generatePdf($invoice)
    {

        $invoice = Invoice::find($invoice);
        if(!empty($invoice)) {
            $invoiceTrips = InvoiceTrip::all()->where('invoice', '=', $invoice->id);
            $trips = array();
            foreach($invoiceTrips as $invoiceTrip) {
                /** @var Trip $trip */
                $trip = Trip::find($invoiceTrip->trip);
                if(!empty($trip)) {
                    $tripCosts = Cost::all()->where('trip', '=', $trip->id)->where('deleted', '=', 0);
                    $totalTripCosts = 0;
                    foreach($tripCosts as $tripCost)
                        $totalTripCosts += $tripCost->price;
                    $trip->offsetSet('costs', $totalTripCosts);
                    $trips[] = $trip;
                }
            }

            $invoiceCosts = Cost::all()->where('invoice', '=', $invoice->id)->where('deleted', '=', 0);

            $client = Client::find($invoice->client);

            $company = Company::all()->first();

            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($company->name);
            $pdf->SetTitle('Invoice');
            $pdf->SetSubject('Invoice ' . $invoice->number . ' '. $client->name);

            $pdf->setFontSubsetting(true);

            $pdf->setPrintHeader(false);
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // ---------------------------------------------------------

            // add a page
            $pdf->AddPage();

            $pdf->SetFont('freesans', 'B', 15);
            $pdf->Write(0, 'Original/Оригинал', '', false, 'C');

            $pdf->Ln(10);

            // set color for background
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('freesans', 'B', 10);

            // write client title
            $pdf->MultiCell(60, 10, 'ПОЛУЧАТЕЛ / CONSIGNEE', 0, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');

            // write invoice title
            $pdf->MultiCell(60, 10, 'ФАКТУРА/INVOICE', 0, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');

            // write the boss title
            $pdf->MultiCell(60, 10, 'ИЗПЪЛНИТЕЛ / CONSIGNOR', 0, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');


            $pdf->SetFont('freesans', '', 10);

            $clientData =
                $client->name
                . "\n" .
                $client->address
                . "\n" .
                $client->cf . ',' . $client->city
                . "\n" .
                $client->country
                . "\n" .
                "VAT : " . $client->vat;

            // write client data
            $pdf->MultiCell(70, 50, $clientData, 1, 'L', 1, 0, '', '', true, 0, false, true, 50, 'M');


            $invoiceNumber = $invoice->number;

            $invoiceData =
                '№ ' . substr('0000000', strlen((string)$invoiceNumber)) . $invoiceNumber
                . "\n" .
                'Дата / Data : ' . date('d.m.Y', strtotime($invoice->date))
                . "\n" .
                'Известие към фактура / Invoice Notice №'
                . "\n" .
                " "
                . "\n" .
                " O Кредитно / Credit"
                . "\n" .
                " O Дебитно / Debit";

            // write invoice data
            $pdf->MultiCell(40, 50, $invoiceData, 1, 'C', 1, 0, '', '', true, 0, false, true, 50, 'M');

            $bossData =
                $company->name
                . "\n" .
                'Town(village): ' . $company->cf . ' , ' . $company['city'] . ' , ' . $company['country']
                . "\n" .
                'Street: ' . $company->address
                . "\n" .
                "Identification No: " . $company->vat
                . "\n" .
                "VAT IN: BG " . $company->vat
                . "\n" .
                "Person in change : ";

            // write the boss data
            $pdf->MultiCell(70, 50, $bossData, 1, 'L', 1, 1, '', '', true, 0, false, true, 50, 'M');

            $pdf->Ln(2);

            $pdf->SetFont('freesans', 'B', 8);

            $costTitle = 'Описание на стоката(услугата)/Основание за издаване на известие '
                        . "\n" .
                        'Description of the goods(service)/groundsfor notice issuing';

            //Costs titles
            $pdf->Cell(17, 15, '№', 1, 0, 'C');
            $pdf->MultiCell(83, 15, $costTitle, 1, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
            $pdf->Cell(10, 15, 'CMR', 1, 0, 'C');
            $pdf->MultiCell(20, 15, 'Количество' . "\n" .'Quantity', 1, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
            $pdf->MultiCell(25, 15, 'Единична цена' . "\n" .'Unit Price', 1, 'C', 1, 0, '', '', true, 0, false, true, 15, 'M');
            $pdf->MultiCell(25, 15, 'Стойност' . "\n" .'Price', 1, 'C', 1, 1, '', '', true, 0, false, true, 15, 'M');

            $pdf->SetFont('freesans', '', 8);

            //Costs

            $itemsHtml = '';
            $total = 0;
            foreach($trips as $trip) {
                $tripCost = $trip->weight * $client->weight_cost + $trip->costs;
                $itemsHtml .= '
                        <tr>
                          <td width="60.2" height="50" align="center">' . date('d.m.Y', strtotime($trip->departed)) . '</td>
                          <td width="294.1">' . $trip->description . '</td>
                          <td width="35.5" align="center">' . $invoice->cmr . '</td>
                          <td width="70.8" align="center">1</td>
                          <td width="88.6" align="center">' . number_format($tripCost, 2, '.', '') . '</td>
                          <td width="88.6" align="center">' . number_format($tripCost, 2, '.', '') . '</td>
                        </tr>';
                $total += $tripCost;
            }

            $count = 1;
            foreach($invoiceCosts as $invoiceCost) {
                $itemsHtml .= '
                        <tr>
                          <td width="60.2" height="50" align="center">' . $count . '</td>
                          <td width="294.1">' . $invoiceCost->description . '</td>
                          <td width="35.5" align="center">' . '-' . '</td>
                          <td width="70.8" align="center">' . $invoiceCost->amount . '</td>
                          <td width="88.6" align="center">' . number_format($invoiceCost->price, 2, '.', '') . '</td>
                          <td width="88.6" align="center">' . number_format($invoiceCost->price * $invoiceCost->amount, 2, '.', '') . '</td>
                        </tr>';
                $total += $invoiceCost->price * $invoiceCost->amount;
                $count++;
            }

            $tbl = '<table cellspacing="0" cellpadding="1" border="0.8">'
                     . $itemsHtml .
                    '</table>';

            $pdf->writeHTML($tbl, false, false, false, false, '');

            $pdf->SetFont('freesans', 'B', 10);

            $pdf->Cell(155, 0, 'Totale euro (EU) da pagare:', 1, 0, 'L');
            $totalEuro = ($client->currency == 0) ? '€ ' . number_format($total, 2, '.', '') : '';
            $pdf->Cell(25, 0, $totalEuro, 1, 1, 'C');

            $pdf->SetFont('freesans', '', 10);

            $pdf->Cell(155, 0, 'Totale lev (BGN) da pagare:', 1, 0, 'L');
            $totalLev = ($client->currency == 0) ? 'lev ' . number_format($total * EUR_BGN, 2, '.', '') : 'lev ' . number_format($total, 2, '.', '');
            $pdf->Cell(25, 0, $totalLev , 1, 1, 'C');

            $pdf->SetFont('freesans', 'B', 10);

            $pdf->Cell(155, 0, '', 1, 0, 'L');
            $pdf->Cell(25, 0, '', 1, 1, 'C');

            $pdf->SetFont('freesans', 'B, I', 10);

            $pdf->Cell(100, 15, 'Сума за плащане словом/Due sum (in words):', 1, 0, 'C', false, '', 0, false, 'T', 'T');
            $pdf->SetFont('freesans', 'B', 9);
            $pdf->Cell(55, 5, 'Данъчна основа / Tax base:', 1, 0, 'L');
            $pdf->SetFont('freesans', '', 10);
            $totalCost = ($client->currency == 0) ? number_format($total * EUR_BGN, 2, '.', '') : number_format($total, 2, '.', '');
            $pdf->Cell(25, 5, 'lev ' . $totalCost, 1, 1, 'C');

            $pdf->Cell(100, 5, '', 0, 0, 'C', false, '', 0, false, 'T', 'T');
            $pdf->SetFont('freesans', 'B', 9);
            $vatText = ($client->currency == 0) ? 'ДДС / VAT 0 %' : 'ДДС / VAT 20 %';
            $pdf->Cell(55, 5, $vatText, 1, 0, 'L');
            $pdf->SetFont('freesans', '', 10);
            $vatValue = ($client->currency == 0) ? '' : 'lev ' . number_format($total * VAT_VALUE, 2, '.', '');
            $pdf->Cell(25, 5, $vatValue, 1, 1, 'C');

            $pdf->Cell(100, 5, '', 0, 0, 'C', false, '', 0, false, 'T', 'T');
            $pdf->SetFont('freesans', 'B', 9);
            $pdf->Cell(55, 5, 'Сума за плащане/Total due sum:', 1, 0, 'L');
            $pdf->SetFont('freesans', '', 10);
            $totalSum = ($client->currency == 0) ? number_format($total * EUR_BGN, 2, '.', '') : number_format($total + $total * VAT_VALUE, 2, '.', '');
            $pdf->Cell(25, 5, 'lev ' . $totalSum, 1, 1, 'C');


            $pdf->SetFont('freesans', '', 9);
            $bottomLeftText = "Дата на възникване на данъчното събитие на доставката или" . "\n" .
                "дата на плащане(при аванс)/Date of the tax event of the delivery" . "\n" .
                "or the day of payment (in advance payment):_____________________" . "\n\n" .
                "Основание за прилагане на ставка 0 (нула) % / Grounds for" . "\n" .
                "applying 0 (zero) % stake: чл.21, ал.2 от ЗДДС" . "\n" .
                "Основание за неначисляване на данък/Grounds for non imposing" . "\n" .
                "tax:" . "\n\n\n\n" .
                "Получател / Recepient:_______________________________";
            $pdf->MultiCell(100, 40, $bottomLeftText, 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');

            $pdf->SetFont('freesans', 'B', 10);
            $pdf->MultiCell(100, 5, "Начин на плащане: Terms of payment:", 0, 'L', 1, 1, '', '', true, 0, false, true, 100, 'T');

            $pdf->SetFont('freesans', 'B', 10);
            $pdf->SetTextColor(0, 91, 255);

            $pdf->MultiCell(100, 6, '', 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');
            $pdf->MultiCell(100, 6, "IBAN BGN : " . $company->iban_bgn, 0, 'L', 1, 1, '', '', true, 0, false, true, 100, 'T');

            $pdf->MultiCell(100, 6, '', 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');
            $pdf->MultiCell(100, 6, "IBAN EUR : " . $company->iban_eur , 0, 'L', 1, 1, '', '', true, 0, false, true, 100, 'T');

            $pdf->MultiCell(100, 6, '', 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');
            $pdf->MultiCell(25, 6, "Банка/Bank:", 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');

            $pdf->SetTextColor();

            $pdf->MultiCell(50, 6, $company->bank, 0, 'L', 1, 1, '', '', true, 0, false, true, 100, 'T');

            $pdf->MultiCell(100, 6, '', 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');

            $dueDate = '-';
            if(!empty($invoice->due_date))
                $dueDate = date('d.m.Y', strtotime($invoice->due_date));

            $pdf->MultiCell(25, 6, $dueDate, 0, 'L', 1, 1, '', '', true, 0, false, true, 100, 'T');

            $pdf->MultiCell(100, 6, '', 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');
            $pdf->MultiCell(25, 6, 'SWIFT', 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');
            $pdf->MultiCell(25, 8, $company->swift, 0, 'L', 1, 1, '', '', true, 0, false, true, 100, 'T');

            $pdf->MultiCell(100, 6, '', 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');
            $pdf->MultiCell(70, 11, "O ПО БАНКОВ ПЪТ/BANK TRANSFER", 0, 'L', 1, 1, '', '', true, 0, false, true, 100, 'T');

            $pdf->SetFont('freesans', '', 9);

            $pdf->MultiCell(100, 6, '', 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');
            $pdf->MultiCell(100, 6, "Съставил / Issued by:_________________________", 0, 'L', 1, 0, '', '', true, 0, false, true, 100, 'T');

            // reset pointer to the last page
            $pdf->lastPage();

            // ---------------------------------------------------------

            //Close and output PDF document
            $pdf->Output('Invoice ' . $invoice->number . '.pdf', 'I');
        }
    }
}