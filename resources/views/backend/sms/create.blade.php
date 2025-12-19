@extends('layouts.backend')
@section('content')
<style>
	a:hover {
		color: #ffffff;
	}
	</style>
<div class="row">
    <form action="{{ url('sms/send') }}" class="validate" autocomplete="off" method="post" accept-charset="utf-8">
		<div class="col-md-8">				
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title" >
						{{ _lang('Compose SMS Text') }}
					</div>
				</div>
				<div class="panel-body">
					@csrf
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('User Type') }}</label>			
							<select name="user_type" id="user_type" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								<option value="Admin">{{ _lang('Admin') }}</option>
								<option value="Student">{{ _lang('Student') }}</option>
								<option value="Parent">{{ _lang('Parent') }}</option>
								<option value="Teacher">{{ _lang('Teacher') }}</option>
								<option value="Accountant">{{ _lang('Accountant') }}</option>
								<option value="Librarian">{{ _lang('Librarian') }}</option>
								<option value="Employee">{{ _lang('Employee') }}</option>
							</select>						
						</div>
					</div>
					
					<div class="col-sm-6 student-group">
					   <div class="form-group">
							<label class="control-label">{{ _lang('Select Floor') }}</label>
							<select name="class_id" onchange="getSection();" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
								<option value="all">{{ _lang('Select All') }}</option>
								{{ create_option('classes','id','class_name',old('class_id')) }}
							</select>
						</div>
					</div>
					
					<div class="col-sm-6 room-group">
					   <div class="form-group">
							<label class="control-label">{{ _lang('Select Room') }}</label>
							<select name="section_id" onchange="get_students();" id="section_id" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
							</select>
						</div>
					</div>		
					
					<div class="col-sm-12 student-group">
					   <div class="form-group">
							<label class="control-label">{{ _lang('Select Student') }}</label>
							<select name="student_id" id="student_id" onchange="get_all_students();" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
								<option value="all">{{_lang('Select All')}}</option>
							</select>
						</div>
					</div>
					
					<div class="col-sm-12 general-group">
					   <div class="form-group">
							<label class="control-label">{{ _lang('Select Receiver') }}</label>
							<select name="user_id" id="user_id" onchange="get_all_users();" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
							</select>
						</div>
					</div>
										
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('Message') }} ( {{ _lang('MAX 300') }} )</label>
							<textarea class="form-control" name="body" required>{{ old('body') }}</textarea>
						</div>
					</div>
										
					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" name="action" value="sms" class="btn btn-primary">{{_lang('Send SMS')}}</button></form>
								<button type="submit" name="action" value="whatsapp" class="btn btn-primary">{{ _lang('Send WhatsApp') }}</button>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">{{ _lang('User List') }}</div>
				<div class="panel-body" id="user_list">    
				</div>
			</div>	
		</div>
	</form>
</div>
@endsection

