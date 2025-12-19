<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>

    <link href="{{ asset('backend') }}/css/bootstrap.min.css" rel="stylesheet" />
    
    <style>
        @page {
            margin: 0px;
            padding: 0px;
        }
        body {
            font-family: Arial, sans-serif;
			font-size: 14px;
        }
        #student_print_div {
            padding: 20px;
            background-color: white;
        }
        .page-break {
            page-break-before: always;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        h2 {
            margin-top: 0;
        }
        .logo img {
            width: 100px;
            height: 100px;
        }
        .student-image img {
            width: 150px;
            height: 150px;
            border: 2px solid grey;
            padding: 10px;
        }
    </style>
</head>
<body>
<button onclick="printStudent();" class="btn btn-primary"><i class="fa fa-print"> </i> Print Student Info</button>
<div id="student_print_div">
    <!-- First Page Content: Student Info -->
    <table>
        <tr>
            <td colspan="2" class="logo">
                <img src="{{ get_logo() }}" style="width:300px;height: 300px;">
            </td>
            <td colspan="2">
                <h2>{{ get_option('address') }}</h2>
            </td>
            <td colspan="2" class="student-image">
                <img src="{{ asset('uploads/images/'.$student->image) }}">
            </td>
        </tr>
    </table>

    <div class="row">
        <table>
            <tbody>
                <tr>
                    <td colspan="2">{{ _lang('Name') }}</td>
                    <td colspan="2">{{ $student->first_name." ".$student->last_name }}</td>
                </tr>
                <tr>
                    <td>{{ _lang('Father Name') }}</td>
                    <td>{{ $student->father_name }}</td>
                    <td>{{ _lang('Date Of Birth') }}</td>
                    <td>{{ $student->birthday }}</td>
                </tr>
                <tr>
                    <td>{{ _lang('Gender') }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ _lang('Blood Group') }}</td>
                    <td>{{ $student->blood_group }}</td>
                </tr>
                <tr>
                    <td>{{ _lang('Floor') }}</td>
                    <td>{{ $student->class_name }}</td>
                    <td>{{ _lang('Room') }}</td>
                    <td>{{ $student->section_name }}</td>
                </tr>
                <tr>
                    <td>{{ _lang('Religion') }}</td>
                    <td>{{ $student->religion }}</td>
                    <td>{{ _lang('Address') }}</td>
                    <td>{{ $data['student']->address }}</td>
                </tr>
                <tr>
                    <td>{{ _lang('Phone') }}</td>
                    <td>{{ $data['student']->phone }}</td>
                    <td>{{ _lang('Email') }}</td>
                    <td>{{ $student->email }}</td>
                </tr>
                <tr>
                    <td>{{ _lang('State') }}</td>
                    <td>{{ $student->state }}</td>
                    <td>{{ _lang('Country') }}</td>
                    <td>{{ $student->country }}</td>
                </tr>
                <tr>
                    <td>{{ _lang('CNIC') }}</td>
                    <td>{{ $student->activities }}</td>
                    <td>{{ _lang('Remarks') }}</td>
                    <td>{{ $student->remarks }}</td>
                </tr>
                <tr>
                    <td colspan="4">I am Agreed on Monthly Rent</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ _lang('Fee Type') }}</th>
                                    <th>{{ _lang('Amount') }}</th>
                                    <th>{{ _lang('Discount') }}</th>
                                    <th>{{ _lang('Total') }}</th>
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
                                    <td class="text-right" colspan="3">{{ _lang('Total') }}</td>
                                    <td>{{ $data['assign_fees']->sum('amount') - $data['assign_fees']->sum('discount') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Page Break before Rules and Regulations Section -->
    <div class="page-break"></div>

    <!-- Rules and Regulations Section (on the next page) -->
   

	<div class="row" id="rules_and_regulations" style="font-size: 10px;">
		<div class="col-md-12">
			<br><br><br><br>
		<p><b>Rules & Regulations: </b></p>
		<h4 style="text-align: justify;"><b>Note: I shall retain the hostel accommodation for the full academic session (i.e.__________/__________/202___-to-__________/__________/202___) and if I want to leave the hostel during the session (6 months/1 year), the hostel management is lawful not to refund my security deposit. Last date for fee submission is 5th of every month; late submission will be charged Rs. 100/= per day. If the late submission penalty is not paid with the fees, it will be adjusted from the deposited security amount respectively.</b></h4>
		<h6 style="text-align: justify;"><b>
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
	
	<div class="row" id="footer" style="font-size: 10px;">
		<div class="col-md-12">
			<table class="" width="100%">
				<tbody>
					<tr>
						<td style="padding:20px;"><b>{{_lang('Place: ')}}</b></td>
						<td style="padding:20px;">{{get_option('address')}}</td>
						<td style="padding:20px;"><b>{{_lang('(Signature)')}}</b></td>
						<td style="padding:20px;">---------------------------------------------</td>
					</tr>
					<tr>
						<td colspan="1" style="padding:20px;"><b>Date: </b></td>
						<td colspan="3" style="padding:20px;">{{ date('Y-m-d') }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>
script type="text/javascript" src="{{ asset('backend') }}/js/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('backend') }}/js/bootstrap.min.js"></script>

<script>

$(document).ready(function() {
	//restriction for the user select any other option
	$('.selection').css('pointer-events','none');
	printStudent();//print document on loading the page
});

//For print the page
function printStudent() {
    var content = $('#student_print_div').html();
    var rulesAndRegs = $('#rules_and_regulations').html(); // Get the rules and regulations content
    var footer = $('#footer').html(); // Get the rules and regulations content
    var newWindow = window.open('', '_blank');
    newWindow.document.write('<html><head><title>Student Info</title><link href="/backend/css/bootstrap.min.css" rel="stylesheet" /></head><body>');
    newWindow.document.write(content);
    newWindow.document.write('<div style="page-break-before: always;"></div>'); // Add a page break
    newWindow.document.write(rulesAndRegs); // Add rules and regulations content
    newWindow.document.write(footer); // Add footer
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
}


</script>