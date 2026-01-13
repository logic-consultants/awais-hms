<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets')}}/images/fav.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets')}}/images/fav.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ get_school_name()}}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('backend') }}/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Datatable core CSS     -->
    <link href="{{ asset('backend') }}/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <!-- Animation library for notifications   -->
    <link href="{{ asset('backend') }}/css/animate.min.css" rel="stylesheet"/>
	<!-- bootstrap-datepicker library -->
    <link href="{{ asset('backend') }}/css/bootstrap-datepicker.css" rel="stylesheet"/>
	<!-- Select 2 library -->
    <link href="{{ asset('backend') }}/css/select2.css" rel="stylesheet"/>
	<!-- Dropify library -->
    <link href="{{ asset('backend') }}/css/dropify.min.css" rel="stylesheet"/>
    <!--  Quill editor    -->
    <link href="{{ asset('backend') }}/css/summernote.css" rel="stylesheet"/>
    <!--  Fonts and icons     -->
    <link href="{{ asset('backend') }}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/fonts.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/themify-icons.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/toastr.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/nice-select.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/animate.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/fullcalendar.min.css" rel="stylesheet">
	<link href="{{ asset('backend') }}/css/metisMenu.min.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<!--  Style CSS -->
    <link href="{{ asset('backend') }}/css/style.css" rel="stylesheet" />
    
	@if(get_option('backend_direction') == "rtl")
	<link href="{{ asset('backend') }}/css/RTL.css" rel="stylesheet" />
	@endif
	<script type="text/javascript">
	   var direction = "{{ get_option('backend_direction') }}";
	</script>
	
	@include('layouts.css.dynamic_css')

	 
	<style>
    @media print {
        /* Ensure the logo column is visible */
        .group_name img {
            display: block !important;
            width: 100px !important;
            height: auto !important;
            visibility: visible !important;
        }
        
        /* Optional: Hide the Action column during print */
        table th:last-child, 
        table td:last-child {
            display: none !important;
        }
    }
</style>
	<!-- CSS -->
	@yield('css-script')
