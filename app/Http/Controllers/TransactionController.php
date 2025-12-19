<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Validator;
use Carbon\carbon;
use App\Invoice; 
use App\InvoiceItem;
use App\Accounts_detail;
use App\Accounts;
use Illuminate\Validation\Rule;
use Auth;

class TransactionController extends Controller
{
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function income(Request $request)
    {
       

        // $total =  \App\Transaction::whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
        if ($request->has('date_from') && !empty($request->date_from)) {
            // $total =  \App\Transaction::whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
            $previousExpclosing = Transaction::where('trans_date', '<', $request->input("date_from"))
            ->where('dr_cr', '=', 'dr')
            ->where('account_id', '=', '7')
            ->sum('amount');

            $previousIncclosing = Transaction::where('trans_date', '<', $request->input("date_from"))
            ->where('dr_cr', '=', 'cr')
            ->where('account_id', '=', '7')
            ->sum('amount');

            $totalPreviousIncome = $previousIncclosing - $previousExpclosing;
            $opening_balance = $totalPreviousIncome;

        }

                $start = $request->get('start') ?? 0;      // Offset
                $length = $request->get('length') ?? 500;    // Page size
                $search = $request->input('search.value'); // Search keyword (if any)

		 // Calculate opening balance
         // TODO: Cashbook correction 19-07-2025
         if ($request->has('date_from') && !empty($request->date_from) && $request->has('date_to') && !empty($request->date_to)) {
            // Sum debits (dr) for the date range
            $previousExpclosing = Transaction::whereDate('trans_date', '<', $request->date_from)
                ->where('dr_cr', 'dr')
                ->sum('amount');

            // Sum credits (cr) for the date range
            $previousIncclosing = Transaction::whereDate('trans_date', '<', $request->date_from)
                ->where('dr_cr', 'cr')
                ->sum('amount');

            // Calculate opening balance
            $opening_balance = $previousIncclosing - $previousExpclosing;
        } else {
            // Handle case where date_from or date_to is missing
            $opening_balance = 0; // Or set a default value or fetch from another source
        }
    
        if ($request->ajax()) {
            $baseQuery = Transaction::select(
                'transactions.*',
                "chart.account_name as f_type",
                "account.account_name as account_name",
                "account.account_type as account_type", 
                'payee_payers.name as payee_payer',
                'payment_methods.name as payment_method',
                'invoices.id as invoice_id',
                'transactions.id as id',
                'students.id as student_id',
                'students.first_name as first_name',
                'sections.section_name as section_name'
            )
            ->leftJoin("account_detail as chart", "chart.id", "=", "transactions.chart_id") 
            ->leftJoin("account_detail as account", "account.id", "=", "transactions.account_id")  
            ->leftJoin("invoices", "invoices.id", "=", "transactions.invoice_id") 
            ->leftJoin("sections", "sections.id", "=", "invoices.section_id")
            ->leftJoin("students", "students.id", "=", "invoices.student_id") 
            ->leftJoin("payment_methods", "payment_methods.id", "=", "transactions.payment_method_id")
            ->leftJoin("payee_payers", "payee_payers.id", "=", "transactions.payee_payer_id")
            ->where("transactions.trans_type", "income")        
            ->where("transactions.school_id", schoolId());
    
            // Total records before filtering
            $totalData = $baseQuery->count();
    
            // Clone the query to apply filters
            $filteredQuery = clone $baseQuery;
    
            if ($request->date_from) {
                $filteredQuery->whereDate('trans_date', '>=', $request->date_from);
            }
            if ($request->date_to) {
                $filteredQuery->whereDate('trans_date', '<=', $request->date_to);
            }
            if ($search) {
                $filteredQuery->where(function ($q) use ($search) {
                    $q->where('transactions.amount', 'like', "%$search%")
                      ->orWhere('account.account_name', 'like', "%$search%")
                      ->orWhere('students.first_name', 'like', "%$search%");
                });
            }
    
            // Count after filtering
            $filteredData = $filteredQuery->count();
    
            // Paginate
            $transactions = $filteredQuery->orderBy('trans_date', 'asc')
                                          ->orderBy('transactions.id', 'asc')
                                          ->offset($start)
                                          ->limit($length)
                                          ->get();
    
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $filteredData,
                'data' => $transactions,
                'balance' => $opening_balance
            ]);
        
