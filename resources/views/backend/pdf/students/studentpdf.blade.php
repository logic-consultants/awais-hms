<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>

    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet" />
    
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .student_print_div {
            padding: 20px;
            background-color: #ffffff;
            /* border: 1px solid #e78421; */
        }
        .page-break {
            page-break-before: always;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .upper-border{
            width: 85%;
            height:30px;
            margin-bottom:70px;
            float:right;
            background: #e78421;
        }
        .side-border{
            padding-left:20px;
            width: 150px;
            height:20px;
            background: #e78421;
        }
        /* tbody, tr{
            height:60px;
        } */
        th, td {
            padding: 10px;
            /* border: 1px solid #ddd; */
            text-align: left;
        }
        th, .size{
            font-size:15px;
        }
        .size{
            font-size:15px;
        }
         .logo{
            width:150px;
         }
        .logo img {
            max-width: 110px;
            height: auto;
        }
        .logo h3{
            color: #e78421;
            /* max-width:400px; */

        }
        .student-image img {
            width: 120px;
            height: auto;
            border: 2px solid #ccc;
            padding: 5px;
            margin-top:20px;
            border-radius: 5px;
        }
        .heading{
            width:340px;
        }
        .heading h1{
            /* text-align:left; */
            /* margin-top:50px; */
            color: #e78421;
            font-weight: 700;
            font-style:italic;
            font-family:system-ui;

        }
        span{
            color: #e78421;
        }
        .rules-list li {
            margin-bottom: 10px;
        }
        .triangle-up { width: 0;
    height: 0;
    border-top: 70px solid transparent;
    border-bottom: 100px solid transparent;
    margin-bottom:-78px;
    border-left: 100px solid #e78421; /* Triangle color */
  }
  .graph-div {
    width: 180px;
    height: 30px;
    z-index: 99;
    /* margin-right: 33px; */
    background: #e78421;
    transform: skewY(-47deg);
    margin-top: 96px;
    margin-left: -68px;
  }
    </style>
</head>
<body>
    <div float="right">
<div class="triangle-up"></div>
    <div class="upper-border">
    </div>
    <div class="graph-div">
</div>
</div>
<div class="student_print_div">
    <div class="border-color">
        
    <table>
        <tr>
            <td>
            <div class="logo">
                <img src="{{ $data['logo'] }}">
                <h3>{{get_option('address')}}</h3>
            </div>
            </td>
            <td>
            <div class="heading">
                <h1>{{ _lang('The Imperial Boys Hostel') }}</h1>
            </div>
            </td>
            <td>
            <div class="student-image">
                <img src="{{$data['images'] }}">
            </div>
            </td>
        </tr>
    </table>
        <table>
            <thead>
                <th>
                <b><p style="font-size:20px; color:#e78421">Personal Information</p>
                </b>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><b class="size">{{ _lang('Name') }}</b></td>
                    <td colspan="4">{{ $student->first_name . " " . $student->last_name }}</td>
                </tr>
                <tr>
                <td colspan="2"><b class="size">{{ _lang('Father Name') }}</b></td>
                <td colspan="4">{{ $student->father_name }}</td>
                </tr>
                <tr>
                    
						<td colspan="2"><b class="size">{{_lang('CNIC')}}<b></td>
						<td colspan="4">{{$student->activities}}</td>
                </tr>
                <tr>
                    <td><b class="size">{{ _lang('Date Of Birth') }}</b></td>
                    <td>{{ $student->birthday }}</td>
                    <td><b class="size">{{ _lang('Phone') }}</b></td>
                    <td>{{ $student->phone }}</td>
                </tr>
                <tr>
                    <td><b class="size">{{ _lang('Gender') }}</b></td>
                    <td>{{ $student->gender }}</td>
                    <td><b class="size">{{ _lang('Blood Group') }}</b></td>
                    <td>{{ $student->blood_group }}</td>
                </tr>
                <tr>
						<td><b class="size">{{_lang('State')}}<b></td>
						<td>{{$student->state}}</td>
						<td><b class="size">{{_lang('Country')}}<b></td>
						<td>{{$student->country}}</td>
					</tr>
					<tr><td><b class="size">{{ _lang('Email') }}</b></td>
                    <td>{{ $student->email }}</td>
						<td><b class="size">{{_lang('Remarks')}}<b></td>
						<td>{{$student->remarks}}</td>
					</tr>
                    
                <tr>
                    <td><b class="size">{{_lang('Religion')}}</b></td>
                    <td>{{$student->religion}}</td>
                    <td><b class="size">{{_lang('Address')}}</b></td>
                    <td>{{$data['student']->address}}</td>
                    
                 </tr>
                
            </tbody>
        </table>

    </div>
  
        <h3 style="color: #e78421"><b>I am Agreed on Monthly Rent</b></h3>
    <br>
    <table>
        <thead>
            <tr>
                <th classs="size">{{ _lang('Fee Type') }}</th>
                <th classs="size">{{ _lang('Amount') }}</th>
                <th classs="size">{{ _lang('Discount') }}</th>
                <th classs="size">{{ _lang('Total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['assign_fees'] as $item)
            <tr>
                <td>{!! get_fee_selectbox('selection', $item->fee_id) !!}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ $item->discount }}</td>
                <td>{{ $item->amount - $item->discount }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><b>{{ _lang('Total') }}</b></td>
                <td>{{ $data['assign_fees']->sum('amount') - $data['assign_fees']->sum('discount') }}</td>
            </tr>
        </tfoot>
    </table>
    </div>
    </div>
    <div class="page-break"></div>
     <div float="right">
<div class="triangle-up"></div>
    <div class="upper-border">
    </div>
    <div class="graph-div">
</div>
</div>
    <div class="student_print_div">
    <div class="border-color">
    <div class="row" id="rules_list" style="font-size: 16px;">
		<div class="col-md-12">
		<h3 style="color: #e78421"><b>Rules & Regulations: </b></h3>
		<h4 style="text-align: justify;"><b>Note: I shall retain the hostel accommodation for the full academic session (i.e.<span>__________</span>/<span>__________</span>/202<span>___</span>-to-<span>__________</span>/<span>__________</span>/202<span>___</span>) and if I want to leave the hostel during the session (6 months/1 year), the hostel management is lawful not to refund my security deposit. Last date for fee submission is 5th of every month; late submission will be charged Rs. 100/= per day. If the late submission penalty is not paid with the fees, it will be adjusted from the deposited security amount respectively.</b></h4>
		<h6 style="text-align: justify; margin-top:20px;"><b>
			<ol>
				<li>I shall not be entitled to claim my admission in the hostel as a matter of right,</li>
				<li>I shalt not possess, use of deal with any kind of intoxicating material including alcohol, any kinds of drugs, gutka, tobacco cigarettes or any other such materials and on being found guilty, the management may take the disciplinary action (s) including restriction/force expulsion from hostel immediately without any prior notice.</li>
				<li>I shall not possess or used of any kind of weapon including sticks, rods, explosive, fireworks or any related object (s) /material and on being found guilty the management may take a disciplinary action (s) including restriction/ force expulsion from hostel immediately without any prior notice.</li>
				<li>I shall be solely/mutually (in case of room sharing) liable for any damage to the hostel property caused by my will or negligence and will be entitled to pay or else disciplinary actions will be taking accordingly.</li>
				<li>I solemnly affirm that I have not tendency and shall not make any attempt to commit. Suicide or beating or enticing any other person commit suicide or an thing unwarranted and or prohibited by the law or otherwise and shall not giving any sort of threats to commit suicide or likewise and being found guilty for the aforesaid action. I myself shall be responsible for any consequences, under law of land and expulsion/ rustication from the hostel and any other legal action under law of land Management will not be responsible for any of such action.</li>
				<li>I shall not keep any excess cash and valuable (Including smart phones, PCs, Laptop and etc.) within Hostel in case of any loss theft or damaged or any other personal belonging the management shall not be responsible of compensation.</li>
				<li>I fully understand that parking of vehicles (if allowed) is at on my own risk and in case of damaged or theft that management shall not be responsible of compensation.</li>
				<li>I shall not collect any money from any student, employees or other person in hostel premises for any purpose including donations, charity etc. Without written permission of hostel management.</li>
				<li>The management has the full authority for the inspections of the room (s), Bags, Cupboard or any of other belonging at any time (as and when deem ultimate requirement).</li>
				<li>I understand that the hostel allotted at the time of admission may be shifted to other branch at any time (if there is required for adjustment of seats).</li>
				<li>I shall not allow accompany any unauthorized person to enter or stay in room without prior permission however, night stay of friends is not allowed in any case.</li>
				<li>I shall not misuse electricity by using gadgets like iron, heaters, juicers etc. in case of caught for using these gadgets the management may impose penalty as per offense.</li>
				<li>All the type of charges and fees as charged by the management are subject to review at any time. However an annual escalation will be charged as per property law enforced in city.</li>
				<li>For any unforeseen issues arisen that is not covered by this undertaking or in respect of all the matters not expressly provided herein, the management may take any appropriate decision that shall be final and binding in me and all others concerned.</li>
				<li>I understand that the food will be served in time. Late comers will be entertained only if food is available after scheduled time.</li>
				<li>I am given this undertaking with full understanding and state that the information given above are true and complete to the best of my knowledge and belief and certificates documents and other information submitted by me are genuine and nothing has been concealed. I understand that any of statement made above is found incorrect. I shall liable to a disciplinary action(s) and penalty on me as decided by the management, notwithstanding legal action under the law of land .in such case, the hostel fee and other charges deposited by be shall be fortified.</li>
				<li>The management reserved the right to frame, amend, revoke or repeal the provisions including hostel timing that will be effective and binding in all the concerned by the management from time-to-time.</li>
				<li>The management reserves the rights to modify the rules and regulation as deem appropriate.</li>
			</ol></b>
		</p>
		</div>
	</div>

    <table>
        <tr>
            <td><b>Place:</b></td>
            <td>{{ get_option('address') }}</td>
            <td><b>Signature:</b></td>
            <td><span>_________________________</span></td>
        </tr>
        <tr>
            <td><b>Date:</b></td>
            <td colspan="3">{{ date('Y-m-d') }}</td>
        </tr>
    </table>
    </div>
</div>
</body>
</html>
