<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Accounts;
use App\Accounts_detail;
use App\InvoiceItem;
use App\StudentPayment;
use App\Transaction;
use Auth;
use Validator;
use Illuminate\Validation\Rule;
use PDF;

class InvoiceController extends Controller
{

    public function index(Request $request, $class="all")
    {
        $class = $request->input("class_id")??"all";		
        $section_id = $request->input("section_id")??"all";
        $invoiceStatus = $request->input("status_id")??"all";
 
		if($request->ajax())
		{
			$query = Invoice::join('students','invoices.student_id','=','students.id')
				->leftJoin('student_sessions','students.id','=','student_sessions.student_id')
				->leftJoin('classes','classes.id','=','student_sessions.class_id')
				->leftJoin('sections','sections.id','=','student_sessions.section_id')
				->select(
					'invoices.*',
					'students.first_name',
					'students.last_name',
					'student_sessions.roll',
					'classes.class_name',
					'sections.section_name',
					'invoices.id as id'
				)
				->where('student_sessions.session_id', get_option('academic_year'))
				->where('invoices.session_id', get_option('academic_year'))
				->where('invoices.school_id', schoolId());

			// Dynamically apply filters
			if ($class !== 'all') {
				$query->where('invoices.class_id', $class);
			}

			if ($section_id !== 'all') {
				$query->where('invoices.section_id', $section_id);
			}

			if ($invoiceStatus !== 'all') {
				$query->where('invoices.status', $invoiceStatus);
			}

			$invoices = $query->orderBy('invoices.id', 'DESC')->get();

			return response()->json(['data' => $invoices]);

		}
		else					
        	return view('backend.invoice.list',compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$account_type = Accounts_detail::get();
		if( ! $request->ajax()){
		   return view('backend.invoice.create', compact('account_type'));
		}else{
           return view('backend.invoice.modal.create', compact('account_type'));
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
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);
		
		$validator = Validator::make($request->all(), [
			'student_id' => 'required',
			'class_id' => 'required',
			'section_id' => 'required',
			'due_date' => 'required',
			'title' => 'required|max:191',
			'total' => 'required|numeric',
			'status' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('invoices/create')
							->withErrors($validator)
							->withInput();
			}			
		}

		if ($request->class_id !='All') {
            if (checkSchoolId('classes',$request->class_id) != schoolId()) {
                return redirect()->back()->with('error','access denied');
            }
        }
        if ($request->section_id !='All') {
            if (checkSchoolId('sections',$request->section_id) != schoolId()) {
                return redirect()->back()->with('error','access denied');
            }
        }
		
        if($request->input('student_id') == "all"){
			foreach($request->input('students') as $student_id){
				if (checkSchoolId('students',$student_id) != schoolId()) {
	                return redirect()->back()->with('error','access denied');
	            }
				$invoice= new Invoice();
				$invoice->student_id = $student_id;
				$invoice->school_id = schoolId();
				$invoice->class_id = get_student_class_section($student_id,get_option('academic_year'),'class_id');
				$invoice->section_id = get_student_class_section($student_id,get_option('academic_year'),'section_id');
				$invoice->session_id = get_option('academic_year');
				$invoice->due_date = $request->input('due_date');
				$invoice->title = $request->input('title');
				$invoice->description = $request->input('description');
				$invoice->total = $request->input('total');
				$invoice->status = $request->input('status');
			
				$invoice->save();
				
				//Store Invoice Item
				$counter = 0;
				foreach($request->input("chart_id") as $fee_id){
					if($request->input("amount")[$counter] == 0 && $fee_id==""){
						continue;
					}
					$invoiceItem = new InvoiceItem();
					$invoiceItem->school_id = $invoice->school_id;
					$invoiceItem->invoice_id = $invoice->id;
					$invoiceItem->fee_id = $fee_id;
					$invoiceItem->amount = $request->input("amount")[$counter];
					$invoiceItem->discount = $request->input("discount")[$counter];

				    $invoiceItem->save();
					
					$counter++;
				}
			}
		}else{
			//Store Single Student Invoice
			if (checkSchoolId('students',$request->input('student_id')) != schoolId()) {
                return redirect()->back()->with('error','access denied');
            }
			$invoice= new Invoice();
			$invoice->student_id = $request->input('student_id');
			$invoice->school_id = schoolId();
			$invoice->class_id = get_student_class_section($request->input('student_id'),get_option('academic_year'),'class_id');
			$invoice->section_id = get_student_class_section($request->input('student_id'),get_option('academic_year'),'section_id');
			$invoice->session_id = get_option('academic_year');
			$invoice->due_date = $request->input('due_date');
			$invoice->title = $request->input('title');
			$invoice->description = $request->input('description');
			$invoice->total = $request->input('total');
			$invoice->status = $request->input('status');
		
			$invoice->save();
			
			//Store Invoice Item
			$counter = 0;
			foreach($request->input("chart_id") as $fee_id){
				if($request->input("amount")[$counter] == 0){
					continue;
				}
				$invoiceItem = new InvoiceItem();
				$invoiceItem->school_id = $invoice->school_id;
				$invoiceItem->invoice_id = $invoice->id;
				$invoiceItem->fee_id = $fee_id;
				$invoiceItem->amount = $request->input("amount")[$counter];
				$invoiceItem->discount = $request->input("discount")[$counter];
				$invoiceItem->save();
				
				$counter++;
			}
		}
        
		if(! $request->ajax()){
           return redirect('invoices/create')->with('success', _lang('Invoice Created sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Invoice Created sucessfully'),'data'=>$invoice]);
		}
        
   }
    public function as_assigned(Request $request)
    {
    	//dd($request->all());
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);
		
