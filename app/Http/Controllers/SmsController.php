<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Twilio\Rest\Client;
// use GuzzleHttp\Client;
use Twilio\Jwt\ClientToken;
use App\SmsLog;
use App\WhatsAppLog;
use App\Student;
use App\Setting;
use App\StudentSession;
use App\User;
use App\ClassModel;
use App\Section;
use App\Subject;
use App\InvoiceItem;
use App\StudentFeeAssign;
use App\ParentModel;
use DB;
use Validator;
use Auth;

class SmsController extends Controller
{
	public function create()
    {
        return view('backend.sms.create');
    }
	
	public function logs()
    {
        $messages = SmsLog::join("users","sms_logs.sender_id","=","users.id")
					 ->select('sms_logs.*','users.name as sender')
		             ->orderBy("sms_logs.id","DESC")->paginate(15);
         return view('backend.sms.logs',compact('messages'));
    }
	
	
    public function send(Request $request)
    {

		if ($request->action == 'sms') {
			// Handle SMS sending logic
					@ini_set('max_execution_time', 0);
			@set_time_limit(0);
			
			
			$this->validate($request, [
				'body' => 'required|max:300',
				'user_id' => 'required_without:student_id',
				'student_id' => 'required_without:user_id',
			]);
			
			$body = strip_tags($request->input("body"));
			
			$accountSid = get_option("TWILIO_SID");
			$authToken  = get_option("TWILIO_TOKEN");
			$mobileNumber = get_option("TWILIO_MOBILE");
			$client = new Client($accountSid, $authToken);
			try
			{
				if($request->input('user_id') != ""){
					if($request->input('user_id') == "all"){
					foreach( $request->input('users') as $mobile_number ){
						if( Auth::user()->phone == $mobile_number || $mobile_number == ""){
							continue;
						}
							$client->messages->create(
								$mobile_number,
								array(
									'from' => $mobileNumber,
									'body' => $body
								)
							);
							
							$log = new SmsLog();
							$log->receiver = $mobile_number;
							$log->message = $body;
							$log->sender_id = Auth::user()->id;
							$log->save();
					}
					}else{
					if( Auth::user()->phone != $request->input('user_id') || $request->input('user_id') != ""){
						$client->messages->create(
								$request->input('user_id'),
								array(
									'from' => $mobileNumber,
									'body' => $body
								)
							);
							
							$log = new SmsLog();
							$log->receiver = $request->input('user_id');
							$log->message = $body;
							$log->sender_id = Auth::user()->id;
							$log->save();
					}else{
						return redirect('sms/compose')->with('error', _lang('Invalid mobile number Or Illegal Operation !'))->withInput();
					}
					
					}
				}
				
				if($request->input('student_id') != ""){
					if($request->input('student_id') == "all"){
					foreach( $request->input('users') as $mobile_number ){
						if( Auth::user()->phone == $mobile_number || $mobile_number == ""){
							continue;
						}
						$client->messages->create(
								$mobile_number,
								array(
									'from' => $mobileNumber,
									'body' => $body
								)
						);
						
							$log = new SmsLog();
							$log->receiver = $mobile_number;
							$log->message = $body;
							$log->sender_id = Auth::user()->id;
							$log->save();
					}
					}else{
					if( Auth::user()->phone != $request->input('student_id') || $request->input('student_id') != "" ){	
							$client->messages->create(
								$request->input('student_id'),
								array(
									'from' => $mobileNumber,
									'body' => $body
								)
							);
							
							$log = new SmsLog();
							$log->receiver = $request->input('student_id');
							$log->message = $body;
							$log->sender_id = Auth::user()->id;
							$log->save();
					}else{
						return redirect('message/compose')->with('error', _lang('Invalid mobile number Or Illegal Operation !'))->withInput();
					}
					}
				}
				
				return redirect()->back()->with('success', _lang('Message Send Sucessfully.'));
			
			}catch (Exception $e){
				return redirect()->back()->with('error', $e->getMessage());
			}
		}else if ($request->action == 'whatsapp'){
			
			$settings = Setting::first();
			$company_phone = $settings->phone ?? 'N/A';
			$site = $settings->site_title ?? 'N/A';
			$hostel = $settings->school_name ?? 'Hostel Name';
			$address = $settings->address ?? 'Hostel Address';
			// dd($request);
			if($request->student_id == 'all'){

				$students = Student::where('id', $request->students)->get();
			}else{
				$students = Student::where('id', $request->student_id)->get();
			}

			$token = env('WAAPI_TOKEN');
			foreach($students as $student){
			
				$phone = $student->phone;
				$home_phone = $student->home_phone;
				$studentName = $student->first_name.' '.$student->last_name;
				$numbersToSend = [$phone, $home_phone];
				$messageBody = $request->body;
				
				foreach ($numbersToSend as $targetPhone) {
					// Validate phone format: starts with 923, exactly 12 digits
					if (empty($targetPhone) || !preg_match('/^923\d{9}$/', $targetPhone)) {
						continue;
					}

					try {
						$message = <<<EOT
							{$messageBody}
						
							EOT;

						$client = new \GuzzleHttp\Client();

						//TODO: Need to remove it 211
						// $response = $client->post('https://waapi.app/api/v1/instances/63281/client/action/send-message', [
						// 	'headers' => [
						// 		'accept' => 'application/json',
						// 		'authorization' => 'Bearer ' . $token,
						// 		'content-type' => 'application/json',
						// 	],
						// 	'json' => [
						// 		'chatId' => $targetPhone . '@c.us',
						// 		'message' => $message,
						// 		'mentions' => [$targetPhone . '@c.us']
						// 	],
						// ]);

			
						// $responseBody = json_decode($response->getBody()->getContents(), true);

						// if (isset($responseBody['data']['status']) && $responseBody['data']['status'] === 'error') {
						// 	\Log::warning("WAAPI Error for {$targetPhone}: " . $responseBody['data']['message']);
						// 	continue;
						// }

					} catch (RequestException $e) {
						\Log::error("HTTP error for {$targetPhone}: " . $e->getMessage());
						continue;
					} catch (\Exception $e) {
						\Log::error("Unexpected error for {$targetPhone}: " . $e->getMessage());
						continue;
					}
				}
			
			}
			return redirect()->back()->with('success', _lang('Message Send Sucessfully.'));
		}

    }