</head>
<body>
    <!-- Main Modal -->
	<div id="main_modal" class="modal animated bounceInDown" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title"></h5>
		  </div>  
		  <div class="alert alert-danger" style="display:none; margin: 15px;"></div>
		  <div class="alert alert-success" style="display:none; margin: 15px;"></div>			  
		  <div class="modal-body" style="overflow:hidden;"></div>
		  <div class="model-footer">
			<button type="button" class="modal-btn btn btn-danger btn-sm foter-model" data-dismiss="modal"><i class="glyphicon glyphicon-remove-circle"></i> {{ _lang('Exit') }}</button>
			<button type="button" id="modal-fullscreen" class="modal-btn btn btn-primary btn-sm foter-model"><i class="glyphicon glyphicon-fullscreen"></i> {{ _lang('Full Screen') }}</button>
			
		  </div>
		</div>

	  </div>
	</div>
	
	<div id="preloader">
		<div class="bar"></div>
	</div>
	
    <div class="wrapper animated fadeIn">
        <div class="sidebar" data-background-color="white" data-active-color="danger">
			<div class="sidebar-wrapper">
				<div class="logo" style="padding: 0px;margin: 0px;">
					<a href="{{url('/dashboard')}}" class="simple-text">
					<!-- {{ get_option('school_name')}} -->
						<img src="{{get_logo()}}" alt="Logo" style="display: block;max-height: 66px;width: auto;margin: auto;">
					</a>
				</div>						

				@include('layouts.menus.'.Auth::user()->user_type)
				
			</div>
		</div>
		<div class="main-panel">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle mobile-nav">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar bar1"></span>
							<span class="icon-bar bar2"></span>
							<span class="icon-bar bar3"></span>
						</button>
						<a class="navbar-brand" href="#">{{ get_option('school_name')}}</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
						
							@if(Auth::user()->user_type == 'Admin')
							<li>
								<select class="select_class" onchange="changeSession(this);" style="margin-top: 22px;">
								  @foreach(get_table('academic_years') as $session)
									  <option value="{{ $session->id }}" {{ $session->id==get_option('academic_year') ? "selected" : "" }}>{{ $session->session }}</option>
								  @endforeach
								</select>
							</li>
							@endif
							
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<p class="notification">{!! count_inbox() > 0 ? '<span class="notification-count">'.count_inbox().'</span>' : "" !!}</p>
									<p>{{ _lang('Message') }}</p>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu notification-items">
								    @foreach(inbox_items() as $message)
										<li><a class="ajax-modal" href="{{ url('message/inbox/'.$message->id) }}">{{ $message->subject }}</a></li>
									@endforeach
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ti-user"></i>
									<p>{{ _lang('Hi').", ".Auth::user()->name }}</p>
									<b class="caret"></b>
								</a>
									<ul class="dropdown-menu">
										<li><a href="{{ url('profile/my_profile')}}" data-title="{{ _lang('Profile') }}">{{ _lang('Profile') }}</a></li>
										<li><a href="{{ url('profile/edit')}}" data-title="{{ _lang('Edit Profile') }}">{{ _lang('Update Profile') }}</a></li>
										<li><a href="{{ url('profile/changepassword') }}" data-title="{{ _lang('Change Password') }}">{{ _lang('Change Password') }}</a></li>
										<li>
											<a class="dropdown-item" href="{{ route('logout') }}"
											onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">
											{{ __('Logout') }}
										</a>
									</li>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</ul>
							</li>
						</ul>
				</div>
			</div>
		</nav>
		<div class="content">
		   <div class="container-fluid">
		       
				<!--
				<ol class="breadcrumb">
					<li><a href="{{ url('dashboard') }}"><i class="ti-home"></i> {{ _lang('Dashboard') }}</a></li>
					@php $segments = ''; @endphp
					@foreach(Request::segments() as $segment)
					    @if ($segment == "dashboard")
							@php continue; @endphp
						@endif
						@php $segments .= '/'.$segment; @endphp
						<li>
							<a href="{{ url($segments) }}">{{ ucwords(str_replace("_"," ",$segment)) }}</a>
						</li>
					@endforeach
				</ol>
				-->
			  
			   @yield('content')
		   </div>
	   </div>   
	</div>
	
  </div>
</body>
<!--   Core JS Files   -->
<!-- Load jQuery from CDN first, fallback to local copy if CDN fails -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
if (!window.jQuery) {
    var s = document.createElement('script');
    s.src = "{{ asset('backend/js/jquery.min.js') }}";
    document.head.appendChild(s);
}
</script>

<script type="text/javascript" src="{{ asset('backend/js/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('backend/js/maskedinput.js') }}"></script>
<!--  Charts Plugin -->
<script type="text/javascript" src="{{ asset('backend/js/echarts.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script type="text/javascript" src="{{ asset('backend/js/bootstrap-notify.js') }}"></script>
<!--  DataTable Plugin    -->
<script type="text/javascript" src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
<!--  Select 2 Plugin    -->
<script type="text/javascript" src="{{ asset('backend/js/select2.min.js') }}"></script>
<!--  jQuery Validation   -->
<script type="text/javascript" src="{{ asset('backend/js/jquery.validate.min.js') }}"></script>
<!--  Bootstrap Datepicker  -->
<script type="text/javascript" src="{{ asset('backend/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/js/jquery.mask.min.js') }}"></script>
<!--  Summernote editor    -->
<script type="text/javascript" src="{{ asset('backend/js/summernote.js') }}"></script>
<!--  Dropify  -->
<script type="text/javascript" src="{{ asset('backend/js/dropify.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/js/toastr.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/js/jquery.nice-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/js/print.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/js/jquery.nestable.js') }}"></script>

<script src="{{ asset('backend/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap-datetimepicker.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('backend/js/fullcalendar.min.js') }}"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script type="text/javascript" src="{{ asset('backend/js/script.js') }}"></script>
<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script type="text/javascript" src="{{ asset('backend/js/dashboard.js') }}"></script>