		$validator = Validator::make($request->all(), [
			'student_id_assign' => 'required',
			'class_id_assign' => 'required',
			'section_id_assign' => 'required',
			'due_date_assign' => 'required',
			'title_assign' => 'required|max:191',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('invoices/create')
							->withErrors($validator)
							->withInput();
			}			
		}

		if ($request->class_id_assign !='All') {
            if (checkSchoolId('classes',$request->class_id_assign) != schoolId()) {
                return redirect()->back()->with('error','access denied');
            }
        }
        if ($request->section_id_assign !='All') {
            if (checkSchoolId('sections',$request->section_id_assign) != schoolId()) {
                return redirect()->back()->with('error','access denied');
            }
        }
		
        if($request->input('student_id_assign') == "all"){
        	if(!empty($request->input('students_assign'))){
				foreach($request->input('students_assign') as $student_id){
					if (checkSchoolId('students',$student_id) != schoolId()) {
		                return redirect()->back()->with('error','access denied');
		            }
		            $student_data = \App\Student::find($student_id);

		            if (!empty($student_data) && count($student_data->Assign_fees)>0) {

		            	$invoice= new Invoice();
						$invoice->student_id = $student_id;
						$invoice->school_id = schoolId();
						$invoice->class_id = get_student_class_section($student_data->id,get_option('academic_year'),'class_id');
						$invoice->section_id = get_student_class_section($student_data->id,get_option('academic_year'),'section_id');
						$invoice->session_id = get_option('academic_year');
						$invoice->due_date = $request->input('due_date_assign');
						$invoice->title = $request->input('title_assign');
						$invoice->description = $request->input('description_assign');
						$invoice->total = $student_data->Assign_fees->sum('amount') - $student_data->Assign_fees->sum('discount');
						$invoice->status ="Unpaid";
					
						$invoice->save();
						
						//Store Invoice Item
						foreach($student_data->Assign_fees as $key => $row){
							$invoiceItem = new InvoiceItem();
							$invoiceItem->school_id = $invoice->school_id;
							$invoiceItem->invoice_id = $invoice->id;
							$invoiceItem->fee_id = $row->fee_id;
							$invoiceItem->amount = $row->amount;
							$invoiceItem->discount = $row->discount;
						    $invoiceItem->save();
						}

		            }

					
				}
			}else{
				return redirect('invoices/create')
							->with('success','Please Select Student')
							->withInput();
			}
		}else{
			//Store Single Student Invoice
			if (checkSchoolId('students',$request->input('student_id_assign')) != schoolId()) {
                return redirect()->back()->with('error','access denied');
            }
			

			$student_data = \App\Student::find($request->input('student_id_assign'));

            if (!empty($student_data) && count($student_data->Assign_fees)>0) {

            	$invoice= new Invoice();
				$invoice->student_id = $student_data->id;
				$invoice->school_id = schoolId();
				$invoice->class_id = get_student_class_section($student_data->id,get_option('academic_year'),'class_id');
				$invoice->section_id = get_student_class_section($student_data->id,get_option('academic_year'),'section_id');
				$invoice->session_id = get_option('academic_year');
				$invoice->due_date = $request->input('due_date_assign');
				$invoice->title = $request->input('title_assign');
				$invoice->description = $request->input('description_assign');
				$invoice->total = $student_data->Assign_fees->sum('amount') - $student_data->Assign_fees->sum('discount');
				$invoice->status ="Unpaid";
			
				$invoice->save();
				
				//Store Invoice Item
				foreach($student_data->Assign_fees as $key => $row){
					$invoiceItem = new InvoiceItem();
					$invoiceItem->school_id = $invoice->school_id;
					$invoiceItem->invoice_id = $invoice->id;
					$invoiceItem->fee_id = $row->fee_id;
					$invoiceItem->amount = $row->amount;
					$invoiceItem->discount = $row->discount;
				    $invoiceItem->save();
				}

            }
		}
        