	$invoice = Invoice::find($request->input('invoice_id')); 
	$data['transactions']= $transactions;
    $data['income'] = \App\Transaction::select(
        'transactions.*',
        "account_detail.account_name as f_type",
    )
    ->leftJoin("account_detail as chart", "chart.id", "=", "transactions.account_id")->where('dr_cr', 'cr') ->sum('amount');
	// dd($data);
	$data['invoiceItems'] = InvoiceItem::join("account_detail","invoice_items.fee_id","=","account_detail.id")
	->where("invoice_id",$request->invoice_id)->get();
	
// 	$data['de $todayExpclosing =  Transaction::whereBetween('transactions.trans_date', [

$total = Transaction::where('trans_type', 'income')->sum('amount');
      
	$data['invoice']=$invoice;
$cash_bank = Accounts_detail::where('account_type', '15')->pluck('account_name');
        return response()->json(['data' => $transactions, 
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $filteredData,'balance' => $opening_balance]);
    }
        return view('backend.accounting.transaction.income.list');
    }
	
	
	public function expense(Request $request)
    {
   
        $start = $request->get('start') ?? 0;      // Offset
        $length = $request->get('length') ?? 500;    // Page size
        $search = $request->input('search.value'); // Search keyword (if any)

    // Check if it's an AJAX request with date filters
    if ($request->ajax()) {
        $baseQuery =  Transaction::select(
            'transactions.*',
            'account_detail.account_name as c_type',
            'account_detail.account_type as cash_in_hand',
            "account.account_name as account_name",
            // 'bank_cash_accounts.account_name',
            'payee_payers.name as payee_payer',
            'payment_methods.name as payment_method',
            'account_types.account_type as account_types_name'
        )
        // ->join("bank_cash_accounts", "bank_cash_accounts.id", "=", "transactions.account_id")
        ->join("account_detail", "account_detail.id", "=", "transactions.chart_id")
        ->leftJoin("account_detail as account", "account.id", "=", "transactions.account_id")  // FIXED JOIN
        ->leftJoin("payment_methods", "payment_methods.id", "=", "transactions.payment_method_id")
        ->leftJoin("payee_payers", "payee_payers.id", "=", "transactions.payee_payer_id")
        ->leftJoin("account_types", "account_types.id", "=", "account_detail.account_type") // Ensure correct account type join
        ->where("transactions.trans_type", "expense")
        ->where("transactions.school_id", schoolId());


        // Total records before filtering
        $totalData = $baseQuery->count();

        // Clone the query to apply filters
        $filteredQuery = clone $baseQuery;

        if ($request->date_from) {
            $filteredQuery->whereDate('trans_date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $filteredQuery->whereDate('trans_date', '<=', $request->date_to);
        }
        if ($search) {
            $filteredQuery->where(function ($q) use ($search) {
                $q->where('transactions.amount', 'like', "%$search%")
                  ->orWhere('account.account_name', 'like', "%$search%")
                  ->orWhere('students.first_name', 'like', "%$search%");
            });
        }

        // Count after filtering
        $filteredData = $filteredQuery->count();

        // Paginate
        $transactions = $filteredQuery->orderBy('trans_date', 'asc')
                                      ->orderBy('transactions.id', 'asc')
                                      ->offset($start)
                                      ->limit($length)
                                      ->get();

       
        
    // $totalIncome = $query->where('trans_date', '<', $request->date_from)->where('dr_cr', '=', 'cr')->sum('amount');
    // $totalExpense = $query->where('trans_date', '<', $request->date_from)->where('dr_cr', '=', 'dr')->sum('amount');
    $todayExpclosing =  Transaction::whereBetween('transactions.trans_date', [
        $request->input("date_from"), 
        $request->input("date_to")])->where('dr_cr', '=', 'dr')->where('account_id', '=', '7')->sum('amount');
    $todayIncclosing =   Transaction::whereBetween('transactions.trans_date', [
            $request->input("date_from"), 
            $request->input("date_to")])->where('dr_cr', '=', 'cr')->where('account_id', '=', '7')->sum('amount');
    $totalPreviousIncome = $todayIncclosing - $todayExpclosing ;
    $opening_balance = $totalPreviousIncome;
    // dd($opening_balance);
    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $filteredData,
        'data' => $transactions,
        'balance' => $opening_balance
    ]);
    }

    // Fetch transactions for normal view
    // $transactions = $baseQuery->get();
