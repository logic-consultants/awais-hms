<?php

if ( ! function_exists('_lang')){
	function _lang($string=''){
		
		//Get Target language
		$target_lang = get_option('language');
		
		if($target_lang == ""){
			$target_lang = "language";
		}
		
		if(file_exists(resource_path() . "/language/$target_lang.php")){
			include(resource_path() . "/language/$target_lang.php"); 
		}else{
			include(resource_path() . "/language/language.php"); 
		}
		
		if (array_key_exists($string,$language)){
			return $language[$string];
		}else{
			return $string;
		}
	}
}


if ( ! function_exists('startsWith')){
	function startsWith($haystack, $needle)
	{
		 $length = strlen($needle);
		 return (substr($haystack, 0, $length) === $needle);
	}
}
if ( ! function_exists('schoolId')){
	function schoolId()
	{
		$school_id = Auth::user()->school_id;
		return $school_id;
	}
}
function sendWhatsAppMessage($message,$phone,$home_phone)
    {
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
if ( ! function_exists('checkSchoolId')){
	function checkSchoolId($table,$id)
	{
		$query = DB::table($table)->select('school_id')->where('id',$id)->first();

		return $query ? $query->school_id:1;
	}
}


if ( ! function_exists('create_option')){
	function create_option($table,$value,$display,$selected="",$where=NULL){
		$school_id = Auth::user()->school_id;
		$options = "";
		$condition = "";

		$condition .= "WHERE school_id=".$school_id." ";

		if($where != NULL){
			$condition .= "AND ";
			foreach( $where as $key => $v ){
				$condition.=$key."'".$v."' ";
			}
		}

		$query = DB::select("SELECT $value, $display FROM $table $condition");
		foreach($query as $d){
			if( $selected!="" && $selected == $d->$value ){   
				$options.="<option value='".$d->$value."' selected='true'>".ucwords($d->$display)."</option>";
			}else{
				$options.="<option value='".$d->$value."'>".ucwords($d->$display)."</option>";
			} 
		}
		
		echo $options;
	}
}

if ( ! function_exists('get_table')){
	function get_table($table,$where=NULL) 
	{
		$school_id = Auth::user()->school_id;
		$condition = "WHERE school_id=".$school_id." ";
		if($where != NULL){
			$condition .= "AND ";
			foreach( $where as $key => $v ){
				$condition.=$key."'".$v."' ";
			}
		}
		$query = DB::select("SELECT * FROM $table $condition");
		return $query;
	}
}

if ( ! function_exists('get_pages')){
	function get_pages() 
	{
		$pages = \App\Page::where("page_status","publish")->get();
	    return $pages;
	}
}

if ( ! function_exists('get_posts')){
	function get_posts($limit=5, $post_type="post") 
	{
		$posts = \App\Post::where("post_status","publish")
		                  ->where("post_type",$post_type)
		                  ->where("school_id",schoolId())
						  ->orderBy("id","desc")
						  ->limit($limit)
						  ->get();
	    return $posts;
	}
}

if ( ! function_exists('get_notices')){
	function get_notices($user_type="Website", $limit=5) 
	{
		$notices = \App\Notice::join("user_notices","notices.id","user_notices.notice_id")
		                  ->select('notices.*')
						  ->where("user_notices.user_type",$user_type)
						  ->where("notices.school_id",schoolId())
						  ->orderBy("notices.id","desc")
						  ->limit($limit)
						  ->get();
	    return $notices;
	}
}

if ( ! function_exists('get_events')){
	function get_events($limit=5) 
	{
		$events = \App\Event::limit($limit)->where('school_id',schoolId())
						->orderBy("id","desc")->get();
	    return $events;
	}
}

if ( ! function_exists('user_count')){
	function user_count($user_type) 
	{
		$count = \App\User::where("user_type",$user_type)->where("school_id",schoolId())
						->selectRaw("COUNT(id) as total")
						->first()->total;
	    return $count;
	}
}

if ( ! function_exists('post_parmalink')){
	function post_parmalink($post) 
	{
		return url('post/'.$post->slug);
	}
}

if ( ! function_exists('get_logo')){
	function get_logo() 
	{
		// $logo = get_option("logo");
		$data = DB::table('settings')->select('logo')->first();
		$logo = $data->logo;
		if($logo ==""){
			return asset("uploads/1556705924_1.png");
		}
		return asset("uploads/$logo"); 
	}
}
if ( ! function_exists('get_department_logo')){
	function get_department_logo($id,$logo_name) 
	{
		// $logo = get_option("logo");
		$data = DB::table('departments')->select('school_logo','bank_logo')->first();
		if (!empty($data)) {
			if($data->$logo_name ==""){
				return asset("public/uploads/1556705924_1.png");
			}else{
				return asset("public/uploads/".$data->$logo_name); 
			}
		}
		else{
			return asset("public/uploads/logo.png");
		}
	}
}

if ( ! function_exists('get_school_name')){
	function get_school_name() 
	{
		// $logo = get_option("logo");
		$data = DB::table('settings')->select('school_name')->first();
		return $data->school_name;
	}
}

if ( ! function_exists('sql_escape')){
	function sql_escape($unsafe_str) 
	{
		if (get_magic_quotes_gpc())
		{
			$unsafe_str = stripslashes($unsafe_str);
		}
		return $escaped_str = str_replace("'", "", $unsafe_str);
	}
}

if ( ! function_exists('get_option')){
	function get_option($name) 
	{
		if (Schema::hasColumn('settings', $name)) {
			$school_id = Auth::user()->school_id;
			$setting = DB::table('settings')->where('id', $school_id)->first();
		    if ( $setting ) {
			   	return $setting->$name;				
			}
		}
		return "";

	}
}

if ( ! function_exists('has_permission')){
	function has_permission($name,$role_id) 
	{
		$permission = DB::table('permissions')
		          ->where('permission', $name)
		          ->where('role_id', $role_id)
				  ->get();
	    if ( ! $permission->isEmpty() ) {
		   return true;
		}
		return false;
	}
}

if ( ! function_exists('get_academic_year')){
	function get_academic_year($id = "") 
	{
		if($id == ""){
			$id = get_option("academic_year");
		}
		$query = DB::table('academic_years')->where('id', $id)->get();
	    if ( ! $query->isEmpty() ) {
		   return $query[0]->year;
		}
		return "";

	}
}

if ( ! function_exists('get_class_name')){
	function get_class_name($id) 
	{
		$class = DB::table('classes')->where('id', $id)->get();
	    if ( ! $class->isEmpty() ) {
		   return $class[0]->class_name;
		}
		return "";

	}
}

if ( ! function_exists('get_grade')){
	function get_grade($mark) 
	{
		$mark = sql_escape($mark);
		$grade = DB::select("SELECT grade_name FROM grades WHERE $mark BETWEEN marks_from AND marks_to");
	    if ( count($grade) >0 ) {
		   return $grade[0]->grade_name;
		}
		return "N/A";

	}
}

if ( ! function_exists('get_point')){
	function get_point($mark) 
	{
		$mark = sql_escape($mark);
		$grade = DB::select("SELECT point FROM grades WHERE $mark BETWEEN marks_from AND marks_to");
	    if ( count($grade) >0 ) {
		   return $grade[0]->point;
		}
		return "N/A";

	}
}

if ( ! function_exists('get_final_grade')){
	function get_final_grade($point) 
	{
		$point = sql_escape($point);
		$grade = DB::select("SELECT grade_name FROM grades WHERE $point>point OR $point=point limit 1");
	    if ( count($grade) >0 ) {
		   return $grade[0]->grade_name;
		}
		return "N/A";

	}
}

if ( ! function_exists('get_section_name')){
	function get_section_name($id) 
	{
		$class = DB::table('sections')->where('id', $id)->get();
	    if ( ! $class->isEmpty() ) {
		   return $class[0]->section_name;
		}
		return "";

	}
}

if ( ! function_exists('get_subject_name')){
	function get_subject_name($id) 
	{
		$class = DB::table('subjects')->where('id', $id)->get();
	    if ( ! $class->isEmpty() ) {
		   return $class[0]->subject_name;
		}
		return "";

	}
}


if ( ! function_exists('get_exam')){
	function get_exam($id) 
	{
		$class = DB::table('exams')->where('id', $id)->get();
	    if ( ! $class->isEmpty() ) {
		   return $class[0]->name;
		}
		return "";

	}
}

if ( ! function_exists('timezone_list'))
{

 function timezone_list() {
  $zones_array = array();
  $timestamp = time();
  foreach(timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
    $zones_array[$key]['ZONE'] = $zone;
    $zones_array[$key]['GMT'] = 'UTC/GMT ' . date('P', $timestamp);
  }
  return $zones_array;
}

}

if ( ! function_exists('create_timezone_option'))
{

 function create_timezone_option($old="") {
  $option = "";
  $timestamp = time();
  foreach(timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
	$selected = $old == $zone ? "selected" : "";
	$option .= '<option value="'. $zone .'"'.$selected.'>'. 'GMT ' . date('P', $timestamp) .' '.$zone.'</option>';
  }
  echo $option;
}

}


if ( ! function_exists( 'get_country_list' ))
{
    function get_country_list( $old_data='' ) {
		if( $old_data == "" ){
			echo file_get_contents( app_path().'/Helpers/country.txt' );
		}else{
			$pattern='<option value="'.$old_data.'">';
			$replace='<option value="'.$old_data.'" selected="selected">';
			$country_list=file_get_contents( app_path().'/Helpers/country.txt' );
			$country_list=str_replace($pattern,$replace,$country_list);
			echo $country_list;
		}
    }	
}

if (!function_exists('get_country_states')) {
    function get_country_states($old_data, $country) {
        if ($old_data == "") {
            $file_path = app_path() . '/Helpers/country_state.json';
            if (!file_exists($file_path)) {
                die('Error: JSON file not found at ' . $file_path);
            }

            $file_content = file_get_contents($file_path);
            if ($file_content === false) {
                die('Error: Unable to read JSON file.');
            }

            $state = json_decode($file_content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                die('JSON Error: ' . json_last_error_msg());
            }

            if (!isset($state[$country])) {
                die('Error: Country ' . $country . ' not found in JSON data.');
            }

            $provinces = $state[$country];
            if (empty($provinces)) {
                die('Error: No provinces found for country ' . $country);
            }

            $options = "";
            foreach ($provinces as $province) {
                if (!isset($province['value']) || !isset($province['label'])) {
                    die('Error: Invalid province data structure: ' . print_r($province, true));
                }
                $options .= '<option value="' . htmlspecialchars($province['value']) . '">' . htmlspecialchars($province['label']) . '</option>';
            }
			
            echo $options;
        } else {
            $pattern = '<option value="' . $old_data . '">';
            $replace = '<option value="' . $old_data . '" selected="selected">';
            
			     $file_path = app_path() . '/Helpers/country_state.json';
            if (!file_exists($file_path)) {
                die('Error: JSON file not found at ' . $file_path);
            }

            $file_content = file_get_contents($file_path);
            if ($file_content === false) {
                die('Error: Unable to read JSON file.');
            }

            $state = json_decode($file_content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                die('JSON Error: ' . json_last_error_msg());
            }

            if (!isset($state[$country])) {
                die('Error: Country ' . $country . ' not found in JSON data.');
            }

            $provinces = $state[$country];
            if (empty($provinces)) {
                die('Error: No provinces found for country ' . $country);
            }

            $options = "";
            foreach ($provinces as $province) {
                if (!isset($province['value']) || !isset($province['label'])) {
                    die('Error: Invalid province data structure: ' . print_r($province, true));
                }
                $options .= '<option value="' . htmlspecialchars($province['value']) . '">' . htmlspecialchars($province['label']) . '</option>';
            }

            echo $options;
        }
    }
}

if ( ! function_exists('decimalPlace'))
{

 function decimalPlace($number){
  return number_format((float)$number, 2);
 }

}

if ( ! function_exists('get_fee_select'))
{

 function get_fee_selectbox($class = "", $fee_id = "")
{
    $select = "<select name='chart_id[]' class='form-control $class'>";
    $select .= "<option value='1'>" . _lang('Monthly Rent') . "</option>";

    $fee_types = DB::table("account_detail")->where('account_type', '=', '1')->get();
    $first = true; // Flag to check the first item

    foreach ($fee_types as $fee_type) {
        // If fee_id is empty and it's the first iteration, mark it selected
        $selected = ($fee_id == $fee_type->id || ($fee_id == "" && $first)) ? "selected" : "";
        $select .= "<option value='" . $fee_type->id . "' $selected>" . $fee_type->account_name . "</option>";
        $first = false; // Disable first flag after first iteration
    }

    $select .= "</select>";
    return $select;
}

}

if(! function_exists('get_children')){
	function get_children($menu_name, $link, $icon){
		$parent_id = App\ParentModel::where('user_id', Auth::User()->id)->first()->id;
		$students = App\Student::where('parent_id',$parent_id)->get();
		$student = App\Student::where('parent_id',$parent_id)->first();
		if(count($students) == 1){
			$active = '';
			if(Request::is($link.'/*')){
				$active = 'class="active"';
			}
			return "<li ".$active.">
						<a href='".URL::to('/').'/'.$link.'/'.$student->id."'>
							<i class='".$icon."'></i>
							".$menu_name."
						</a>
					</li>";
		}else{
			$return = '<li><a href="#"><i class="'.$icon.'"></i>'.$menu_name.'</a><ul>';
			foreach ($students AS $student){
				$active = '';
				if(Request::is($link.'/'.$student->id)){
					$active = 'class="active"';
				}
				$return .= "<li ".$active.">
								<a href='".URL::to('/').'/'.$link.'/'.$student->id."'>
									".$student->first_name." ".$student->last_name."
								</a>
							</li>";
			}
			$return .='</ul><li>';

			return $return;
		}
		return '';
	}
}

if ( ! function_exists('count_inbox')){
	function count_inbox() 
	{
		$user_id = \Auth::user()->id;
		$inbox = DB::select("SELECT COUNT(id) as c FROM user_messages 
		WHERE receiver_id='$user_id' AND user_messages.read='n'");
		return $inbox[0]->c;

	}
}

if ( ! function_exists('inbox_items')){
	function inbox_items($limit = 5) 
	{
		$messages = \App\Message::join("user_messages","messages.id","=","user_messages.message_id")
                     ->join("users","messages.sender_id","=","users.id")
					 ->select('messages.*','users.name as sender','user_messages.read')
					 ->where("receiver_id",\Auth::user()->id)
					 ->where("read","n")
					 ->limit($limit)
		             ->orderBy("messages.id","DESC")->get();
					 
		 return $messages;
	}
}

if ( ! function_exists('get_student_id')){
	function get_student_id() 
	{
		$user_id = \Auth::user()->id;
		$student = DB::select("SELECT id FROM students 
		WHERE user_id='$user_id'");
		return $student[0]->id;

	}
}

if ( ! function_exists('get_student_name')){
	function get_student_name($student_id) 
	{
		$student = DB::select("SELECT first_name,last_name FROM students 
		WHERE id='$student_id'");
		return $student[0]->first_name." ".$student[0]->last_name;
	}
}

if ( ! function_exists('get_teacher_id')){
	function get_teacher_id() 
	{
		$user_id = \Auth::user()->id;
		$teacher = DB::select("SELECT id FROM teachers 
		WHERE user_id='$user_id'");
		return $teacher[0]->id;
	}
}

if ( ! function_exists('get_parent_id')){
	function get_parent_id() 
	{
		$user_id = \Auth::user()->id;
		$parent = DB::select("SELECT id FROM parents 
		WHERE user_id='$user_id'");
		return $parent[0]->id;
	}
}

if ( ! function_exists('object_to_string')){
	function object_to_string($object,$col,$quote = false) 
	{
		$string = "";
		foreach($object as $data){
			if($quote == true){
				$string .="'".$data->$col."', ";
			}else{
				$string .=$data->$col.", ";
			}
		}
		$string = substr_replace($string, "", -2);
		return $string;
	}
}

if ( ! function_exists('buildTree')){
	
    function buildTree($object, $currentParent, $url, $currLevel = 0, $prevLevel = -1) {
		 foreach ($object as $category) {
			if ($currentParent == $category->parent_id) {
				if ($currLevel > $prevLevel) echo "<ol id='menutree'>"; 
				if ($currLevel == $prevLevel) echo "</li>";
				echo '<li> <label class="menu_label" for='.$category->id.'><a href="'.action($url, $category->id).'">'.$category->category.'</a></label>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				buildTree ($object, $category->id, $url, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ol>";
	 }
}


if ( ! function_exists('buildOptionTree')){
	
    function buildOptionTree($table, $currentParent, $currLevel = 0, $prevLevel = -1) {

		 $array = DB::table($table)->get();
		 foreach ($array as $category) {
			if ($currentParent == $category->parent_id) {

				$level ="";
				for($i=0; $i<$currLevel; $i++){
					$level .="-";
				}
				echo '<option value='.$category->id.'>'.$level." ".$category->category.'</option>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				buildOptionTree ($table, $category->id, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
	
	 }
}

if ( ! function_exists('navigationTree')){
	
    function navigationTree($object, $currentParent, $url, $currLevel = 0, $prevLevel = -1) {
		 foreach ($object as $menu) {
			if ($currentParent == $menu->parent_id) {
				if ($currLevel > $prevLevel) echo "<ol id='menutree' class='dd-list'>"; 
				if ($currLevel == $prevLevel) echo "</li>";
				//echo '<li class="dd-item" data-id="'.$menu->id.'"> <label class="menu_label" for='.$menu->id.'><a href="'.action($url, $menu->id).'">'.$menu->menu_label.'</a></label>';
				echo '<li class="dd-item" data-id="'.$menu->id.'"><div class="dd-handle">'.$menu->menu_label.'</div><a class="edit_menu" href="'.action($url, $menu->id).'">'._lang('Edit Menu').'</a>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				navigationTree($object, $menu->id, $url, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ol>";
	 }
}


if ( ! function_exists('navigationOptionTree')){
	
    function navigationOptionTree($table, $navigation_id, $currentParent, $currLevel = 0, $prevLevel = -1) {

		 $array = DB::table($table)
		          ->where("navigation_id",$navigation_id)->get();
		 foreach ($array as $category) {
			if ($currentParent == $category->parent_id) {

				$level ="";
				for($i=0; $i<$currLevel; $i++){
					$level .="-";
				}
				echo '<option value='.$category->id.'>'.$level." ".$category->menu_label.'</option>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				navigationOptionTree ($table, $navigation_id, $category->id, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
	
	 }
}


if ( ! function_exists('get_s')){
	function get_s($serialized,$lang) 
	{
		if(!empty($serialized)){
			$array = unserialize($serialized);
			return $array[$lang];
		}
		return "";
	}
}

if ( ! function_exists('theme')){
	function theme() 
	{
		$theme = get_option('active_theme');
		if($theme == ""){
			return "theme/default";
		}
		return "theme/".$theme;
	}
}

if ( ! function_exists('theme_asset_url()')){
	function theme_asset_url($file) 
	{
		$theme = get_option('active_theme');
		if($theme == ""){
			return asset("public/theme/default/$file");
		}
		return asset("public/theme/$theme/$file");
	}
}

if( !function_exists('load_custom_template') ){
	function load_custom_template(){
		$path = resource_path() . "/views/".theme()."/templates";
		if( is_dir($path) ){
			$files = scandir($path);
			$options="";
			foreach($files as $file){
			   $name=pathinfo($file, PATHINFO_FILENAME);
			   if (strpos($name, 'template-') === 0) {   
				   $name = str_replace(".blade","",substr($name,9));
				   $options .= "<option value='$name'>".ucwords($name)."</option>";
			   }			        
			}
			echo $options;
		}
	}
}


if( !function_exists('load_theme') ){
	function load_theme($active=''){
		$path = resource_path() . "/views/theme";
		$files = scandir($path);
		$options="";
		
		foreach($files as $file){
		    $name = pathinfo($file, PATHINFO_FILENAME);
			if($name == "." || $name == ""){
				continue;
			}
			
			$selected = "";
			if($active == $name){
				$selected = "selected";
			}else{
				$selected = "";
			}
			
			$options .= "<option value='$name' $selected>".ucwords($name)."</option>";
		        
		}
		echo $options;
	}
}

if( !function_exists('load_language') ){
	function load_language($active=''){
		$path = resource_path() . "/language";
		$files = scandir($path);
		$options="";
		
		foreach($files as $file){
		    $name = pathinfo($file, PATHINFO_FILENAME);
			if($name == "." || $name == "" || $name == "language"){
				continue;
			}
			
			$selected = "";
			if($active == $name){
				$selected = "selected";
			}else{
				$selected = "";
			}
			
			$options .= "<option value='$name' $selected>".ucwords($name)."</option>";
		        
		}
		echo $options;
	}
}

if( !function_exists('get_language_list') ){
	function get_language_list(){
		$path = resource_path() . "/language";
		$files = scandir($path);
		$array = array();
		
		foreach($files as $file){
		    $name = pathinfo($file, PATHINFO_FILENAME);
			if($name == "." || $name == "" || $name == "language"){
				continue;
			}
	
			$array[] = $name;
		        
		}
		return $array;
	}
}

if ( ! function_exists('get_navigation_id')){
	function get_navigation_id($menu) 
	{
		$nav = DB::table('site_navigations')->where('menu_name', $menu)->get();
	    if ( ! $nav->isEmpty() ) {
		   return $nav[0]->id;
		}
		return 0;

	}
}

if ( ! function_exists('get_page_slug')){
	function get_page_slug($page_id) 
	{
		$page = DB::table('pages')->where('id', $page_id)->get();
	    if ( ! $page->isEmpty() ) {
		   return $page[0]->slug;
		}
		return "/";

	}
}

$shortcodes = array();

if( !function_exists('create_shortcode') ){
	function create_shortcode($shortcode,$callback){
		global $shortcodes;
		$shortcodes[$shortcode] = $callback;
	}
}

if( !function_exists('do_shortcode') ){
	function do_shortcode($shortcode){
		global $shortcodes;
		call_user_func($shortcodes[$shortcode],$atts);
	}
}
if( !function_exists('section_wise_occupied') ){
	function section_wise_occupied($section_id){
		$total_ids = DB::table('student_sessions')
		->where('school_id',schoolId())
		->where('session_id', get_option("academic_year"))
		->where('section_id',$section_id)
		->pluck('student_id')->toArray();
		$total = DB::table('students')
		->whereIn('id', $total_ids)
		->where('school_id',schoolId())
		->where('status',1)
		->count();

		return $total;
	}
}
if( !function_exists('total_student_capacity') ){
	function total_student_capacity(){
		$total = DB::table('sections')
		->where('school_id',schoolId())
		->sum('capacity');
		return $total;
	}
}
if( !function_exists('total_student_occupied') ){
	function total_student_occupied(){

		$total_ids = DB::table('student_sessions')
		->where('school_id',schoolId())
		->where('session_id', get_option("academic_year"))
		->pluck('student_id')->toArray();
		$total = DB::table('students')
		->whereIn('id', $total_ids)
		->where('school_id',schoolId())
		->where('status',1)
		->count();
		return $total;
	}
}
if( !function_exists('total_student_vacant') ){
	function total_student_vacant(){
		return total_student_capacity()-total_student_occupied();
	}
}
if( !function_exists('get_student_class_section') ){
	function get_student_class_section($student_id,$session_id,$field){
		$data = DB::table('student_sessions')
		->where('school_id',schoolId())
		->where('session_id', $session_id)
		->where('student_id',$student_id)->first();
		return $data->$field;
	}
}