		if(! $request->ajax()){
           return redirect('invoices/create')->with('success', _lang('Invoice Created sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Invoice Created sucessfully'),'data'=>$invoice]);
		}
        
   }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    { 
		$invoice = Invoice::join('students','invoices.student_id','=','students.id')
							->join('student_sessions','students.id','=','student_sessions.student_id')
                            ->join('classes','classes.id','=','student_sessions.class_id')
                            ->join('sections','sections.id','=','student_sessions.section_id')
							->select('invoices.*','students.first_name','students.last_name','student_sessions.roll','classes.class_name','sections.section_name','invoices.id as id')						
							->where('student_sessions.session_id',get_option('academic_year'))
							->where('invoices.session_id',get_option('academic_year'))
							->where('invoices.id',$id)->first();

							if ($invoice->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

		$invoiceItems = InvoiceItem::join("fee_types","invoice_items.fee_id","=","fee_types.id")
		                ->where("invoice_id",$id)->get();
						
		$transactions = StudentPayment::where("invoice_id",$id)->get();
		$department = \App\Department::find($invoice->department_id);

		$currency=get_option('currency_symbol');
		
		if(! $request->ajax()){
		    return view('backend.invoice.view-new',compact('invoice','id','invoiceItems','transactions','department','currency'));
		}else{
			return view('backend.invoice.modal.view-new',compact('invoice','id','invoiceItems','transactions','department','currency'));
		} 
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $invoice = Invoice::where("id",$id)
				   ->where("session_id",get_option('academic_year'))->first();


		if ($invoice->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        if(empty($invoice)){
			abort(404);
		}
		$invoiceItems = InvoiceItem::where("invoice_id",$id)->get();
		if(! $request->ajax()){
		   return view('backend.invoice.edit',compact('invoice','id','invoiceItems'));
		}else{
           return view('backend.invoice.modal.edit',compact('invoice','id','invoiceItems'));
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
	    @ini_set('max_execution_time', 0);
		@set_time_limit(0);
		
		$validator = Validator::make($request->all(), [
			'student_id' => 'required',
			'class_id' => 'required',
			'section_id' => 'required',
			'due_date' => 'required',
			'title' => 'required|max:191',
			'total' => 'required|numeric',
			'status' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('invoices.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}

		if (checkSchoolId('classes',$request->class_id) != schoolId() || checkSchoolId('sections',$request->section_id) != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
		
	
		//Store Single Student Invoice
		$invoice= Invoice::find($id);

		if ($invoice->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

		$invoice->student_id = $request->input('student_id');
		$invoice->class_id = $request->input('class_id');
		$invoice->section_id = $request->input('section_id');
		$invoice->due_date = $request->input('due_date');
		$invoice->title = $request->input('title');
		$invoice->description = $request->input('description');
		$invoice->total = $request->input('total');
		$invoice->status = $request->input('status');
	
		$invoice->save();
		
		//Remove All Items
		$invoiceItem = InvoiceItem::where("invoice_id",$id);
		$invoiceItem->delete();
		
		//Store Invoice Item
		$counter = 0;
		foreach($request->input("chart_id") as $fee_id){
			if($request->input("amount")[$counter] == 0){
				continue;
			}
			$invoiceItem = new InvoiceItem();
			$invoiceItem->school_id = $invoice->school_id;
			$invoiceItem->invoice_id = $invoice->id;
			$invoiceItem->fee_id = $fee_id;
			$invoiceItem->amount = $request->input("amount")[$counter];
			$invoiceItem->discount = $request->input("discount")[$counter];
			$invoiceItem->save();
			
			$counter++;
		}
		
		
		if(! $request->ajax()){
           return redirect('invoices')->with('success', _lang('Invoice updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Invoice updated sucessfully'),'data'=>$invoice]);
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
        $invoice = Invoice::find($id);


		if ($invoice->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        $invoice->delete();
		
		$std_pay = StudentPayment::where("invoice_id",$id);
		$std_pay->delete();
		$invoiceItem = InvoiceItem::where("invoice_id",$id);
		$invoiceItem->delete();
				
        return redirect('invoices')->with('success',_lang('Invoice Removed sucessfully'));
    }
    public function fee_receipt($class,$section,$session){
		$invoices = array();
		if ($session=='0') {
			$session = get_option('academic_year');
		}
		if( $class && $section && $session){
			$invoices = Invoice::join('students','invoices.student_id','=','students.id')
							->leftJoin('student_sessions','students.id','=','student_sessions.student_id')
							->leftJoin('classes','classes.id','=','student_sessions.class_id')
							->leftJoin('sections','sections.id','=','student_sessions.section_id')
							->select('invoices.*','students.first_name','students.last_name','students.register_no','student_sessions.roll','classes.class_name','sections.section_name','invoices.id as id')
							->where('invoices.school_id',schoolId())
							->where('invoices.status','Unpaid')
							->where('invoices.session_id',$session)
							->orderBy("invoices.class_id","ASC")
							->orderBy("invoices.section_id","ASC")
							->orderBy("invoices.student_id","ASC")
							->orderBy("invoices.due_date","DESC")
							->get();
			if ($class !='All') {
				$invoices = $invoices->where('class_id',$class);
			}
			if ($section !='All') {
				$invoices = $invoices->where('section_id',$section);
			}
		}
		// dd($invoices);
        return view('backend.invoice.fee_receipt',compact('invoices','class','section','session'));
    }
    public function fee_receipt_store(Request $request){
		if (empty($request->input("invoice_id"))) {
            return redirect()->back()->with('error','Please select invoice!.');
        }
    	$validator = Validator::make($request->all(), [
			'account_id' => 'required',
            'payment_method_id' => 'required',
            'chart_id' => 'required',
			'invoice_id' => 'required|array',
			'receipt_no' => 'required|array',
			'receipt_date' => 'required|array'
		]);
		
		if ($validator->fails()) {
			return redirect()->back()->with('error',_lang('Please fill up all required fields!'));			
		}

		if (checkSchoolId('bank_cash_accounts',$request->account_id) != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

		if($request->input("invoice_id")){
            foreach($request->input("invoice_id") as $key => $row){
            	if($request->input("id")){
		            foreach($request->input("id") as $key_inner => $row_inner){
		                if($row == $row_inner){
		                	$invoice = Invoice::find($row);
		                	if (!empty($invoice) && $invoice->status=='Unpaid' && !empty($request->input("receipt_date")[$key_inner]) && !empty($request->input("receipt_no")[$key_inner])) {
			                	$studentpayment= new StudentPayment();
							    $studentpayment->school_id = schoolId();
							    $studentpayment->invoice_id = $invoice->id;
								$studentpayment->date = $request->input("receipt_date")[$key_inner];
								$studentpayment->amount = (float)$invoice->total-(float)$invoice->paid;
						        $studentpayment->note = $request->input('note');
						        $studentpayment->save();

						        $transaction= new Transaction();
						        $transaction->school_id = schoolId();
						        $transaction->trans_date = $request->input("receipt_date")[$key_inner];
						        $transaction->receipt_no = $request->input("receipt_no")[$key_inner];
						        $transaction->account_id = $request->input('account_id');
						        $transaction->trans_type = 'income';
						        $transaction->trans_source_type = 'Student';
						        $transaction->amount = (float)$invoice->total-(float)$invoice->paid;
						        $transaction->dr_cr = 'cr';
						        $transaction->payee_payer_id = $invoice->student_id;
						        $transaction->payment_method_id = $request->input('payment_method_id');
						        $transaction->chart_id = $request->input('chart_id');
						        $transaction->create_user_id = Auth::user()->id;
						        $transaction->note = $request->input('note');
						    
						        $transaction->save();

						        $invoice->status = "Paid";
								$invoice->payment_date = now();
								$invoice->receipt_no = $request->input("receipt_no")[$key_inner];
								$invoice->paid = $invoice->total;
						        $invoice->update();
		                	}
		                }
		            }
		        }
            }
        }

        return redirect()->back()->with('success', _lang('Invoice updated sucessfully'));

    }
    public function student_ledger($student_id,$status){
    	$total_blance=0;
    	if ($student_id) {
    		$invoices = Invoice::with(['invoice_item'])
    		->join('students','invoices.student_id','=','students.id')
			->leftJoin('student_sessions','students.id','=','student_sessions.student_id')
			->leftJoin('classes','classes.id','=','student_sessions.class_id')
			->leftJoin('sections','sections.id','=','student_sessions.section_id')
			->select('invoices.*','students.first_name','students.last_name','students.register_no','student_sessions.roll','classes.class_name','sections.section_name','invoices.id as id')
			->where('invoices.student_id',$student_id)
			->where('invoices.school_id',schoolId())
			->where('invoices.session_id',get_option('academic_year'))
			->orderBy("invoices.id","DESC")
			->get();
			$total_blance = $invoices->sum('total')-$invoices->sum('paid');
			if ($status!='All') {
				$invoices = $invoices->where('status',$status);
			}
    	}else{
    		$invoices=[];
    	}
    	$fees = \App\FeeType::where('school_id',schoolId())->orderBy('id', 'DESC')->get();
    	$students = \App\Student::join('student_sessions','students.id','=','student_sessions.student_id')
			                ->leftJoin('sections','sections.id','=','student_sessions.section_id')
                            ->select('students.register_no','students.first_name','students.id as id','sections.section_name')
                            ->where('student_sessions.session_id',get_option('academic_year'))
                            ->where('students.school_id',schoolId())
                            ->where('students.status',1)
                            ->orderBy('students.first_name', 'ASC')
                            ->get();
        
        // dd($invoices);
        return view('backend.invoice.student_ledger',compact('invoices','students','student_id','status','total_blance','fees'));
    }

    public function student_ledger_print(Request $request){
    	$myArray = explode(',', $request->invoice_id);
        $ids = collect($myArray)->toArray();

    	if($request->input("invoice_id")){
			$invoices = \App\Invoice::with(['invoice_item'])
			->join('students','invoices.student_id','=','students.id')
			->leftJoin('student_sessions','students.id','=','student_sessions.student_id')
            ->leftJoin('classes','classes.id','=','student_sessions.class_id')
            ->leftJoin('sections','sections.id','=','student_sessions.section_id')
            ->leftJoin('parents','parents.id','=','students.parent_id')
			->select('invoices.*','students.first_name','students.last_name','parents.parent_name','student_sessions.roll','student_sessions.department_id','classes.class_name','sections.section_name','invoices.id as id')
			->whereIn('invoices.id',$ids)
			->orderBy("invoices.due_date","DESC")
			->get();
	        // dd($invoices);
	        if ($request->input("type")=='fee_bill') {
	        	$data['title']='Fee Bill';
	        	$data['invoices']=$invoices;
				$data['currency']=get_option('currency_symbol');
				// return view('backend.pdf.invoices.fee_bill',$data);
				$pdf = PDF::loadView('backend.pdf.invoices.fee_bill',$data)->setPaper('A4', 'landscape');
				@unlink('pdf/invoices/' . 'fee_bill.pdf');
	            $pdf->save('pdf/invoices/' . 'fee_bill.pdf');
	            return redirect('pdf/invoices/' . 'fee_bill.pdf');
	        }elseif($request->input("type")=='pay_sllip'){
            	$data['title']='Fee Invoice';
	        	$data['invoices']=$invoices;
	        	$data['tital_balance']=\App\Invoice::where('student_id',$invoices[0]->student_id)->sum('total') - \App\Invoice::where('student_id',$invoices[0]->student_id)->sum('paid');
				$data['currency']=get_option('currency_symbol');
				// return view('backend.pdf.invoices.fee_invoice',$data);
				$pdf = PDF::loadView('backend.pdf.invoices.fee_invoice',$data)->setPaper('', 'portrait');
				@unlink('pdf/invoices/' . 'fee_invoice.pdf');
	            $pdf->save('pdf/invoices/' . 'fee_invoice.pdf');
	            return redirect('pdf/invoices/' . 'fee_invoice.pdf');
	        }else{
	        	return redirect()->route('student_ledger',[0,'All'])->with('error', _lang('Invalid Information'));
	        }
			

        }else{
        	return redirect()->route('student_ledger',[0,'All'])->with('error', _lang('Please select invoice'));
        }
        
    }
	
    public function feeBill(Request $request,$id)
    { 
		$invoice = Invoice::join('students','invoices.student_id','=','students.id')
				->leftJoin('student_sessions','students.id','=','student_sessions.student_id')
                ->leftJoin('classes','classes.id','=','student_sessions.class_id')
                ->leftJoin('sections','sections.id','=','student_sessions.section_id')
                ->leftJoin('parents','parents.id','=','students.parent_id')
				->select('invoices.*','students.first_name','students.last_name','parents.parent_name','student_sessions.roll','student_sessions.department_id','classes.class_name','sections.section_name','invoices.id as id')
				->where('student_sessions.session_id',get_option('academic_year'))
				->where('invoices.session_id',get_option('academic_year'))
				->where('invoices.id',$id)->first();
		if (empty($invoice)) {
			return redirect()->back()->with('error','Invalid invoice');
		}
		if ($invoice->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
// 		$data['invoiceItems'] = InvoiceItem::join("account_detail", "invoice_items.fee_id", "=", "account_detail.id")
//     ->select("invoice_items.*", "account_detail.account_name") // Include account_name in the select statement
//     ->where("invoice_id", $id)
//     ->get();
// dd($data);
        $data['invoiceItems'] = InvoiceItem::join("account_detail","invoice_items.fee_id","=","account_detail.id")
		                ->where("invoice_id",$id)->get();
		$data['invoiceItemsSum'] = InvoiceItem::where("invoice_id",$id)->sum('amount') - InvoiceItem::where("invoice_id",$id)->sum('discount');

						
		// dd($data);
		$data['department'] = \App\Department::find($invoice->department_id);

		$data['invoice']=$invoice;
		$data['currency']=get_option('currency_symbol');
		if ($request->type=='pay_sllip') {
			$data['total_balance']=\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid');
			$data['total'] =\App\Invoice::where('student_id',$invoice->student_id)->distinct()->sum('total'); 
			$data['total_previous_balance'] = \App\Invoice::where('student_id', $invoice->student_id)->where('id', '!=', $id)->where('status', 'Unpaid')
			->sum(\DB::raw('total - paid'));
			// dd($data);
$data['receipt_no'] = Transaction::join("account_detail", "transactions.chart_id", "=", "account_detail.id")
    ->where("invoice_id", $id)
    ->select('transactions.receipt_no') // Select only the receipt number column
    ->distinct() // Ensure the results are unique
    ->get();
			return view('backend.pdf.invoices.paysllip',$data); //if you not need to print with PDF plugin
			 
			 /*if you need to print with PDF plugin
			 
			$customPaper = array(0,0,226.712,790.866);
			$pdf = PDF::loadView('backend.pdf.invoices.paysllip',$data)->setPaper($customPaper, 'portrait');;

			@unlink('pdf/invoices/' . 'paysllip.pdf');
	        $pdf->save('pdf/invoices/' . 'paysllip.pdf');
	        return redirect('pdf/invoices/' . 'paysllip.pdf');
	        
	        */
		}elseif ($request->type=='fee_bill') {
			// return view('backend.pdf.invoices.feebill',$data); //if you not need to print with PDF plugin
			
			/*if you need to print with PDF plugin*/
			$pdf = PDF::loadView('backend.pdf.invoices.feebill',$data)->setPaper('A4', 'landscape');

			@unlink('pdf/invoices/' . 'feebill.pdf');
	        $pdf->save('pdf/invoices/' . 'feebill.pdf');
	        return redirect('pdf/invoices/' . 'feebill.pdf');
		}else{
			return redirect()->back();
		}
		
        
    }
}