// dd($total);
    return view('backend.accounting.transaction.expense.list');
    }

	public function cashbook(Request $request)
    {		
        $total_expense = Transaction::where("trans_type", "expense")->sum('amount');
        $total_income = Transaction::where("trans_type", "income")->sum('amount');
        $opening_closing = ($total_expense)-($total_expense);
        
        return view('backend.accounting.transaction.cash_book.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_income(Request $request)
    {
		  $account = Accounts::where('master_account', '!=', '3')->pluck('id')->toArray();
        $cash_and_bank = Accounts_detail::where('account_type', '=' , '15')->get();
        $account_types = Accounts_detail::whereIn('account_type', $account)->get()->toArray();
		// dd($account_types);
		if( ! $request->ajax()){
		   return view('backend.accounting.transaction.income.create', compact('account_types', 'cash_and_bank', 'account'));
		}else{
           return view('backend.accounting.transaction.income.modal.create', compact('account_types', 'cash_and_bank', 'account'));
		}
    }
	
	public function add_expense(Request $request)
    {
        $account = Accounts::where('master_account' , '!=', '4')->pluck('id')->toArray();
        $cash_and_bank = Accounts_detail::where('account_type', '=' , '15')->get();
        $account_types = Accounts_detail::whereIn('account_type', $account)->get()->toArray();

		if( ! $request->ajax()){
		   return view('backend.accounting.transaction.expense.create', compact('account_types', 'cash_and_bank'));
		}else{
           return view('backend.accounting.transaction.expense.modal.create', compact('account_types', 'cash_and_bank'));
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
		
		$validator = Validator::make($request->all(), [
			'trans_date' => 'required',
			'account_id' => 'required',
			'chart_id' => 'required',
			'amount' => 'required|numeric',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('transactions/create')
							->withErrors($validator)
							->withInput();
			}			
		}

		// if (checkSchoolId('bank_cash_accounts',$request->account_id) != schoolId() || checkSchoolId('chart_of_accounts',$request->chart_id) != schoolId()) {
        //     return redirect()->back()->with('error','access denied');
        // }

        // if ($request->payee_payer_id) {
        // 	if (checkSchoolId('payee_payers',$request->payee_payer_id) != schoolId()) {
	       //     return redirect()->back()->with('error','access denied');
	       // }
        // }

        // if ($request->payment_method_id) {
        // 	if (checkSchoolId('payment_methods',$request->payment_method_id) != schoolId()) {
	       //     return redirect()->back()->with('error','access denied');
	       // }
        // }

		
		$attachment = "";
	    if($request->hasfile('attachment'))
		{
		  $file = $request->file('attachment');
		  $attachment = time().$file->getClientOriginalName();
		  $file->move(public_path()."/uploads/transactions/", $attachment);
		}
		  $currentMonth = now()->format('Y-m');
            
          
        $transaction= new Transaction();
	    $transaction->school_id = schoolId();
	    $transaction->trans_date = $request->input('trans_date');
		$transaction->account_id = $request->input('account_id');
		$transaction->trans_type = $request->input('trans_type');
		$transaction->amount = $request->input('amount');
		$transaction->dr_cr = $request->input('dr_cr');
		$transaction->chart_id = $request->input('chart_id');
		$transaction->payee_payer_id = $request->input('payee_payer_id');
		$transaction->payment_method_id = $request->input('payment_method_id');
		$transaction->create_user_id = Auth::user()->id;
		$transaction->reference = $request->input('reference');
		$transaction->attachment = $attachment;
		$transaction->note = $request->input('note');
// dd($transaction);
        $transaction->save();
                  
                
            // }
       

		if(! $request->ajax()){
           return redirect($_SERVER['HTTP_REFERER'])->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$transaction]);
		}
        
   }
   public function store_income(Request $request)
   {
       
       $validator = Validator::make($request->all(), [
           'trans_date' => 'required',
           'account_id' => 'required',
           'chart_id' => 'required',
           'amount' => 'required|numeric',
       ]);
       
       if ($validator->fails()) {
           if($request->ajax()){ 
               return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
           }else{
               return redirect('transactions/create')
                           ->withErrors($validator)
                           ->withInput();
           }			
       }
       
       $attachment = "";
       if($request->hasfile('attachment'))
       {
         $file = $request->file('attachment');
         $attachment = time().$file->getClientOriginalName();
         $file->move(public_path()."/uploads/transactions/", $attachment);
       }
         $currentMonth = now()->format('Y-m');
           
           // Fetch total expenses for the current month
           $totalExpenses = Transaction::where('trans_type', 'expense')
               ->where('trans_date', 'like', $currentMonth . '%')
               ->sum('amount');
           $totalIncome = Transaction::where('trans_type', 'income')
               ->where('trans_date', 'like', $currentMonth . '%')
               ->sum('amount');
           
       $transaction= new Transaction();
       $transaction->school_id = schoolId();
       $transaction->trans_date = $request->input('trans_date');
       $transaction->account_id = $request->input('account_id');
       $transaction->trans_type = $request->input('trans_type');
       $transaction->amount = $request->input('amount');
       $transaction->dr_cr = $request->input('dr_cr');
       $transaction->chart_id = $request->input('chart_id');
       $transaction->payee_payer_id = $request->input('payee_payer_id');
       $transaction->payment_method_id = $request->input('payment_method_id');
       $transaction->create_user_id = Auth::user()->id;
       $transaction->reference = $request->input('reference');
       $transaction->attachment = $attachment;
       $transaction->note = $request->input('note');

       $transaction->save();
                 
               
      
  
     
       if(! $request->ajax()){
          return redirect($_SERVER['HTTP_REFERER'])->with('success', _lang('Information has been added sucessfully'));
       }else{
          return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$transaction]);
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
        $transaction = Transaction::select(
            'transactions.*',
            'account_detail.account_name as c_type',
            "account.account_name as account_name",
        )
        // ->join("bank_cash_accounts", "bank_cash_accounts.id", "=", "transactions.account_id")
        ->join("account_detail", "account_detail.id", "=", "transactions.chart_id")
        ->leftJoin("account_detail as account", "account.id", "=", "transactions.account_id")  // FIXED JOIN
		                ->where("transactions.id",$id)->first();

		// if ($transaction->school_id != schoolId()) {
        //     return redirect()->back()->with('error','access denied');
        // }

		if(! $request->ajax()){
		    return view('backend.accounting.transaction.income.view',compact('transaction','id'));
		}else{
			return view('backend.accounting.transaction.income.modal.view',compact('transaction','id'));
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
         $transaction = Transaction::find($id);
         $account = Accounts::where('master_account', '4')->pluck('id')->toArray();
                $cash_and_bank = Accounts_detail::where('account_type', '=' , '15')->get();
        $account_types = Accounts_detail::whereIn('account_type', $account)->get()->toArray();
	
		if(! $request->ajax()){
		   return view('backend.accounting.transaction.income.edit',compact('transaction','id', 'account', 'cash_and_bank', 'account_types'));
		}else{
           return view('backend.accounting.transaction.income.modal.edit',compact('transaction','id','account', 'cash_and_bank', 'account_types'));
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
			'trans_date' => 'required',
			'account_id' => 'required',
			'chart_id' => 'required',
			'amount' => 'required|numeric',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('transactions.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}

		

		

        // if ($request->payee_payer_id) {
        // 	if (checkSchoolId('payee_payers',$request->payee_payer_id) != schoolId()) {
	       //     return redirect()->back()->with('error','access denied');
	       // }
        // }

        // if ($request->payment_method_id) {
        // 	if (checkSchoolId('payment_methods',$request->payment_method_id) != schoolId()) {
	       //     return redirect()->back()->with('error','access denied');
	       // }
        // }

	
	    $attachment = "";
        if($request->hasfile('attachment'))
		{
		  $file = $request->file('attachment');
		  $attachment = time().$file->getClientOriginalName();
		  $file->move(public_path()."/uploads/transactions/", $attachment);
		}	
		
        $transaction = Transaction::find($id);

		// if ($transaction->school_id != schoolId()) {
        //     return redirect()->back()->with('error','access denied');
        // }
 $currentMonth = now()->format('Y-m');
            
            // Fetch total expenses for the current month
            $totalExpenses = Transaction::where('trans_type', 'expense')
                ->where('trans_date', 'like', $currentMonth . '%')
                ->sum('amount');
            $totalIncome = Transaction::where('trans_type', 'income')
                ->where('trans_date', 'like', $currentMonth . '%')
                ->sum('amount');
                // dd($totalExpenses, $totalIncome);
            // Check if the total expense exceeds the balance
            if (($totalExpenses) > $totalIncome) {
                return redirect()->back()->with('error', _lang('You do not have enough balance to add this expense.'));
            }else{
		$transaction->trans_date = $request->input('trans_date');
		$transaction->account_id = $request->input('account_id');
		$transaction->trans_type = $request->input('trans_type');
		$transaction->amount = $request->input('amount');
		$transaction->dr_cr = $request->input('dr_cr');
		$transaction->chart_id = $request->input('chart_id');
		$transaction->payee_payer_id = $request->input('payee_payer_id');
		$transaction->payment_method_id = $request->input('payment_method_id');
		$transaction->update_user_id = Auth::user()->id;
		$transaction->reference = $request->input('reference');
		if($request->hasfile('attachment')){
			$transaction->attachment = $attachment;
		}
		$transaction->note = $request->input('note');
        $transaction->save();
            }
		if(! $request->ajax()){
		   if($request->input('trans_type') == "income"){	
			   return redirect('transactions/income')->with('success', _lang('Information has been updated sucessfully'));
           }else{
			   return redirect('transactions/income')->with('success', _lang('Information has been updated sucessfully')); 
		   }
		}else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$transaction]);
		}
	    
    }
