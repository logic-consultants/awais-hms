<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Setting;
use App\User;


class FrontendController extends Controller
{	
	
	
    public function index()
    {
        return Redirect('/login');
		// return View('frontend.index');
    }
    public function subscribe(Request $request)
    {
        $email = $request->email;
		return View('frontend.subscribe',compact('email'));
    }
    public function subscribe_user(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required|unique:users',
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required|min:6',
            'institute_name' => 'required',
        ]);
        $subscribe = new Setting;
        $subscribe->email = $request->email;
        $subscribe->currency_symbol = '৳';
        $subscribe->backend_direction = 'ltr';
        $subscribe->active_theme = 'default';
        $subscribe->language = 'English';
        $subscribe->phone = $request->phone;
        $subscribe->school_name = $request->institute_name;
        $subscribe->save();

        $user = new User;
        $user->school_id = $subscribe->id;
        $user->role_id = 0;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =Hash::make($request->password);
        $user->phone = $request->phone;
        $user->user_type = 'Admin';
        $user->status = 1;
        $user->save();


        $year = new AcademicYear;
        $year->AcademicYear = 'Session - '.\Carbon\Carbon::now()->format('Y');
        $year->school_id = $subscribe->id;
        $year->year = \Carbon\Carbon::now()->format('Y');
        $year->save();

        
        $update = Setting::find($subscribe->id);
        $update->academic_year = $year->id;
        $update->update();


        return Redirect('/login');
    }
    
}
