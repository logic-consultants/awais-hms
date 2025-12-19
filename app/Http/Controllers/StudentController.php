<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\UniqueRoll;
use App\Student;
use App\StudentSession;
use App\User;
use App\ClassModel;
use App\Section;
use App\Subject;
use App\InvoiceItem;
use App\StudentFeeAssign;
use App\ParentModel;
use DB;
// use PDF;
use Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Hash;
use Image;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $class = $request->input("class_id")??"all";		
        $studentStatus = $request->input("status_id")??"all";
        if($request->ajax())
        {
            if($class == "all" && $studentStatus == "all")
            {
                $class = "";
                $students = Student::join('users','users.id','=','students.user_id')
                ->join('student_sessions','students.id','=','student_sessions.student_id')
                ->leftJoin('classes','classes.id','=','student_sessions.class_id')
                ->leftJoin('sections','sections.id','=','student_sessions.section_id')
                ->select('users.*','students.activities','students.address','students.father_name','sections.section_name','students.status','students.id as id')  					
                ->where('student_sessions.session_id',get_option('academic_year'))
                ->where('students.school_id',schoolId())
                ->where('users.user_type','Student')
                ->orderBy('users.id', 'DESC')
                ->get();
            }
            else if($class != "all" && $studentStatus != "all" )
            {
                    $students = Student::join('users','users.id','=','students.user_id')
                            ->join('student_sessions','students.id','=','student_sessions.student_id')
                            ->join('classes','classes.id','=','student_sessions.class_id')
                            ->join('sections','sections.id','=','student_sessions.section_id')
                            ->select('users.*','students.activities','students.address','students.father_name','sections.section_name','students.status','students.id as id')  					
                            ->where('student_sessions.session_id',get_option('academic_year'))
                            ->where('student_sessions.class_id',$class)
                            ->where('students.school_id',schoolId())
                            ->where('users.user_type','Student')
                            ->where('students.status',$studentStatus)
                            ->orderBy('users.id', 'DESC')
                            ->get();
            }
            else if($class != "all" && $studentStatus == "all")
            {
                    $students = Student::join('users','users.id','=','students.user_id')
                        ->join('student_sessions','students.id','=','student_sessions.student_id')
                        ->join('classes','classes.id','=','student_sessions.class_id')
                        ->join('sections','sections.id','=','student_sessions.section_id')
                        ->select('users.*','students.activities','students.address','students.father_name','sections.section_name','students.status','students.id as id')  					
                        ->where('student_sessions.session_id',get_option('academic_year'))
                        ->where('student_sessions.class_id',$class)
                        ->where('students.school_id',schoolId())
                        ->where('users.user_type','Student')
                        ->orderBy('users.id', 'DESC')
                        ->get();
            }
            else if($class == "all" && $studentStatus != "all")
            {
                    $students = Student::join('users','users.id','=','students.user_id')
                        ->join('student_sessions','students.id','=','student_sessions.student_id')
                        ->join('classes','classes.id','=','student_sessions.class_id')
                        ->join('sections','sections.id','=','student_sessions.section_id')
                        ->select('users.*','students.activities','students.address','students.father_name','sections.section_name','students.status','students.id as id')  					
                        ->where('student_sessions.session_id',get_option('academic_year'))
                        ->where('students.school_id',schoolId())
                        ->where('users.user_type','Student')
                        ->where('students.status',$studentStatus)
                        ->orderBy('users.id', 'DESC')
                        ->get();
            }
                return json_encode(['data' => $students]);
        }
        else
            return view('backend.students.student-list');
    }

	public function class($class="")
    {
		$class = $class;
		
		 $studentStatus="all";
        if(str_contains($class, "-"))
        {
            $list=explode("-",$class);
            $class=$list[0];
            if($class=="all")$class="";
            $studentStatus=$list[1];
        }
        
        if($class!="")
        {
            if($studentStatus!="all")
            {
                   $students = Student::join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
                        ->join('classes','classes.id','=','student_sessions.class_id')
                        ->join('sections','sections.id','=','student_sessions.section_id')
						->select('users.*','students.register_no','classes.class_name','sections.section_name','students.id as id')						
						->where('student_sessions.session_id',get_option('academic_year'))
                        ->where('student_sessions.class_id',$class)
                        ->where('students.school_id',schoolId())
                        ->where('users.user_type','Student')
                        ->where('students.status',$studentStatus)
                        ->orderBy('users.id', 'DESC')
                        ->get();
            }
            else
            {
                  $students = Student::join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
                        ->join('classes','classes.id','=','student_sessions.class_id')
                        ->join('sections','sections.id','=','student_sessions.section_id')
						->select('users.*','students.register_no','classes.class_name','sections.section_name','students.id as id')						
						->where('student_sessions.session_id',get_option('academic_year'))
                        ->where('student_sessions.class_id',$class)
                        ->where('students.school_id',schoolId())
                        ->where('users.user_type','Student')
                        ->orderBy('users.id', 'DESC')
                        ->get();
            }
	
        }
        else
        {
          if($studentStatus!="all")
            {
                   $students = Student::join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
                        ->join('classes','classes.id','=','student_sessions.class_id')
                        ->join('sections','sections.id','=','student_sessions.section_id')
						->select('users.*','students.register_no','classes.class_name','sections.section_name','students.id as id')						
						->where('student_sessions.session_id',get_option('academic_year'))
                        ->where('students.school_id',schoolId())
                        ->where('users.user_type','Student')
                        ->where('students.status',$studentStatus)
                        ->orderBy('users.id', 'DESC')
                        ->get();
            }
            else
            {
                  $students = Student::join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
                        ->join('classes','classes.id','=','student_sessions.class_id')
                        ->join('sections','sections.id','=','student_sessions.section_id')
						->select('users.*','students.register_no','classes.class_name','sections.section_name','students.id as id')						
						->where('student_sessions.session_id',get_option('academic_year'))
                        ->where('students.school_id',schoolId())
                        ->where('users.user_type','Student')
                        ->orderBy('users.id', 'DESC')
                        ->get();
            }
        
        }
						
        return view('backend.students.student-list',compact('students','class'));
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::where('school_id',schoolId())->orderBy('id', 'DESC')->get();
        return view('backend.students.student-add',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|string|max:191',
            'father_name' => 'required|string|max:191',
            'guardian' => 'required',
            'birthday' => 'required',
            'gender' => 'required|string|max:10',
            'blood_group' => 'nullable|string|max:4',
            'religion' => 'nullable|string|max:20',
            'phone' => 'string|max:20',
            'state' => 'required|string|max:191',
            'country' => 'nullable|string|max:100',
            'class' => 'required',
            'section' => 'required',
            'department' => 'required',
            'group' => 'nullable|string|max:191',
            'register_no' => 'required||unique:students',
            'activities' => 'nullable|string|max:191',
            'remarks' => 'nullable',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);

        if ($request->need_login) {
            $this->validate($request, [
                'email' => 'required|string|email|max:191|unique:users',
                'password' => 'required|string|min:6|confirmed'
            ]);
        }


        if (checkSchoolId('classes',$request->class) != schoolId() || checkSchoolId('sections',$request->section) != schoolId() || checkSchoolId('parents',$request->guardian) != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }


        if ($request->optional_subject) {
        	if (checkSchoolId('subjects',$request->optional_subject) != schoolId()) {
	            return redirect()->back()->with('error','access denied');
	        }
        }
        if ($request->group) {
        	if (checkSchoolId('student_groups',$request->group) != schoolId()) {
	            return redirect()->back()->with('error','access denied');
	        }
        }

        $section_capacity = Section::find($request->section);
        if (($section_capacity->capacity-section_wise_occupied($request->section))<1) {
            return redirect()->back()->with('error','Not available seats for this section!.');
        }

        $ImageName='profile.png';
        if ($request->hasFile('image')){
             $image = $request->file('image');
             $ImageName = time().'.'.$image->getClientOriginalExtension();
             Image::make($image)->resize(200, 160)->save(base_path('public/uploads/images/students/') . $ImageName);
        }
        
        if ($request->need_login) {
            //Create User
            $user = new User();
            $user->school_id = schoolId();
            $user->name = $request->first_name." ".$request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 'Student';
            $user->phone = $request->phone;
            $user->image = 'students/'.$ImageName;
            $user->save();
        }else{
            //Create User
            $user = new User();
            $user->school_id = schoolId();
            $user->name = $request->first_name." ".$request->last_name;
            $user->email = $request->register_no.'@logic.com';
            $user->password = Hash::make('zubair');
            $user->user_type = 'Student';
            $user->phone = $request->phone;
            $user->image = 'students/'.$ImageName;
            $user->save();
        }
			

			//Create Student Information
			$student = new Student();
			$student->school_id = $user->school_id;
			$student->user_id = $user->id;
			$student->parent_id = $request->guardian;
			$student->first_name = $request->first_name;
			$student->father_name = $request->father_name;
			$student->birthday = $request->birthday;
			$student->gender = $request->gender;
			$student->blood_group = $request->blood_group;
			$student->religion = $request->religion;
			$student->phone = $request->phone;
            $student->home_phone = $request->home_phone;
			$student->address = $request->address;
			$student->state = $request->state;
			$student->country = $request->country;
			$student->register_no = $request->register_no;
			$student->group = $request->group;
			$student->activities = $request->activities;
			$student->remarks = $request->remarks;
			$student->save();
			
			//Create Student Session Information
			$studentSession = new StudentSession();
			$studentSession->session_id = get_option('academic_year');
			$studentSession->school_id = $user->school_id;
			$studentSession->student_id = $student->id;
			$studentSession->class_id = $request->class;
			$studentSession->section_id = $request->section;
            $studentSession->department_id = $request->department;
			$studentSession->roll = $request->roll??$student->register_no;
			$studentSession->optional_subject = $request->optional_subject;
			$studentSession->save();

            if($request->input("fee_type")){
                foreach($request->input("fee_type") as $key => $fee_id){
                    if($request->input("amount")[$key] > 0 && $fee_id!=""){
                        $invoiceItem =  new \App\StudentFeeAssign;
                        $invoiceItem->school_id = $user->school_id;
                        $invoiceItem->student_id = $student->id;
                        $invoiceItem->fee_id = $fee_id;
                        $invoiceItem->amount = $request->input("amount")[$key];
                        $invoiceItem->discount = $request->input("discount")[$key];
                        $invoiceItem->save();
                    }
                }
            }

        return redirect('students/create')->with('success', _lang('Information has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {							
		$student = Student::join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->join('sections','sections.id','=','student_sessions.section_id')
                     ->join('parents','parents.id','=','students.parent_id')
					 ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',$id)->first();
        if ($student->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        return view('backend.students.student-view',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data=[
            'classes' => ClassModel::orderBy('id', 'DESC')->where('school_id',schoolId())->get(),
            'sections' => Section::orderBy('id', 'DESC')->where('school_id',schoolId())->get(),
            'assign_fees' => \App\StudentFeeAssign::where('student_id',$id)->orderBy('id','ASC')->get(),
            'student' => Student::join('users','users.id','=','students.user_id')
                                ->join('student_sessions','students.id','=','student_sessions.student_id')
                                ->select('*','students.id as id','student_sessions.id as ss_id')
								->where('student_sessions.session_id',get_option('academic_year'))
                                ->where('students.id',$id)->first(),
        ];
        if ($data['student']->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        return view('backend.students.student-edit',$data);
    }

    public function print_student($id)
    {

        $data=[
            'assign_fees' => \App\StudentFeeAssign::where('student_id',$id)->orderBy('id','ASC')->get(),
            'student' => Student::join('users','users.id','=','students.user_id')
                                ->join('student_sessions','students.id','=','student_sessions.student_id')
                                ->select('*','students.id as id','student_sessions.id as ss_id')
								->where('student_sessions.session_id',get_option('academic_year'))
                                ->where('students.id',$id)->first(),
        ];
        if ($data['student']->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        
		$student = Student::join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->join('sections','sections.id','=','student_sessions.section_id')
                     ->join('parents','parents.id','=','students.parent_id')
					 ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',$id)->first();
        if ($student->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        
        return view('backend.students.student-print', [
            'data' => $data,
            'student' => $student,
        ]);
    }
    // get pdf from student detail

    public function pdf_details_student($id){

        $data=[
            'assign_fees' => \App\StudentFeeAssign::where('student_id',$id)->orderBy('id','ASC')->get(),
            'student' => Student::join('users','users.id','=','students.user_id')
                                ->join('student_sessions','students.id','=','student_sessions.student_id')
                                ->select('*','students.id as id','student_sessions.id as ss_id')
								->where('student_sessions.session_id',get_option('academic_year'))
                                ->where('students.id',$id)->first(),
        ];
        if ($data['student']->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        
		$student = Student::join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->join('sections','sections.id','=','student_sessions.section_id')
                     ->join('parents','parents.id','=','students.parent_id')
					 ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',$id)->first();
        if ($student->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $imageData = base64_encode(file_get_contents(asset("public/uploads/1556705924_1.png")));
$imageBase64 = 'data:image/jpeg;base64,' . $imageData;

        $data['logo'] = $imageBase64;
        $data['images'] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents(asset('uploads/images/'.$student->image)));
   	// 	dd($student);
// return view('backend.pdf.students.student-pdf', ['data' => $data,'student' => $student]);

        $pdf = PDF::loadView('backend.pdf.students.student-pdf', ['data' => $data,'student' => $student])->setPaper('A4', 'portrait');
        @unlink('pdf/students/' . 'student-pdf.pdf');
        $pdf->save('pdf/students/' . 'student-pdf.pdf');
        return $pdf->stream('student-pdf.pdf');

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
		$student = Student::find($id);
// 		dd($student, $request);
        $this->validate($request, [
            'first_name' => 'required|string|max:191',
            'father_name' => 'required|string|max:191',
            'guardian' => 'required',
            'birthday' => 'required',
            'gender' => 'required|string|max:10',
            'blood_group' => 'nullable|string|max:4',
            'religion' => 'nullable|string|max:20',
            'phone' => 'string|max:20',
            'state' => 'required|string|max:191',
            'country' => 'required|string|max:100',
            'class' => 'required',
            'section' => 'required',
            'department' => 'required',
            'group' => 'nullable|string|max:191',
			'register_no' => [
                'required',
                Rule::unique('students')->ignore($id),
            ],
            'activities' => 'nullable|string|max:191',
            'remarks' => 'nullable',
            'email' => [
                'required',
                Rule::unique('users')->ignore($student->user_id),
            ],
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);


        
    	if ($student->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        if (checkSchoolId('classes',$request->class) != schoolId() || checkSchoolId('sections',$request->section) != schoolId() || checkSchoolId('parents',$request->guardian) != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        if ($request->optional_subject) {
        	if (checkSchoolId('subjects',$request->optional_subject) != schoolId()) {
	            return redirect()->back()->with('error','access denied');
	        }
        }
        if ($request->group) {
        	if (checkSchoolId('student_groups',$request->group) != schoolId()) {
	            return redirect()->back()->with('error','access denied');
	        }
        }
		
		
        $student->parent_id = $request->guardian;
		$student->first_name = $request->first_name;
        $student->father_name = $request->father_name;
        $student->birthday = $request->birthday;
        $student->gender = $request->gender;
        $student->blood_group = $request->blood_group;
        $student->religion = $request->religion;
        $student->phone = $request->phone;
        $student->home_phone = $request->home_phone;
        $student->address = $request->address;
        $student->state = $request->state;
        $student->country = $request->country;
        $student->register_no = $request->register_no;
        $student->group = $request->group;
        $student->activities = $request->activities;
        $student->remarks = $request->remarks;
        $student->save();
		
		//Update Student Session Information
		$studentSession = StudentSession::find($request->ss_id);
		$studentSession->session_id = get_option('academic_year');
		$studentSession->student_id = $student->id;
		$studentSession->class_id = $request->class;
		$studentSession->section_id = $request->section;
        $studentSession->department_id = $request->department;
		$studentSession->roll = $request->roll;
		$studentSession->optional_subject = $request->optional_subject;
		$studentSession->save();
		

        $user = User::find($student->user_id);
        $user->name = $request->first_name." ".$request->last_name;
        $user->email = $request->email;
		$user->phone = $request->phone;
        if($request->password){
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')){
             $image = $request->file('image');
             $ImageName = time().'.'.$image->getClientOriginalExtension();
             Image::make($image)->resize(200, 160)->save(base_path('public/uploads/images/students/') . $ImageName);
             $user->image = 'students/'.$ImageName;
        }
		
        $user->save();

        \App\StudentFeeAssign::where('student_id',$student->id)->delete();
        if($request->input("chart_id")){
            foreach($request->input("chart_id") as $key => $fee_id){
                if($request->input("amount")[$key] > 0 && $fee_id!=""){
                    $invoiceItem =  new StudentFeeAssign;
                    $invoiceItem->school_id = $user->school_id;
                    $invoiceItem->student_id = $student->id;
                    $invoiceItem->fee_id = $fee_id;
                    $invoiceItem->amount = $request->input("amount")[$key];
                    $invoiceItem->discount = $request->input("discount")[$key];
                    $invoiceItem->save();
                }
            }
        }


        return redirect($_SERVER['HTTP_REFERER'])->with('success', _lang('Information has been updated'));
    }
	
	public function get_subjects( $class_id="" ){
		if($class_id != ""){
		   $subjects = Subject::where('class_id', $class_id)->where('school_id',schoolId())->get();
		   $options = '';
		   $options .= '<option value="">'._lang('Select One').'</option>';
		   foreach($subjects as $subject){
			   $options .= '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
		   }
		   return $options;
		}
	}
    public function get_all_students()
	{

                $students = Student::join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','student_sessions.roll')   
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
        //    dd($students);	   
		   return json_encode($students);
		
	}
	public function get_students( $class_id="", $section_id="" )
	{
        
		if($class_id != "" && $section_id != ""){
            if ($class_id !='all') {
                if (checkSchoolId('classes',$class_id) != schoolId()) {
                    return redirect()->back()->with('error','access denied');
                }
            }
            if ($section_id !='all') {
                if (checkSchoolId('sections',$section_id) != schoolId()) {
                    return redirect()->back()->with('error','access denied');
                }
            }
            if($class_id =='all' && $section_id =='all'){

                $students = Student::join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','student_sessions.roll')   
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
            }elseif ($class_id !='all' && $section_id =='all') {
                $students = Student::join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','student_sessions.roll')   
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('student_sessions.class_id', $class_id)
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
            }elseif ($class_id =='all' && $section_id !='all') {
                $students = Student::join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','student_sessions.roll')   
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('student_sessions.section_id', $section_id)
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
            }else{
                $students = Student::join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','student_sessions.roll')   
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('student_sessions.class_id', $class_id)
                       ->where('student_sessions.section_id', $section_id)
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
            }
					   
		   return json_encode($students);
		}
	}

	public function get_students_for_emails( $class_id="", $section_id="" )
	{
		if($class_id != "" && $section_id != ""){
            if ($class_id !='All') {
                if (checkSchoolId('classes',$class_id) != schoolId()) {
                    return redirect()->back()->with('error','access denied');
                }
            }
            if ($section_id !='All') {
                if (checkSchoolId('sections',$section_id) != schoolId()) {
                    return redirect()->back()->with('error','access denied');
                }
            }
            if($class_id =='All' && $section_id =='All'){

                	    $students = Student::join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','users.email','student_sessions.roll')   
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
            }elseif ($class_id !='All' && $section_id =='All') {
                	    $students = Student::join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','users.email','student_sessions.roll')    
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('student_sessions.class_id', $class_id)
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
            }elseif ($class_id =='All' && $section_id !='All') {
                	    $students = Student::join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','users.email','student_sessions.roll')  
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('student_sessions.section_id', $section_id)
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
            }else{
                	    $students = Student::join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
                       ->select('students.*','users.email','student_sessions.roll')   
                       ->where('student_sessions.session_id', get_option('academic_year'))
                       ->where('student_sessions.class_id', $class_id)
                       ->where('student_sessions.section_id', $section_id)
                       ->where('students.status', 1)
                       ->where('students.school_id', schoolId())
                       ->get();
            }
					   
		   return json_encode($students);
		}
	}
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
		$student = Student::find($id);
		if ($student->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        
        if ($student->status) {
           $student->status=0;
           $user = User::find($student->user_id);
            $user->status = 0;        
            $user->left_date = date('Y-m-d'); // Sets left_date to 2025-09-21
            $user->left_reasoning = $request->reason; // Sets left_reasoning to the provided value
            $user->update();
        }else{
            $student->status=1;
            $user = User::find($student->user_id);
            $user->status = 1;        
            $user->left_date = date('Y-m-d'); // Sets left_date to 2025-09-21
            $user->left_reasoning = $request->reason; // Sets left_reasoning to the provided value
            $user->update();
        }
        
        $student->update();
        

        return redirect('students')->with('success',_lang('Information has been updated'));
    }
	
	//ID Card
	public function id_card($id)
    {								
		$student = Student::join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->join('sections','sections.id','=','student_sessions.section_id')
					 ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',$id)->first();
        if ($student->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        return view('backend.students.modal.id_card',compact('student'));
    }
	//Assign Fee
    public function assign_fees($id)
    {                               
        $student = Student::find($id);
        if ($student->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        $assign_fees = \App\StudentFeeAssign::where('student_id',$id)->get();
        $fees = \App\FeeType::where('school_id',$student->school_id)->get();

        return view('backend.students.modal.assign_fees',compact('student','assign_fees','fees'));
    }
    
	public function promote(Request $request,$step=1){
		$class_id = "";
		if($step == 1){
		    return view('backend.marks.promote_student.step_one',compact('class_id'));
	    }else if($step == 2){
			$class_id = $request->class_id;
			return view('backend.marks.promote_student.step_two',compact('class_id'));
		}else if($step == 3){
			@ini_set('max_execution_time', 0);
			@set_time_limit(0);
			
			$failed_students = "";
			$subjects ="";
			
			$class_id = $request->class_id;
			$promoted_class_id = $request->promote_class_id;
			$promoted_session = $request->promoted_session;
			
			$session = get_option('academic_year');
			
			foreach($request->subject as $key=>$val){
				$subjects .= $key.",";
			}
			$subjects = substr_replace($subjects, "", -1);
			

			$subjects = DB::select("SELECT marks.student_id,marks.subject_id,SUM(mark_details.mark_value) as total_marks,(SUM(mark_details.mark_value)/(SELECT COUNT(id) 
			FROM marks as m WHERE subject_id=marks.subject_id AND student_id=marks.student_id)) avg_mark, subjects.pass_mark from mark_details,marks,student_sessions,subjects 
			WHERE mark_details.mark_id=marks.id AND marks.student_id=student_sessions.student_id AND student_sessions.session_id=:session AND marks.subject_id=subjects.id 
			AND marks.class_id=:class_id AND subjects.id IN($subjects)
			GROUP by marks.subject_id,marks.student_id", ["session"=>$session,"class_id"=>$class_id]);
	        
			foreach($subjects as $subject){
				if($subject->avg_mark < $subject->pass_mark){
				    $failed_students .= $subject->student_id.",";
				}
			}
			$failed_students = substr_replace($failed_students, "", -1);
			$query ="";
			if($failed_students != ""){
				$query =" AND students.id NOT IN($failed_students) ";
			}
			//dd($session);
			$promotion = DB::select("SELECT marks.student_id,student_sessions.roll, IFNULL(SUM(mark_details.mark_value),0) as total_marks 
			FROM marks,mark_details,exams,students,student_sessions WHERE marks.id=mark_details.mark_id AND marks.exam_id=exams.id AND 
			marks.student_id=students.id AND students.id=student_sessions.student_id AND marks.class_id=:class_id AND student_sessions.session_id=:session 
			$query GROUP BY marks.student_id ORDER BY total_marks DESC", ["class_id"=>$class_id,"session"=>$session]);
	        
			
			$sections = Section::where("class_id",$promoted_class_id)->orderBy('rank', 'asc')->get();
			
			$sections_count = count($sections);
			$student_count = count($promotion);
			
//dd($student_count);
			if( $sections_count>0 && $student_count>0){
				
				//$split = ceil($student_count/$sections_count);
				
				$section = 0;
				$counter = 1;
				$roll = 1;
				
				$split = $sections[$section]->capacity;
				
				foreach($promotion as $p){
					//Create Student Session Information
					$studentSession = new StudentSession();
					$studentSession->session_id = $promoted_session;
					$studentSession->student_id = $p->student_id;
					$studentSession->class_id = $promoted_class_id;
					$studentSession->section_id = $sections[$section]->id;
					$studentSession->roll = $roll;
					try {
						$studentSession->save();
					} catch (\Illuminate\Database\QueryException $e) {
						return redirect('students/promote')->with('error',_lang('Sorry, You have already promoted this class!'));
					} catch (\Exception $e) {
						return redirect('students/promote')->with('error',_lang('Sorry, You have already promoted this class!'));
					}
					
					
					$counter++;
					$roll++;
					
					if($counter > $split){
						$counter = 1;
						$section++;
					}
				}
				return redirect('students/promote')->with('success',_lang('Student Promoted Sucessfully.'));
			}else{
				return redirect('students/promote')->with('error',_lang('Sorry, Section not available for promoted class ! Please create Section first.'));
			}
			
		}
	}

}