public function update_expense(Request $request, $id)
    {
	
		$validator = Validator::make($request->all(), [
			'trans_date' => 'required',
			'account_id' => 'required',
			'chart_id' => 'required',
			'amount' => 'required|numeric',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('transactions.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}

		

// 		if (checkSchoolId('bank_cash_accounts',$request->account_id) != schoolId() || checkSchoolId('chart_of_accounts',$request->chart_id) != schoolId()) {
//             return redirect()->back()->with('error','access denied');
//         }

//         // if ($request->payee_payer_id) {
        // 	if (checkSchoolId('payee_payers',$request->payee_payer_id) != schoolId()) {
	       //     return redirect()->back()->with('error','access denied');
	       // }
        // }

        // if ($request->payment_method_id) {
        // 	if (checkSchoolId('payment_methods',$request->payment_method_id) != schoolId()) {
	       //     return redirect()->back()->with('error','access denied');
	       // }
        // }

	
	    $attachment = "";
        if($request->hasfile('attachment'))
		{
		  $file = $request->file('attachment');
		  $attachment = time().$file->getClientOriginalName();
		  $file->move(public_path()."/uploads/transactions/", $attachment);
		}	
		
        $transaction = Transaction::find($id);

 $currentMonth = now()->format('Y-m');
            
            // Fetch total expenses for the current month
            $totalExpenses = Transaction::where('dr_cr', 'dr')
                ->sum('amount');
            $totalIncome = Transaction::where('dr_cr', 'cr')
                ->sum('amount');
                // dd($totalExpenses, $totalIncome);
                // dd($totalExpenses, $totalIncome);
            // Check if the total expense exceeds the balance
            if (($totalExpenses) > $totalIncome) {
                return redirect()->back()->with('error', _lang('You do not have enough balance to add this expense.'));
            }else{
		$transaction->trans_date = $request->input('trans_date');
		$transaction->account_id = $request->input('account_id');
		$transaction->trans_type = $request->input('trans_type');
		$transaction->amount = $request->input('amount');
		$transaction->dr_cr = $request->input('dr_cr');
		$transaction->chart_id = $request->input('chart_id');
		$transaction->payee_payer_id = $request->input('payee_payer_id');
		$transaction->payment_method_id = $request->input('payment_method_id');
		$transaction->update_user_id = Auth::user()->id;
		$transaction->reference = $request->input('reference');
		if($request->hasfile('attachment')){
			$transaction->attachment = $attachment;
		}
		$transaction->note = $request->input('note');
        // dd($transaction);
        $transaction->save();
            }
		if(! $request->ajax()){
		   if($request->input('trans_type') == "expense"){	
			   return redirect('transactions/expense')->with('success', _lang('Information has been updated sucessfully'));
           }else{
			   return redirect('transactions/expense')->with('success', _lang('Information has not updated')); 
		   }
		}else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$transaction]);
		}
	    
    }

    public function expense_edit(Request $request,$id)
    {
                $transaction = Transaction::find($id);
         $account = Accounts::pluck('id')->toArray();
                $cash_and_bank = Accounts_detail::get();
        $account_types = Accounts_detail::whereIn('account_type', $account)->get()->toArray();
	
		if(! $request->ajax()){
		   return view('backend.accounting.transaction.expense.edit',compact('transaction','id', 'account', 'cash_and_bank', 'account_types'));
		}else{
           return view('backend.accounting.transaction.expense.modal.edit',compact('transaction','id','account', 'cash_and_bank', 'account_types'));
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
        $transaction = Transaction::find($id);

		if ($transaction->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        $transaction->delete();
        return redirect()->back()->with('success',_lang('Information has been deleted sucessfully'));
    }

    public function ledges(Request $request){
        

		if($request->ajax() ){
        
            $accountId = $request->input('account_id');
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');
            


        if (Transaction::where("chart_id", $accountId)->exists()) {
           $selectFields = [
            'transactions.*',
            'chart.account_name as f_type',
            'account.account_name as account_name',
            'account.account_type as account_type',
            'invoices.id as invoice_id',
            'transactions.id as id',
            'transactions.dr_cr as dr_cr',
            'students.id as student_id',
                ];
                $account = Accounts_detail::where("id", $accountId)->first();

                    if ($account && $account->account_type == 3) {
                        $selectFields[] = 'students.first_name as first_name';
                        $selectFields[] = 'sections.section_name as section_name';
                    } else {
                        $selectFields[] = 'chart.account_name as first_name';
                        $selectFields[] = 'transactions.note as section_name';
                    }


            // Then pass it
            $transactions = Transaction::select($selectFields)
                ->leftJoin('account_detail as chart', 'chart.id', '=', 'transactions.chart_id')
                ->leftJoin('account_detail as account', 'account.id', '=', 'transactions.account_id')
                ->leftJoin('invoices', 'invoices.id', '=', 'transactions.invoice_id')
                ->leftJoin('sections', 'sections.id', '=', 'invoices.section_id')
                ->leftJoin('students', 'students.id', '=', 'invoices.student_id')
                ->where('transactions.chart_id', $accountId) // or account_id, depending on your flow
                ->whereBetween('transactions.trans_date', [$dateFrom, $dateTo])
                ->where('transactions.school_id', schoolId())
                ->orderBy('trans_date', 'asc')
                ->orderBy('id', 'asc')
                ->get();
                        $previousIncclosing = Transaction::where('trans_date', '<', $dateFrom)
                        ->where('chart_id', '=',  $accountId)->where('dr_cr', 'cr')
                        ->sum('amount');
                        $previousexpcclosing = Transaction::where('trans_date', '<', $dateFrom)
                        ->where('chart_id', '=',  $accountId)->where('dr_cr', 'dr')
                        ->sum('amount');
            
                        $opening_balance = $previousIncclosing - $previousexpcclosing;
           

            return response()->json(['data' => $transactions , 'balance' => $opening_balance]);
        }if (Transaction::where("account_id", $accountId)->exists()) {
            $selectFields = [
                'transactions.*',
                'chart.account_name as f_type',
                'account.account_name as account_name',
                'account.account_type as account_type',
                'invoices.id as invoice_id',
                'transactions.id as id',
                'transactions.dr_cr as dr_cr',
                'students.id as student_id',
            ];
        
            $account = Accounts_detail::where("id", $accountId)->first();
        
            if ($account && $account->account_type != 3) {
                $selectFields[] = 'chart.account_name as first_name';
                $selectFields[] = \DB::raw("COALESCE(transactions.note, '') as section_name");

            } else {
                $selectFields[] = 'students.first_name as first_name';
                $selectFields[] = 'sections.section_name as section_name';
            }
        
            $transactions = Transaction::select($selectFields)
                ->leftJoin('account_detail as chart', 'chart.id', '=', 'transactions.chart_id')
                ->leftJoin('account_detail as account', 'account.id', '=', 'transactions.account_id')
                ->leftJoin('invoices', 'invoices.id', '=', 'transactions.invoice_id')
                ->leftJoin('sections', 'sections.id', '=', 'invoices.section_id')
                ->leftJoin('students', 'students.id', '=', 'invoices.student_id')
                ->where('transactions.account_id', $accountId) // <-- FIXED HERE
                ->whereBetween('transactions.trans_date', [$dateFrom, $dateTo])
                ->where('transactions.school_id', schoolId())
                ->orderBy('trans_date', 'asc')
                ->orderBy('id', 'asc')
                ->get();
        
                $previousIncclosing = Transaction::where('trans_date', '<', $dateFrom)
                ->where('account_id', '=',  $accountId)->where('dr_cr', 'cr')
                ->sum('amount');
                $previousexpcclosing = Transaction::where('trans_date', '<', $dateFrom)
                ->where('account_id', '=',  $accountId)->where('dr_cr', 'dr')
                ->sum('amount');
            
                $opening_balance = $previousIncclosing - $previousexpcclosing;
        
            return response()->json(['data' => $transactions, 'balance' => $opening_balance]);
        }
        else{

        }

        
        }
          
        $accounts = Accounts_detail::get()->toArray();
        return view('backend.accounting.transaction.ledges.list', compact('accounts'));
    }

  
}