@section('js-script')
<script  type="text/javascript">

    $(document).on('change','#user_type',function(){
		var user_type = $(this).val();
		
		if( user_type == "Student" ){
			$(".student-group").fadeIn();
			$(".general-group").css("display","none");
			$(".room-group").css("display","none");
			$("#student_id").prop("required",true);
			$("#user_id").prop("required",false);
		}else{
			$(".student-group").css("display","none");
			$(".general-group").fadeIn();
			$(".room-group").css("display","none");
			$("#student_id").prop("required",false);
			$("#user_id").prop("required",true);
			getUsers( user_type );
		}
	});
	
	function getUsers( type ) {
		$.ajax({
			url: "{{ url('users/get_users') }}/"+type,
			beforeSend: function(){
			    $("#preloader").css("display","block");
			},success: function(data){
				$("#preloader").css("display","none");
				var json =JSON.parse(data);
			    $('select[name=user_id]').html("");
				$('#user_list').html(""); 
					   
				jQuery.each( json, function( i, val ) {
					$('select[name=user_id]').append("<option value='"+val['id']+"'>"+val['name']+"</option>");
				});

				if( $('#user_id').has('option').length > 0 ) {
					$('select[name=user_id]').prepend("<option value='all'>All "+type+"</option>");
				}				
			}
		});
	}

	function getSection() {
		if( $('select[name=class_id]').val() == "all" ){
			
			$(".room-group").css("display","none");
			var class_id = $('select[name=class_id]').val() == "all" ;
			var _token=$('input[name=_token]').val();
			$.ajax({
				url: "{{ url('sections/all_section') }}",
				data:{_token:_token,class_id:class_id},				beforeSend: function(){
					$("#preloader").css("display","block");
				},success: function(data){
					$("#preloader").css("display","none");
					$('select[name=section_id]').html(data);
					
									
				}
			});
		}
		else if( $('select[name=class_id]').val() != "" ){
			$(".room-group").css("display","block");
			console.log('jifjods');
			var _token=$('input[name=_token]').val();
			var class_id=$('select[name=class_id]').val();
			$.ajax({
				type: "POST",
				url: "{{ url('sections/section') }}",
				data:{_token:_token,class_id:class_id},
				beforeSend: function(){
					$("#preloader").css("display","block");
				},success: function(data){
					$("#preloader").css("display","none");
					$('select[name=section_id]').html(data);				
				}
			});
		} 
	}
	
	
	function get_students(){
    	if( $("#user_type").val() == "Student" && $('select[name=section_id]').val() =="all" && $('select[name=class_id]').val() == "all"){	
			var class_id = "/"+$('select[name=class_id]').val();
			var section_id = "/"+$('select[name=section_id]').val();
			var link = "{{ url('students/get_all_students') }}";
			$.ajax({
				url: link,
				beforeSend: function(){
					$("#preloader").css("display","block");
				},success: function(data){
					$("#preloader").css("display","none");
					var json =JSON.parse(data);
					   $('select[name=student_id]').html("");
					   $('#user_list').html(""); 
					   
					jQuery.each( json, function( i, val ) {
					   $('select[name=student_id]').append("<option value='"+val['id']+"'>"+val['roll']+" - "+val['first_name']+" "+val['last_name']+"</option>");
					});

					if( $('#student_id').has('option').length > 0 ) {
						$('select[name=student_id]').prepend("<option value='all'>{{ _lang('All Student') }}</option>");
					}				
				}
			});
		}
		else if( $("#user_type").val() == "Student" && $('select[name=section_id]').val() !=""){	
			var class_id = "/"+$('select[name=class_id]').val();
			var section_id = "/"+$('select[name=section_id]').val();
			var link = "{{ url('students/get_students') }}"+class_id+section_id;
			$.ajax({
				url: link,
				beforeSend: function(){
					$("#preloader").css("display","block");
				},success: function(data){
					$("#preloader").css("display","none");
					var json =JSON.parse(data);
					   $('select[name=student_id]').html("");
					   $('#user_list').html(""); 
					   
					jQuery.each( json, function( i, val ) {
					   $('select[name=student_id]').append("<option value='"+val['id']+"'>"+val['roll']+" - "+val['first_name']+" "+val['last_name']+"</option>");
					});

					if( $('#student_id').has('option').length > 0 ) {
						$('select[name=student_id]').prepend("<option value='all'>{{ _lang('All Student') }}</option>");
					}				
				}
			});
		}	
	}
	
	function get_all_students(){
		if($("#student_id").val() == "all" && $('select[name=class_id]').val() == "" &&  $('select[name=section_id]').val() == "" ){		
			var class_id = "/"+$('select[name=class_id]').val();
			var section_id = "/"+$('select[name=section_id]').val();
			var link = "{{ url('students/get_all_students') }}";
			$.ajax({
				url: link,
				beforeSend: function(){
					$("#preloader").css("display","block");
				},success: function(data){
					$("#preloader").css("display","none");
					var json =JSON.parse(data);
					$('#user_list').html(""); 
					
					jQuery.each( json, function( i, val ) {
					   $('#user_list')
					   .append('<div class="col-md-12">'+
									'<label class="c-container">'+
									   '<input type="checkbox" value="'+val['id']+'" name="students[]" checked="true">'+val['roll']+" - "+val['first_name']+" "+val['last_name']+
									   '<span class="checkmark"></span>'+
									'</label>'+
								'</div>');
					});
	
				}
			});
		}
		
		else if($("#student_id").val() == "all"  && $('select[name=class_id]').val() != "" &&  $('select[name=section_id]').val() != ""){		
			var class_id = "/"+$('select[name=class_id]').val();
			var section_id = "/"+$('select[name=section_id]').val();
			var link = "{{ url('students/get_students') }}"+class_id+section_id;
			$.ajax({
				url: link,
				beforeSend: function(){
					$("#preloader").css("display","block");
				},success: function(data){
				
					$("#preloader").css("display","none");
					var json =JSON.parse(data);
					$('#user_list').html(""); 
					
					jQuery.each( json, function( i, val ) {
					   $('#user_list')
					   .append('<div class="col-md-12">'+
									'<label class="c-container">'+
									   '<input type="checkbox" value="'+val['id']+'" name="students[]" checked="true">'+val['roll']+" - "+val['first_name']+" "+val['last_name']+
									   '<span class="checkmark"></span>'+
									'</label>'+
								'</div>');
					});
	
				}
			});
		}
		else{
		  $('#user_list').html("");
		}
	}
	
	function get_all_users(){
		if($("#user_id").val() == "all"){		
			var user_type = "/"+$('select[name=user_type]').val();
			var link = "{{ url('users/get_users') }}"+user_type;
			$.ajax({
				url: link,
				beforeSend: function(){
					$("#preloader").css("display","block");
				},success: function(data){
					$("#preloader").css("display","none");
					var json =JSON.parse(data);
					$('#user_list').html(""); 
					
					jQuery.each( json, function( i, val ) {
					   $('#user_list')
					   .append('<div class="col-md-12">'+
									'<label class="c-container">'+
									   '<input type="checkbox" value="'+val['id']+'" name="users[]" checked="true">'+val['name']+
									   '<span class="checkmark"></span>'+
									'</label>'+
								'</div>');
					});
	
				}
			});
		}else{
		  $('#user_list').html("");
		}
	}
			
</script>
@stop

