<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Accounts;
use App\Accounts_detail;
use App\MasterAccount;
use Validator;
use Illuminate\Validation\Rule;
use Auth;

class AccountController extends Controller
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
    public function index()
    {
        $accounts=Account::where('school_id',schoolId())->orderBy("id",'desc')->get();
        return view('backend.accounting.bank_cash_account.list',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.accounting.bank_cash_account.create');
		}else{
           return view('backend.accounting.bank_cash_account.modal.create');
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
			'account_name' => 'required|max:50',
			'opening_balance' => 'required|numeric',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('accounts/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		

        $account= new Account();
	    $account->account_name = $request->input('account_name');
		$account->opening_balance = $request->input('opening_balance');
		$account->note = $request->input('note');
		$account->school_id = schoolId();
        $account->create_user_id = Auth::user()->id;
	
        $account->save();
        
		if(! $request->ajax()){
           return redirect('accounts/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$account]);
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
        $account = Account::find($id);
        if ($account->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
		if(! $request->ajax()){
		    return view('backend.accounting.bank_cash_account.view',compact('account','id'));
		}else{
			return view('backend.accounting.bank_cash_account.modal.view',compact('account','id'));
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
        $account = Account::find($id);
        if ($account->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
		if(! $request->ajax()){
		   return view('backend.accounting.bank_cash_account.edit',compact('account','id'));
		}else{
           return view('backend.accounting.bank_cash_account.modal.edit',compact('account','id'));
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
			'account_name' => 'required|max:50',
			'opening_balance' => 'required|numeric',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('accounts.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $account = Account::find($id);
        if ($account->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
		$account->account_name = $request->input('account_name');
		$account->opening_balance = $request->input('opening_balance');
		$account->note = $request->input('note');
		$account->update_user_id = Auth::user()->id;
	
        $account->save();
		
		if(! $request->ajax()){
           return redirect('accounts')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$account]);
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
        $account = Account::find($id);
        if ($account->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $account->delete();
        return redirect('accounts')->with('success',_lang('Information has been deleted sucessfully'));
    }



//Accounts new functionality Fatima

    public function create_account_type(){
        $master_account = MasterAccount::get();
        $account_types = Accounts::with('masterAccount')->get();
        return view('backend.accounting.accounts_details.accounts_types' , compact('account_types', 'master_account'));
    }
    public function save_account_type(Request $request){
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_level' => 'required|string',
        ]);
    //    dd($request);
        $accounts = New Accounts;
        $accounts->account_type = $request->account_name;
        $accounts->master_account = $request->account_level;
        // dd($accounts);
        $accounts->save();
        return redirect()->back()->with('success', _lang('Information has been added sucessfully'));

    }
    public function edit_account_type(Request $request, $id){
        
        $accounts = Accounts::find($id);
        // dd($accounts);
        
        $master_account = MasterAccount::get();
        return view('backend.accounting.accounts_details.account_types_edit', compact('accounts', 'master_account'));
    }
    public function update_account_type(Request $request, $id){
        
        $account_types = Accounts::find($id);
        $account_types->account_type = $request->account_name;
        $account_types->master_account = $request->account_level;
        $account_types->save();
        // dd($account_types, $account_level, $account_types);

        return redirect()->back()->with('success', _lang('record updated successfuly '));
    }
    public function delete_account_type(Request $request, $id){
        // dd($id);
        
        $account_types = Accounts::find($id);
        $account_types->delete();
        return redirect()->back()->with('success', _lang('record deleted successfuly '));
    } 
   
    public function create_account(){
        $account_level = Accounts::get()->toArray();
        
        $account_details = Accounts_detail::with('account')->get();

        return view('backend.accounting.accounts_details.account_details', compact('account_level', 'account_details'));
    }
    public function save_account(Request $request){
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string',
        ]);
        //    dd($request);
        $accounts = New Accounts_detail;
        $accounts->account_type = $request->account_type;
        $accounts->account_name = $request->account_name;
        $accounts->account_number = $request->account_nunber;

        // dd($accounts);
        $accounts->save();
        return redirect()->back()->with('success', _lang('Information has been added sucessfully'));

    }
    public function edit_account_detail(Request $request, $id){
        
        $accounts = Accounts_detail::find($id);
        $master_account_level = Accounts::distinct()->pluck('account_type');
        // dd($accounts);
        return view('backend.accounting.accounts_details.account_details_edit', compact('accounts', 'master_account_level'));
    }

    public function update_account_detail(Request $request, $id){
        
        $account_types = Accounts_detail::find($id);
        $account_types->account_name = $request->account_name;
        $account_types->account_number = $request->account_number;
        $account_types->account_type = $request->account_type;
        $account_types->save();
        // dd($account_types, $account_level, $account_types);

        
        return redirect()->back()->with('success', _lang('Information has been updated sucessfully'));
    }
    public function delete_account_detail(Request $request, $id){
        // dd($id);
        
        $account_types = Accounts_detail::find($id);
        $account_types->delete();
        return redirect()->back()->with('success', _lang('record deleted successfuly '));
    }

    public function create_master_account(){
        $master_account = MasterAccount::get();
        return view('backend.accounting.accounts_details.master_accounts', compact('master_account'));
    }
    public function save_master_account(Request $request){
        
        $master_account = new MasterAccount;
        $master_account->master_account = $request->master_account;
        $master_account->save();
        return redirect()->back()->with('success', _lang('record added successfuly '));
    }
    public function edit_master_account($id){
        
        $edit_master_account = MasterAccount::find($id);

        // if($edit_master_account){
            return view('backend.accounting.accounts_details.edit_master_accounts', compact('edit_master_account'));
        // }else{
        //     $master_account = MasterAccount::get();
        //     return view('backend.accounting.accounts_details.master_accounts', compact('master_account'));
        // }
        
    }
    public function update_master_account(Request $request, $id){
        
        $master_account = MasterAccount::find($id);
        $master_account->master_account = $request->master_account;
        // dd($master_account);
        $master_account->save();
        return redirect()->back()->with('success', _lang('record updated successfuly '));
    }
    public function delete_master_account($id){
        
        $master_account = MasterAccount::find($id);
        // dd($master_account);
        $master_account->delete();
        return redirect()->back()->with('success', _lang('record deleted successfuly '));
    }
}
