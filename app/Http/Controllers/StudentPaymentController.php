<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Validator;
use App\FeeType;
use App\Invoice;
use App\Section;
use App\Setting;
use App\Student;
use App\Accounts;
use App\ClassModel;
use App\InvoiceItem;
use App\Transaction;
use GuzzleHttp\Client;
use App\StudentPayment;
use App\Accounts_detail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;

class StudentPaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class = "all")
    {
        $studentpayments = array();
        if ($class != "all") {
            $studentpayments = StudentPayment::join('invoices', 'invoices.id', '=', 'student_payments.invoice_id')
                ->select('invoices.*', 'student_payments.*', 'student_payments.id as id')
                ->where('invoices.session_id', get_option('academic_year'))
                ->where('invoices.class_id', $class)
                ->where('student_payments.school_id', schoolId())
                ->orderBy('student_payments.id', 'DESC')
                ->get();
        } else {
            $studentpayments = StudentPayment::join('invoices', 'invoices.id', '=', 'student_payments.invoice_id')
                ->select('invoices.*', 'student_payments.*', 'student_payments.id as id')
                ->where('invoices.session_id', get_option('academic_year'))
                ->where('student_payments.school_id', schoolId())
                ->orderBy('student_payments.id', 'DESC')
                ->get();
        }
        
        return view('backend.student_payment.list', compact('studentpayments', 'class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $invoice_id = "")
    {
        $invoice = Invoice::find($invoice_id);

        $invoiceItems = InvoiceItem::where("invoice_id", $invoice_id)->get();

        $invoice_paid = Invoice::where("status", "=", "Paid")->count() + 1;
        // dd($invoice_paid);
        // $payment_method = Accounts::where('master_account', '')->pluck('account_type');

        if ($invoice->school_id != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }
        $accounts = Accounts_detail::where('account_type', '=', '15')->get()->toArray();

        // dd($data);   
        $payment_date = date('d-m-Y'); // Correct format
        // dd($payment_date); // Dump and die (Laravel helper)

        // $history = StudentPayment::where("invoice_id",$studentpayment->invoice_id)->get();
        $history = StudentPayment::where("invoice_id", $invoice_id)->get();
        if (! $request->ajax()) {
            return view('backend.student_payment.create', compact('invoice_id', 'invoice', 'payment_date', 'invoiceItems', 'history', 'invoice_paid', 'accounts'));
        } else {
            return view('backend.student_payment.modal.create', compact('invoice_id', 'invoice', 'payment_date', 'history', 'invoiceItems', 'invoice_paid', 'accounts'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // dd($request->all());
        // dd(
        //     $request->amount,
        //     $request->payable,
        //     collect($request->input('amount'))->sum() <= $request->payable
        // );

        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
            'date' => 'required',
            'account_id' => 'required',
            // 'chart_id' => 'required|array',
            // 'fee_type' => 'required',
            // 'amount[]' => 'required|numeric'
        ]);
        // dd($validator);
        if ($validator->fails()) {
            dd('error');
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect('student_payments/create')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        $school_id = $request->school_id;
        if (checkSchoolId('invoices', $request->invoice_id) != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }

        $chartIds = $request->input('chart_id'); 
        $amounts = $request->input('amount');    

        $accounts = Accounts_detail::whereIn('id', $chartIds)->pluck('account_name', 'id');

        $messageLines = [];
        $calculatedTotal = 0;

        foreach ($chartIds as $index => $chartId) {
            $accountName = $accounts[$chartId] ?? 'Unknown';
            $amount = intval($amounts[$index] ?? 0);
            $calculatedTotal += $amount;
            $messageLines[] = "{$accountName} : {$amount}";
        }

        $paymentDetails = implode("\n", $messageLines);


        $invoice = Invoice::join('students', 'invoices.student_id', '=', 'students.id')
            ->leftJoin('student_sessions', 'students.id', '=', 'student_sessions.student_id')
            ->leftJoin('classes', 'classes.id', '=', 'student_sessions.class_id')
            ->leftJoin('sections', 'sections.id', '=', 'student_sessions.section_id')
            ->leftJoin('parents', 'parents.id', '=', 'students.parent_id')
            ->select('invoices.*', 'students.first_name', 'students.last_name','students.phone','students.home_phone', 'parents.parent_name', 'student_sessions.roll', 'student_sessions.department_id', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
            ->where('student_sessions.session_id', get_option('academic_year'))
            ->where('invoices.session_id', get_option('academic_year'))
            ->where('invoices.id', $request->input('invoice_id'))->first();
        
        $studentName = $invoice['first_name'].' '.$invoice['last_name'];
        $phone = $invoice['phone'];
        $room_no = $invoice['section_name'];
        $home_phone = $invoice['home_phone'];

        $invoice = Invoice::find($request->input('invoice_id')); 

        $settings = Setting::first();
        $company_phone = $settings->phone ?? 'N/A';
        $site = $settings->site_title ?? 'N/A';
        $hostel = $settings->school_name ?? 'Hostel Name';
        $address = $settings->address ?? 'Hostel Address';

        

        // if ($request->input('amount') > ($invoice->total -$invoice->paid)) {
        //     if(! $request->ajax()){
        //         return redirect('student_payments/create')->with('error', _lang('Invalid payable amount'));
        //     }else{
        //        return response()->json(['result'=>'error','message'=>_lang('Invalid payable amount')]);
        //     }
        // }
        // Decode chart_id from the request into an array
        $chart_ids = $request->input('chart_id');
        $ac_type_amount = $request->input('amount'); // amount[] in the form

        if (!is_array($chart_ids) || empty($chart_ids)) {
            return response()->json(['error' => 'Invalid or empty chart_id array'], 400);
        }

        if (!is_array($ac_type_amount) || empty($ac_type_amount)) {
            return response()->json(['error' => 'Invalid or empty amount array'], 400);
        }
        $valid_value = $invoice->total -$invoice->paid < collect($request->input('amount'))->sum();
        
        if($valid_value ){

            return redirect()->back()->with('error' , 'Your amount may exceed the limit or invalid');
        }else{
        $totalAmount = 0;

        foreach ($chart_ids as $index => $chart_id) {
            $amount = $ac_type_amount[$index] ?? 0;

            // Skip if amount is 0 or not numeric
            if (!is_numeric($amount) || floatval($amount) == 0) {
                continue;
            }

            $totalAmount += $amount;

            $transaction = new Transaction();
            $transaction->school_id = schoolId();
            $transaction->trans_date = now();
            $transaction->account_id = $request->input('account_id');
            $transaction->trans_type = $request->input('trans_type');
            $transaction->trans_source_type = $request->input('trans_source_type');
            $transaction->receipt_no = $request->receipt_no;
            $transaction->amount = $amount;
            $transaction->dr_cr = $request->input('dr_cr');
            $transaction->chart_id = $chart_id;
            $transaction->payee_payer_id = $request->input('payee_payer_id');
            $transaction->invoice_id = $request->input('invoice_id');
            $transaction->payment_method_id = $request->input('payment_method_id');
            $transaction->create_user_id = Auth::user()->id;
            $transaction->note = $request->input('note');

            // dd($transaction);
            $transaction->save();
        }


        // Save only once, after looping
        $studentpayment = new StudentPayment();
        $studentpayment->school_id = schoolId();
        $studentpayment->invoice_id = $request->input('invoice_id');
        $studentpayment->date = now();
        $studentpayment->amount = $totalAmount; // ✅ Correct total paid amount
        $studentpayment->note = $request->input('note');
        $studentpayment->save();


        if (($invoice->paid + $studentpayment->amount) >= $invoice->total) {
            $invoice->status = "Paid";
        }
        $invoice->paid = $invoice->paid + $studentpayment->amount;
        $invoice->payment_date = now();

        $invoice->save();
        // dd($invoice);
    }
        $data['invoiceItems'] = InvoiceItem::join("account_detail", "invoice_items.fee_id", "=", "account_detail.id")
            ->where("invoice_id", $request->invoice_id)->get();

        $data['department'] = \App\Department::find($invoice->department_id);
        // $invoice->refresh(); // Reload latest data from DB

        $data['receipt_no'] = $request->receipt_no;


        $data['invoice'] = $invoice;

        $data['currency'] = get_option('currency_symbol');
        $data['total_balance'] = \App\Invoice::where('student_id', $invoice->student_id)->sum('total') - \App\Invoice::where('student_id', $invoice->student_id)->sum('paid');
        // dd($room_no);
        $finalMessage = <<<EOT
            Dear {$studentName}
            We have successfully received the following Payment 
            {$paymentDetails}
            *Total: {$calculatedTotal}*
            *Remaining Balance: {$data['total_balance']}*
            *Room No: {$room_no}*

            If you have any questions or need support, please contact us at {$company_phone}.
            Regards,
            
            {$hostel} - {$address}
            EOT;

            $this->sendWhatsAppMessage($finalMessage,$phone,$home_phone);

        $save_print = $request->save_print;
        if ($request->save_pdf) {
            $pdf = PDF::loadView('backend.pdf.invoices.payslip_pdf', $data, compact('save_print'))->setPaper('A4', 'portrait');

            @unlink('pdf/invoices/' . 'payslip_pdf.pdf');
            $pdf->save('pdf/invoices/' . 'payslip_pdf.pdf');
            // Return response to force download
            return response()->download('pdf/invoices/' . 'payslip_pdf.pdf', 'payslip.pdf', [
                'Content-Type' => 'application/pdf',

            ]);
        }
        $data['student'] = Student::where('id', $invoice->student_id)->first();
        $data['section'] = Section::where('id', $invoice->section_id)->first();

        if(isset($data['section'])){
            $data['section_class'] = ClassModel::where('id', $data['section']->class_id)->first();
        }
        // dd($data);
        if ($request->save_print) {
            return redirect()->to('invoices/feebill/'.$invoice->id.'?type=pay_sllip');
            // return view('backend.pdf.invoices.payslip_pdf', $data, compact('save_print'));
        }
        if ($request->save_back) {
            // dd(redirect('invoices/feebill/' . $request->invoice_id . '?type=' . $type));
            return redirect('/invoices');
        }


        // if(! $request->ajax()){
        //    return redirect('student_payments/create')->with('success', _lang('Information has been added sucessfully'));
        // }
        // else{
        //    return response()->json(['result'=>'success','action'=>'store2','message'=>_lang('Information has been added sucessfully'),'data'=>$studentpayment]);
        // }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $studentpayment = StudentPayment::find($id);

        if ($studentpayment->school_id != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }
        if (! $request->ajax()) {
            return view('backend.student_payment.view', compact('studentpayment', 'id'));
        } else {
            return view('backend.student_payment.modal.view', compact('studentpayment', 'id'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $studentpayment = StudentPayment::find($id);

        if ($studentpayment->school_id != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }
        $history = StudentPayment::where("invoice_id", $studentpayment->invoice_id)->get();
        if (! $request->ajax()) {
            return view('backend.student_payment.edit', compact('studentpayment', 'id', 'history'));
        } else {
            return view('backend.student_payment.modal.edit', compact('studentpayment', 'id', 'history'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
            'date' => 'required',
            'amount' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('student_payments.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
        }


        $studentpayment = StudentPayment::find($id);

        if ($studentpayment->school_id != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }
        $previous_amount = $studentpayment->amount;
        $studentpayment->invoice_id = $request->input('invoice_id');
        $studentpayment->date = $request->input('date');
        $studentpayment->amount = $request->input('amount');
        $studentpayment->note = $request->input('note');

        $studentpayment->save();

        //Update Invoice
        $invoice = Invoice::find($studentpayment->invoice_id);
        if ((($invoice->paid + $studentpayment->amount) - $previous_amount) >= $invoice->total) {
            $invoice->status = "Paid";
        } else {
            $invoice->status = "Unpaid";
        }
        $invoice->paid = (($invoice->paid + $studentpayment->amount) - $previous_amount);
        $invoice->save();

        if (! $request->ajax()) {
            return redirect('student_payments')->with('success', _lang('Information has been updated sucessfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Information has been updated sucessfully'), 'data' => $studentpayment]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentpayment = StudentPayment::find($id);
        $inv = Invoice::find($studentpayment->invoice_id);
        $inv->paid = $inv->paid - $studentpayment->amount;
        $inv->update();

        if ($studentpayment->school_id != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }
        $studentpayment->delete();
        return redirect('student_payments')->with('success', _lang('Information has been deleted sucessfully'));
    }
    public function Get_invoice_sums_by_id(Request $request)
    {
        $transaction = InvoiceItem::where('invoice_id', '111')->sum('amount');
        // dd($transaction);
    }
    public function notify_unpaid(){
       
        $invoice = Invoice::join('students', 'invoices.student_id', '=', 'students.id')
            ->leftJoin('student_sessions', 'students.id', '=', 'student_sessions.student_id')
            ->leftJoin('classes', 'classes.id', '=', 'student_sessions.class_id')
            ->leftJoin('sections', 'sections.id', '=', 'student_sessions.section_id')
            ->leftJoin('parents', 'parents.id', '=', 'students.parent_id')
            ->select('invoices.*', 'students.first_name', 'students.last_name','students.phone','students.home_phone', 'parents.parent_name', 'student_sessions.roll', 'student_sessions.department_id', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
            ->where('student_sessions.session_id', get_option('academic_year'))
            ->where('invoices.session_id', get_option('academic_year'))
            ->where('invoices.status','Unpaid')->get();

        $token = env('WAAPI_TOKEN');
        $settings = Setting::first();
        $company_phone = $settings->phone ?? 'N/A';
        $site = $settings->site_title ?? 'N/A';
        $hostel = $settings->school_name ?? 'Hostel Name';
        $address = $settings->address ?? 'Hostel Address';
// dd($invoice);
        foreach($invoice as $inv){
            
            $phone = $inv->student->phone;
            $home_phone = $inv->student->home_phone;
            $studentName = $inv->student->first_name.' '.$inv->student->last_name;
            $room_no = $inv->student->section_name;
            $paymentDetails = floatval($inv->total) - floatval($inv->paid);
            
            $numbersToSend = [$phone, $home_phone];
// dd($room_no);
            foreach ($numbersToSend as $targetPhone) {
                // Validate phone format: starts with 923, exactly 12 digits
                if (empty($targetPhone) || !preg_match('/^923\d{9}$/', $targetPhone)) {
                    continue;
                }

                try {
                    $message = <<<EOT
                        Dear {$studentName}
                        Your fee payment of {$paymentDetails} is still pending. Please pay immediately 
                        to avoid late fees or service disruption.

                        Thank you,  
                        {$hostel} - {$address}
                        Contact: {$company_phone}
                        EOT;

                    $client = new Client();
                    $response = $client->post('https://waapi.app/api/v1/instances/63281/client/action/send-message', [
                        'headers' => [
                            'accept' => 'application/json',
                            'authorization' => 'Bearer ' . $token,
                            'content-type' => 'application/json',
                        ],
                        'json' => [
                            'chatId' => $targetPhone . '@c.us',
                            'message' => $message,
                            'mentions' => [$targetPhone . '@c.us']
                        ],
                    ]);

                    $responseBody = json_decode($response->getBody()->getContents(), true);

                    if (isset($responseBody['data']['status']) && $responseBody['data']['status'] === 'error') {
                        \Log::warning("WAAPI Error for {$targetPhone}: " . $responseBody['data']['message']);
                        continue;
                    }

                } catch (RequestException $e) {
                    \Log::error("HTTP error for {$targetPhone}: " . $e->getMessage());
                    continue;
                } catch (\Exception $e) {
                    \Log::error("Unexpected error for {$targetPhone}: " . $e->getMessage());
                    continue;
                }
            }


        }
        return redirect()->back()->with('success', _lang('Message sent successfully.'));
    }
    function sendWhatsAppMessage($message,$phone,$home_phone)
    {
        //TODO: Need to remove return
        return true; 
        $token = env('WAAPI_TOKEN');
        $client = new Client();

        $response = $client->post('https://waapi.app/api/v1/instances/63281/client/action/send-message', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$token,
                'content-type' => 'application/json',
            ],
            'json' => [
                'chatId' => $phone.'@c.us',
                'message' => $message,
                'mentions' => [$phone.'@c.us']
            ],
        ]);

        $response = $client->post('https://waapi.app/api/v1/instances/63281/client/action/send-message', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$token,
                'content-type' => 'application/json',
            ],
            'json' => [
                'chatId' => $home_phone.'@c.us',
                'message' => $message,
                'mentions' => [$home_phone.'@c.us']
            ],
        ]);

        $responseRaw = $response->getBody()->getContents();
        $responseBody = json_decode($responseRaw, true);

        if (
            isset($responseBody['data']['status']) &&
            $responseBody['data']['status'] === 'error'
        ) {
            return response()->json([
                'status' => 'error',
                'message' => $responseBody['data']['message'] ?? 'Unknown error occurred.',
                'chatId' => $responseBody['data']['chatId'] ?? null
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully.'
        ]);


        // if ($response->successful()) {
        //     return $response->json();
        // } else {
        //     // Optional: log or return the error response
        //     return response()->json([
        //         'error' => 'Failed to send message',
        //         'details' => $response->body()
        //     ], $response->status());
        // }
    }
}
