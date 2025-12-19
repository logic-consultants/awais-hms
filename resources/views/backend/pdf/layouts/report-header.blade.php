<header class="clearfix">
    <div class="header-company-info-sell-invoice">
        <div class="row">
        	<div class="col-md-2" style="text-align: left;">
        		<img src="{{ get_logo() }}" style="width:50px;"><br><br>
                <div style="font-size: 14px;">{{$title}}</div>
        	</div>
        	<div class="col-md-6">
        		<h2 class="name">{{ get_option("school_name") }}</h2>
        		<div>{{get_option('address')}}</div>
        	</div>
        	<div class="col-md-4">
        		<table>
                    @if(!empty($session))
        			<tr>
        				<th style="text-align: right;border:none;padding: 3px;"><b>Session:</b></th>
        				<td style="text-align: left;border:none;padding: 3px;">{{$session->session}}</td>
        			</tr>
                    @endif
                    @if(!empty($class))
                    <tr>
                        <th style="text-align: right;border:none;padding: 3px;"><b>Floor:</b></th>
                        <td style="text-align: left;border:none;padding: 3px;">{{$class=='All'?'All':$class->class_name}}</td>
                    </tr>
                    @endif
                    @if(!empty($section))
                    <tr>
                        <th style="text-align: right;border:none;padding: 3px;"><b>Room:</b></th>
                        <td style="text-align: left;border:none;padding: 3px;">{{$section=='All'?'All':$section->section_name}}</td>
                    </tr>
                    @endif
                    @if(!empty($date_from))
                    <tr>
                        <th style="text-align: right;border:none;padding: 3px;"><b>From Date:</b></th>
                        <td style="text-align: left;border:none;padding: 3px;">{{date('d-M-Y',strtotime($date_from))}}</td>
                    </tr>
                    @endif
                    @if(!empty($date_to))
                    <tr>
                        <th style="text-align: right;border:none;padding: 3px;"><b>To Date:</b></th>
                        <td style="text-align: left;border:none;padding: 3px;">{{date('d-M-Y',strtotime($date_to))}}</td>
                    </tr>
                    @endif
        		</table>
        	</div>
        </div>
    </div>
</header>