	//WhatsApp messaging
	
	// by fatima 12-05-2025 
	
	//WhatsApp sending view
	public function createWhatsApp()
    {
		$students = Student::join('users','users.id','=','students.user_id')
		->join('student_sessions','students.id','=','student_sessions.student_id')
		->join('invoices', 'students.id', '=', 'invoices.student_id')
		->join('classes','classes.id','=','student_sessions.class_id')
		->join('sections','sections.id','=','student_sessions.section_id')
		->select(
			'users.*',
			'students.activities',
			'students.address',
			'students.father_name',
			'students.first_name',
			'students.last_name',
			'sections.section_name',
			'invoices.paid',
			'invoices.total',
			DB::raw('(invoices.total - invoices.paid) as remaining'),
			'students.status',
			'students.id as id'
		)
		->where('invoices.status', 'Unpaid') // fixed this line
		->orderBy('users.id', 'DESC')
		->distinct()
		->get();

        return view('backend.Whatsapp.create' , compact('students'));
    }

	//Send WhatsApp Messages 
	public function sendWhatsApp(Request $request)
	{
		if ($request->action == 'whatsapp'){
			
		$settings = Setting::first();
		$site = $settings->site_title ?? 'N/A';
		$hostel = $settings->school_name ?? 'Hostel Name';
		$address = $settings->address ?? 'Hostel Address';
		// dd($request);
		
		if ($request->student_id == 'all') {
			$students = Student::join('users','users.id','=','students.user_id')
				->join('student_sessions','students.id','=','student_sessions.student_id')
				->join('invoices', 'students.id', '=', 'invoices.student_id')
				->join('classes','classes.id','=','student_sessions.class_id')
				->join('sections','sections.id','=','student_sessions.section_id')
				->select(
					'users.*',
					'students.activities',
					'students.address',
					'students.father_name',
					'students.first_name',
					'students.last_name',
					'sections.section_name',
					'invoices.paid',
					'invoices.total',
					DB::raw('(invoices.total - invoices.paid) as remaining'),
					'students.status',
					'students.id as id'
				)
				->whereIn('students.id', $request->students)
				->where('invoices.status', 'Unpaid') // fixed this line
				->orderBy('users.id', 'DESC')
				->distinct()
				->get();
		} else {
			$students = Student::join('users','users.id','=','students.user_id')
				->join('student_sessions','students.id','=','student_sessions.student_id')
				->join('invoices', 'students.id', '=', 'invoices.student_id')
				->join('classes','classes.id','=','student_sessions.class_id')
				->join('sections','sections.id','=','student_sessions.section_id')
				->select(
					'users.*',
					'students.activities',
					'students.address',
					'students.father_name',
					'students.first_name',
					'students.last_name',
					'sections.section_name',
					'invoices.paid',
					'invoices.total',
					DB::raw('(invoices.total - invoices.paid) as remaining'),
					'students.status',
					'students.id as id'
				)
				->where('students.id', $request->student_id)
				->where('invoices.status', 'Unpaid') // fixed this line
				->orderBy('users.id', 'DESC')
				->distinct()
				->get();
		}

// dd($students);
		$token = env('WAAPI_TOKEN');
		foreach($students as $student){
		
			$phone = $student->phone;
			$home_phone = $student->home_phone;
			$studentName = $student->first_name.' '.$student->last_name;
			$FatherName = $student->father_name;
			$StudentAddress = $student->address;
			$studentRoom = $student->section_name;
			$numbersToSend = [$phone, $home_phone];
			$messageBody = $request->body;
			$studentDues = $student->remaining;
			// dd($messageBody);
			$placeholders = [
				'{student_name}' => $studentName,
				'{father_name}' => $FatherName,
				'{room_no}' => $studentRoom,
				'{dues}' => $studentDues,
				'{address}' => $StudentAddress,
				'{phone}' => $phone,

			];
			$messageBody = strtr($messageBody, $placeholders);
						
			foreach ($numbersToSend as $targetPhone) {
				// Validate phone format: starts with 923, exactly 12 digits
				if (empty($targetPhone) || !preg_match('/^923\d{9}$/', $targetPhone)) {
					continue;
				}
				$log = new WhatsAppLog();
				$log->receiver = $targetPhone;
				$log->message = $messageBody;
				$log->sender_id = Auth::user()->id;
				$log->save();

				try {
				
					$message = <<<EOT
		
						{$messageBody}
											
						
					EOT;

					$client = new \GuzzleHttp\Client();

					//TODO: Need to uncomment it till 392

					// $response = $client->post('https://waapi.app/api/v1/instances/63281/client/action/send-message', [
					// 	'headers' => [
					// 		'accept' => 'application/json',
					// 		'authorization' => 'Bearer ' . $token,
					// 		'content-type' => 'application/json',
					// 	],
					// 	'json' => [
					// 		'chatId' => $targetPhone . '@c.us',
					// 		'message' => $message,
					// 		'mentions' => [$targetPhone . '@c.us']
					// 	],
					// ]);

		
					// $responseBody = json_decode($response->getBody()->getContents(), true);

					// if (isset($responseBody['data']['status']) && $responseBody['data']['status'] === 'error') {
					// 	\Log::warning("WAAPI Error for {$targetPhone}: " . $responseBody['data']['message']);
					// 	continue;
					// }

				} catch (RequestException $e) {
					\Log::error("HTTP error for {$targetPhone}: " . $e->getMessage());
					continue;
				} catch (\Exception $e) {
					\Log::error("Unexpected error for {$targetPhone}: " . $e->getMessage());
					continue;
				}
			}
		
		}
		return redirect()->back()->with('success', _lang('Message Send Sucessfully.'));
		}

	}

	//create Whats Message Log
 public function WhatsAppLogs(Request $request){
	$messages = WhatsAppLog::join("users","whatsapp_logs.sender_id","=","users.id")
	->select('whatsapp_logs.*','users.name as sender')
	->orderBy("whatsapp_logs.id","DESC")->paginate(15);
return view('backend.Whatsapp.whatsapp-log',compact('messages'));
 }
	
}