<!-- JS -->
@yield('js-script')

<script type="text/javascript">
$(document).ready(function(){  

     @if(Request::is('dashboard') && \Auth::user()->user_type == 'Admin')
         dashboard.admin_init();
	 @elseif(Request::is('dashboard') && \Auth::user()->user_type == 'Accountant')
	     dashboard.accountant_init();
	 @elseif( ! Request::is('dashboard'))
	    $(".navbar-brand").html($(".title").html()); 
	    $(".navbar-brand").html($(".panel-title").html());
		$("#last_link").html($(".navbar-brand").html());
     @endif

    $(".data-table").DataTable({
		responsive: true,
		"bAutoWidth":false,
		"ordering": false,
		"pageLength": 50,
		"language": {
		   "decimal":        "",
		   "emptyTable":     "{{ _lang('No Data Found') }}",
		   "info":           "{{ _lang('Showing') }} _START_ {{ _lang('to') }} _END_ {{ _lang('of') }} _TOTAL_ {{ _lang('Entries') }}",
		   "infoEmpty":      "{{ _lang('Showing 0 To 0 Of 0 Entries') }}",
		   "infoFiltered":   "(filtered from _MAX_ total entries)",
		//    "infoPostFix":    "",
		   "thousands":      ",",
		   "lengthMenu":     "{{ _lang('Show') }} _MENU_ {{ _lang('Entries') }}",
		   "loadingRecords": "{{ _lang('Loading...') }}",
		   "processing":     "{{ _lang('Processing...') }}",
		   "search":         "{{ _lang('Search') }}",
		   "zeroRecords":    "{{ _lang('No matching records found') }}",
		   "paginate": {
			  "first":      "{{ _lang('First') }}",
			  "last":       "{{ _lang('Last') }}",
			  "next":       "{{ _lang('Next') }}",
			  "previous":   "{{ _lang('Previous') }}"
		  },
		  "aria": {
			  "sortAscending":  ": activate to sort column ascending",
			  "sortDescending": ": activate to sort column descending"
		  }
	  },
	  dom: '<"row"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>rtip',
	  buttons: [
	  'copy', 'csv', 'excel', 'pdf', {
		  extend: 'print',
		  title: '{{ get_option("school_name") }}',
		  exportOptions: {
			  stripHtml: false
		  },
		  customize: function ( win ) {
			  $(win.document.body).find('table img').css("width","100px");
			  $(win.document.body).find('h1').css('text-align','center');
		  }
	  }
	  ],
    });

	//Show Success Message
	@if(Session::has('success'))
	   Command: toastr["success"]("{{session('success')}}")
	@endif
	
	//Show Single Error Message
	@if(Session::has('error'))
	   Command: toastr["error"]("{{session('error')}}")
	@endif
    $('[data-toggle="tooltip"]').tooltip();


	
	<?php $i =0; ?>

	@if ($errors->any())
        @foreach ($errors->getMessages() as $key => $messages)
            @foreach ($messages as $error)
                Command: toastr["error"]("{{ $error }}");
                
                var name = "{{ $key }}";
                $("input[name='"+name+"']").addClass('error');
                $("select[name='"+name+"'] + span").addClass('error');
                
                // Only append if it doesn't already exist to avoid duplicates
                if($("input[name='"+name+"']").parent().find('.v-error').length == 0){
                    $("input[name='"+name+"'], select[name='"+name+"']").parent().append("<span class='v-error'>{{$error}}</span>");
                }
            @endforeach
        @endforeach
    @endif

});

function changeSession(elem){
	if($(elem).val() == ""){
		return;
	}
	window.location = "<?php echo url('administration/change_session') ?>/"+$(elem).val();
}

$("#menu li").each(function(){
	var elem = $(this);
	if($(elem).has("ul").length>0){
		if($(elem).find("ul").has("li").length === 0){
			$(elem).remove();
		}		
	}
});


if($(".notification-items").has("li").length === 0){
	$(".notification-items").append("<li><a href='#'>No Message Found !</a></li>");
}


</script>
</html>