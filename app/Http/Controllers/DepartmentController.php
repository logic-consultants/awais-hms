<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use Validator;
use Illuminate\Validation\Rule;
use Image;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments=Department::where('school_id',schoolId())->orderBy("id",'desc')->get();
        return view('backend.administration.department.list',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.administration.department.create');
		}else{
           return view('backend.administration.department.modal.create');
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
			'department_name' => 'required',
            'bank_name' => 'required',
            'bank_account' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('departments/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
		
	    
		$ImageNameBank='';
        if ($request->hasFile('bank_logo')){
            $image = $request->file('bank_logo');
            $ImageNameBank = rand().'_'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $ImageNameBank);
        }
        $ImageNameSchool='';
        if ($request->hasFile('school_logo')){
             $image = $request->file('school_logo');
            $ImageNameSchool = rand().'_'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $ImageNameSchool);
        }

        $department= new Department();
	    $department->school_id = schoolId();
        $department->department_name = $request->input('department_name');
        $department->bank_name = $request->input('bank_name');
        $department->bank_account = $request->input('bank_account');
        $department->bank_logo = $ImageNameBank;
        $department->school_logo = $ImageNameSchool;
	
        $department->save();
        
		if(! $request->ajax()){
           return redirect('departments/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$department]);
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
        $department = Department::find($id);
		if(! $request->ajax()){
		    return view('backend.administration.department.view',compact('department','id'));
		}else{
			return view('backend.administration.department.modal.view',compact('department','id'));
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
        $department = Department::find($id);
        
        if ($department->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
		if(! $request->ajax()){
		   return view('backend.administration.department.edit',compact('department','id'));
		}else{
           return view('backend.administration.department.modal.edit',compact('department','id'));
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
			'department_name' => 'required',
            'bank_name' => 'required',
            'bank_account' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('departments.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $department = Department::find($id);
        
        if ($department->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        if ($request->hasFile('bank_logo')){
             $image = $request->file('bank_logo');
            $ImageNameBank = rand().'_'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $ImageNameBank);
             $department->bank_logo = $ImageNameBank;
        }
        if ($request->hasFile('school_logo')){
             $image = $request->file('school_logo');
            $ImageNameSchool = rand().'_'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $ImageNameSchool);
            $department->school_logo = $ImageNameSchool;
        }

        $department->department_name = $request->input('department_name');
        $department->bank_name = $request->input('bank_name');
        $department->bank_account = $request->input('bank_account');
        
	
        $department->update();
		
		if(! $request->ajax()){
           return redirect('departments')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$department]);
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
        $department = Department::find($id);
        
        if ($department->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $department->delete();
        return redirect('departments')->with('success',_lang('Information has been  deleted sucessfully'));
    }
}
