<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\User;
use Validator;
use Carbon\Carbon;
use Hash;
use Image;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('user_type',"!=","Parent")
		             ->where('user_type',"!=","Student")
                     ->where('school_id',schoolId())
		             ->orderBy('id', 'DESC')->get();
        return view('backend.users.user-list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.user-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   //      $this->validate($request, [
   //          'name' => 'required|string|max:191',
   //          'email' => 'required|string|email|max:191|unique:users',
   //          'password' => 'required|string|min:6|confirmed',
   //          'user_type' => 'required',
   //          'role_id' => 'required',
			// 'phone' => 'required|string|max:20',
   //          'image' => 'nullable|image|max:5120',
   //      ]);
        if ($request->role_id !=0) {
            if (checkSchoolId('permission_roles',$request->role_id) != schoolId()) {
                return redirect()->back()->with('error','access denied');
            }
        }

        $ImageName='profile.png';

        if ($request->hasFile('image')){
           $image = $request->file('image');
           $ImageName = time().'.'.$image->getClientOriginalExtension();
           try {
               Image::make($image)->resize(400, 400)->save(base_path('public/uploads/images/users/') . $ImageName);
           } catch (\Intervention\Image\Exception\NotSupportedException $e) {
               $image->move(public_path('uploads/images/users/'), $ImageName);
           } catch (\Exception $e) {
               $image->move(public_path('uploads/images/users/'), $ImageName);
           }
        }

        if ($request->take_image) {
            $img = $request->take_image;
            $folderPath = 'public/uploads/images/users/';

            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
          
            $image_base64 = base64_decode($image_parts[1]);
            $ImageName = time() . '.png';
          
            $file = $folderPath . $ImageName;
            file_put_contents($file, $image_base64);

          try {
              Image::make($file)->resize(400, 400)->save(base_path('public/uploads/images/users/') . $ImageName);
          } catch (\Intervention\Image\Exception\NotSupportedException $e) {
              // GD/Imagick not available; leave the file as written by file_put_contents
          } catch (\Exception $e) {
              // Other errors; leave original file in place
          }
        }

       $user = new User();
       $user->school_id = schoolId();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = Hash::make($request->password);
       $user->user_type = $request->user_type;
       $user->role_id = $request->role_id;
       $user->phone = $request->phone;
       $user->image = 'users/'.$ImageName;
	   $user->facebook = $request->facebook =="" ? "#" : $request->facebook;
	   $user->twitter = $request->twitter =="" ? "#" : $request->twitter;
	   $user->linkedin = $request->linkedin =="" ? "#" : $request->linkedin;
	   $user->google_plus = $request->google_plus =="" ? "#" : $request->google_plus;
       $user->save();

       return redirect('users')->with('success', _lang('Information has been added'));
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        
        if ($data->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        return view('backend.users.user-view',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        
        if ($data->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        return view('backend.users.user-edit',compact('data'));
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
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'password' => 'nullable|min:6|confirmed',
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'user_type' => 'required',
			'role_id' => 'required',
			'phone' => 'required|string|max:20',
            'image' => 'nullable|image|max:5120',
        ]);

        if (checkSchoolId('permission_roles',$request->role_id) != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        
        $user = User::find($id);
        
        if ($user->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
		$user->role_id = $request->role_id;
        $user->phone = $request->phone;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('image')){
           $image = $request->file('image');
           $ImageName = time().'.'.$image->getClientOriginalExtension();
           try {
               Image::make($image)->resize(400, 400)->save(base_path('public/uploads/images/users/') . $ImageName);
           } catch (\Intervention\Image\Exception\NotSupportedException $e) {
               $image->move(public_path('uploads/images/users/'), $ImageName);
           } catch (\Exception $e) {
               $image->move(public_path('uploads/images/users/'), $ImageName);
           }
           $user->image = 'users/'.$ImageName;
       }
	   $user->facebook = $request->facebook =="" ? "#" : $request->facebook;
	   $user->twitter = $request->twitter =="" ? "#" : $request->twitter;
	   $user->linkedin = $request->linkedin =="" ? "#" : $request->linkedin;
	   $user->google_plus = $request->google_plus =="" ? "#" : $request->google_plus;
       $user->save();

       return redirect('users')->with('success', _lang('Information has been updated'));
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if ($user->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        $user->delete();

        return redirect('users')->with('success', _lang('Information has been deleted'));
    }
	
	public function get_users( $user_type="" ){
		if( $user_type != "" ){
		   $users = User::where('school_id',schoolId())->where("user_type",$user_type)->get();			   
		   return json_encode($users);
		}
	}
	
}
