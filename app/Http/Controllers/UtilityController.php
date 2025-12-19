<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Setting;
use Carbon\Carbon;
use DB;
use Auth;
use App\Utilities\PHPMySQLBackup;

class UtilityController extends Controller
{
    /**
     * Show the Settings Page.
     *
     * @return Response
     */

	public function __construct(){
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
	} 
	 
    public function settings(Request $request,$store="")
    {
    	$school_id = Auth::user()->school_id;
		if($store == ""){
           return view('backend.administration.general_settings.settings');
        }else{
        	$setting = Setting::find($school_id);
        	if ($request->generalInput) {
	        	$setting->school_name = $request->school_name;
	        	$setting->site_title = $request->site_title;
	        	$setting->phone = $request->phone;
	        	$setting->email = $request->email;
	        	$setting->currency_symbol = $request->currency_symbol;
	        	$setting->timezone = $request->timezone;
	        	$setting->academic_year = $request->academic_year;
	        	$setting->active_theme = $request->active_theme;
	        	$setting->language = $request->language;
	        	$setting->backend_direction = $request->backend_direction;
	        	$setting->address = $request->address;
        	}
        	if ($request->emailInput) {

	        	$setting->mail_type = $request->mail_type;
	        	$setting->from_email = $request->from_email;
	        	$setting->from_name = $request->from_name;
	        	$setting->smtp_host = $request->smtp_host;
	        	$setting->smtp_port = $request->smtp_port;
	        	$setting->smtp_username = $request->smtp_username;
	        	$setting->smtp_password = $request->smtp_password;
	        	$setting->smtp_encryption = $request->smtp_encryption;
	        	$setting->email_footer = $request->email_footer;
        	}
        	if ($request->smsInput) {
	        	$setting->TWILIO_SID = $request->TWILIO_SID;
	        	$setting->TWILIO_TOKEN = $request->TWILIO_TOKEN;
	        	$setting->TWILIO_MOBILE = $request->TWILIO_MOBILE;
        	}
        	if ($request->paymentInput) {
	        	$setting->paypal_active = $request->paypal_active;
	        	$setting->paypal_email = $request->paypal_email;
	        	$setting->paypal_currency = $request->paypal_currency;
	        	$setting->stripe_active = $request->stripe_active;
	        	$setting->stripe_secret_key = $request->stripe_secret_key;
	        	$setting->stripe_publishable_key = $request->stripe_publishable_key;
	        	$setting->stripe_currency = $request->stripe_currency;
        	}
        	if ($request->logoInput) {
        		
        	}
        	if ($request->appearanceInput) {
        		$setting->sidebar_color = $request->sidebar_color;
        		$setting->sidebar_text_color = $request->sidebar_text_color;
        		$setting->sidebar_border_color = $request->sidebar_border_color;
        		$setting->active_sidebar_background = $request->active_sidebar_background;
        		$setting->custom_backend_css = $request->custom_backend_css;
        	}

        	$setting->update();
        	
			if(! $request->ajax()){
			   return redirect('administration/general_settings')->with('success', _lang('Saved sucessfully'));
			}else{
			   return response()->json(['result'=>'success','action'=>'update','message'=>_lang('Saved sucessfully')]);
			}
			//return redirect('administration/general_settings')->with('success',_lang('Saved Sucessfully'));
		}
	}
	
	public function update_theme_option($store="",Request $request)
    {		
	    
		foreach($_POST as $key => $value){
			 if($key == "_token"){
				 continue;
			 }
			 
			 $data = array();
			 $data['value'] = is_array($value) ? serialize($value) : $value; 
			 $data['updated_at'] = Carbon::now();
			 if(Setting::where('name', $key)->exists()){				
				Setting::where('name','=',$key)->update($data);			
			 }else{
				$data['name'] = $key; 
				$data['created_at'] = Carbon::now();
				Setting::insert($data); 
			 }

		} //End $_POST Loop
		
		foreach($_FILES as $key => $value){
		   $this->upload_file($key,$request);
		}
		
		
		if(! $request->ajax()){
		   return redirect()->back()->with('success', _lang('Saved sucessfully'));
		}else{
		   return response()->json(['result'=>'success','action'=>'update','message'=>_lang('Saved sucessfully')]);
		}
	}
	
	
	public function change_session($session_id){
		$data = Setting::find(schoolId());
		if ($data->id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $data->academic_year = $session_id;
        $data->update();
        
		return redirect($_SERVER['HTTP_REFERER'])->with('success',_lang('Session Changed Sucessfully.'));
	}
	
	public function upload_logo(Request $request){
		$this->validate($request, [
			'logo' => 'required|image|mimes:jpeg,png,jpg|max:8192',
		]);
		$school_id = Auth::user()->school_id;
		if ($request->hasFile('logo')) {
			$image = $request->file('logo');
			$name = rand().'_'.$school_id.'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads');
			$image->move($destinationPath, $name);

			$setting = Setting::find($school_id);
			$setting->logo = $name;
			$setting->update();
						
			if(! $request->ajax()){
			   return redirect('administration/general_settings')->with('success', _lang('Saved sucessfully'));
			}else{
			   return response()->json(['result'=>'success','action'=>'update','message'=>_lang('Logo Upload successfully')]);
			}

		}
	}
	
	public function upload_file($file_name,Request $request){

		if ($request->hasFile($file_name)) {
			$file = $request->file($file_name);
			$name = 'file_'.time().".".$file->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/media');
			$file->move($destinationPath, $name);

			$data = array();
			$data['value'] = $name; 
			$data['updated_at'] = Carbon::now();
			
			if(Setting::where('name', $file_name)->exists()){				
				Setting::where('name','=',$file_name)->update($data);			
			}else{
				$data['name'] = $file_name; 
				$data['created_at'] = Carbon::now();
				Setting::insert($data); 
			}	
		}
	}
	
	
	public function backup_database($pass=""){
	    
	    //https://ibh.hostalmanager.pk/administration/backup_database/logicAppAdminPassword3256
	    
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);
			
		if($pass==="logicAppAdminPassword3256")
		{
    		$return = "";
    		$database = 'Tables_in_'.DB::getDatabaseName();
    		$tables = array();
    		$result = DB::select("SHOW TABLES");
    
    		foreach($result as $table){
    			$tables[] = $table->$database;
    		}
    
    
    		//loop through the tables
    		foreach($tables as $table){			
    			$return .= "DROP TABLE IF EXISTS $table;";
    
    			$result2 = DB::select("SHOW CREATE TABLE $table");
    			$row2 = $result2[0]->{'Create Table'};
    
    			$return .= "\n\n".$row2.";\n\n";
    			
    			$result = DB::select("SELECT * FROM $table");
    
    			foreach($result as $row){	
    				$return .= "INSERT INTO $table VALUES(";
    				foreach($row as $key=>$val){	
    					$return .= "'".addslashes($val)."'," ;	
    				}
    				$return = substr_replace($return, "", -1);
    				$return .= ");\n";
    			}
       
    			$return .= "\n\n\n";
    		}
    
    		//save file
			$file = public_path("backend/B-BACKUP-".time().".sql");
			$handle = fopen($file,'w+');
			fwrite($handle,$return);
			fclose($handle);
    		
    		return response()->download($file);
    		return redirect()->back()->with('success', _lang('Backup Created Sucessfully'));	
		}
		else
		{
		    return redirect("/");
		}
	
	}
	
}