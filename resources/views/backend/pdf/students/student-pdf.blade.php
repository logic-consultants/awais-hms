<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet" />

    <style>
        @page {
            margin: 0px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .student_print_div {
            background-color: #ffffff;
        }

        .page-break {
            page-break-before: always;
        }

        .body-shape1 img {
            width: 100%;
            height: 180px;
        }

        .body-shape2 img {
            width: 100%;
            height: 100px;
            position: fixed;
            bottom: 0;
            left: 0;
        }

        .header-logo img {
            margin-top: -10px;
            margin-left: 80px;
            height: 300px;
            width: 300px;
        }

        .student-image img {
            float: right;
            height: 100px;
            width: 130px;
            border-color:2px solid grey;
            margin-top: -140px;
            /*transform: rotate(90deg);*/
            margin-right: 80px;
        }

        .student-address p {
            float: right;
            font-size: 16px;
            margin-top: -45px;
            margin-right: 25px;
            color: #ffffff;
        }

        .hostel-name p {
            text-align: center;
            font-size: 25px;
            margin-top: -160px;
            color: #ffffff;
            font-style: italic;
            font-weight: 700;
        }

        .student-details {
            padding: 20px;
            margin-top: 190px;
        }

        .heading p {
            font-size: 25px;
            margin-left: 40px;
            font-weight: 700;
            margin-top: -180px;
        }

        .profile img {
            height: 100px;
            width: 130px;
            margin-left: 40px;
            margin-top: -90px;
        }

        .details,
        span {
            text-align: justify;
            font-size: 14px;
            padding-left: 40px;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            padding: 10px 48px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th,
        .size {
            font-size: 15px;
        }

        .size {
            font-size: 15px;
        }

        #rules-list li {
            margin-bottom: 10px;
            color: #333333;
        }
    </style>
</head>

<body>
    <?php //dd($data['student']); ?>
    <div class="student_print_div">
        <div class="body-shape1">
            @php
                $headerPath = public_path('uploads/HeaderLine.png');
                $headerImage = file_exists($headerPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($headerPath)) : '';
            @endphp
            <img src="{{ $headerImage }}" alt="Header Line">
        </div>

        <div class="student-image">
            <header class="th-header header-layout2">
                <div class="row align-items-center justify-content-end">
                    <div class="col-auto">
                        <div class="header-logo">
                            @php
                                $logoFilename = get_option('logo') ?: '1556705924_1.png';
                                $logoPath = public_path('uploads/'.$logoFilename);
                                $logoImg = file_exists($logoPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath)) : '';
                            @endphp
                            <img src="{{ $logoImg }}" alt="Invar">
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <div class="hostel-name">
            <p><b>Bait-ul-Hareem Girls Hostel</b></p>
        </div>

        <div class="student-details">
            <div class="heading">
                <p>Personal Information</p>
            </div>
            <div class="profile">
                @php
                    $studentImgPath = public_path('uploads/images/'.$student->image);
                    $studentImg = (!empty($student->image) && file_exists($studentImgPath)) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($studentImgPath)) : '';
                @endphp
                <img src="{{ $studentImg }}" alt="Student Image">
            </div>

            <div style="display: table; width: 100%; font-family: Arial, sans-serif; font-size:15px; padding:5px 25px;">
                <div style="display: table-row;">
                    <div style="display: table-cell; padding:15px 5px;"><strong>{{ _lang('Student Name') }}</strong></div>
                    <div style="display: table-cell; padding:15px 5px;">{{ $student->first_name }} {{ $student->last_name }}</div>
                    <div style="display: table-cell; font-weight: bold; padding:15px 5px;"><strong>{{ _lang('Father Name') }}</strong></div>
                    <div style="display: table-cell; padding:15px 5px;">{{ $student->father_name }}</div>
                </div>

                <div style="display: table-row;">
                    <div style="display: table-cell; font-weight: bold; padding:15px  5px;"><strong>{{ _lang('Date Of Birth') }}</strong></div>
                    <div style="display: table-cell; padding:15px  5px;">{{ $student->birthday }}</div>
                    <div style="display: table-cell; font-weight: bold; padding:10px  5px;"><strong>{{ _lang('Address') }}</strong></div>
                    <div style="display: table-cell; padding:10px  5px;">{{ $data['student']->address }}</div>
                </div>

                <div style="display: table-row;">
                    <div style="display: table-cell; padding:10px 5px;"><strong>{{ _lang('Phone') }}</strong></div>
                    <div style="display: table-cell; padding:10px  5px;">{{ $data['student']->phone }}</div>
                    <div style="display: table-cell; padding:10px 5px;"><strong>{{ _lang('Email') }}</strong></div>
                    <div style="display: table-cell; padding: 10px 5px;">{{ $student->email }}</div>
                </div>

                <div style="display: table-row;">
                    <div style="display: table-cell; font-weight: bold; padding: 10px 5px;"><strong>{{ _lang('State') }}</strong></div>
                    <div style="display: table-cell; padding: 10px 5px;">{{$student->state}}</div>
                    <div style="display: table-cell; font-weight: bold; padding: 10px 5px;"><strong>{{ _lang('Country') }}</strong></div>
                    <div style="display: table-cell; padding: 10px 5px;">{{ $student->country }}</div>
                </div>

                <div style="display: table-row;">
                    <div style="display: table-cell; padding:10px 5px;"><strong>{{ _lang('Religion') }}</strong></div>
                    <div style="display: table-cell; padding: 10px 5px;">{{ $student->religion }}</div>
                    <div style="display: table-cell; font-weight: bold; padding: 10px 5px;"><strong>{{ _lang('Remarks') }}</strong></div>
                    <div style="display: table-cell; padding: 10px 5px;">{{ $student->remarks }}</div>
                </div>

                <div style="display: table-row;">
                    <div style="display: table-cell; padding:10px 5px;"><strong>{{ _lang('Blood Group') }}</strong></div>
                    <div style="display: table-cell; padding:10px  5px;">{{ $student->blood_group }}</div>
                    <div style="display: table-cell; font-weight: bold; padding: 10px 10px 5px;"><strong>{{ _lang('Gender') }}</strong></div>
                    <div style="display: table-cell; padding: 5px;">{{ $student->gender }}</div>
                </div>

                <div style="display: table-row;">
                    <div style="display: table-cell; font-weight: bold; padding: 10px 5px;"><strong>{{ _lang('CNIC') }}</strong></div>
                    <div style="display: table-cell; padding: 10px 5px;">{{ $student->activities }}</div>
                </div>
            </div>
        </div>

        <h3 style="margin-left:50px"><b>I am Agreed on Monthly Rent</b></h3>
        <table>
            <thead>
                <tr>
                    <th class="size">{{ _lang('Fee Type') }}</th>
                    <th class="size">{{ _lang('Amount') }}</th>
                    <th class="size">{{ _lang('Discount') }}</th>
                    <th class="size">{{ _lang('Total') }}</th>
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
        <table style="margin-top:-10px">
            <tr>
                <td><b>Date:</b></td>
                <td colspan="2">{{ date('Y-m-d') }}</td>
                <td><b>Place:</b></td>
                <td>{{ get_option('address') }}</td>
            </tr>
        </table>
        <div style="margin-top:85px; margin-left:350px;">
            <b>Signature:</b><span>_________________________</span>
        </div>

        <div class="body-shape2">
            @php
                $footerPath = public_path('uploads/footerLine.png');
                $footerImage = file_exists($footerPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($footerPath)) : '';
            @endphp
            <img src="{{ $footerImage }}" alt="Footer Line">
        </div>
        <div style="position: fixed; bottom: 0; left: 0; color: #ffffff">
            @php
                $phoneIconPath = public_path('uploads/images/phone-icon.jpg');
                $phoneIcon = file_exists($phoneIconPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($phoneIconPath)) : '';
            @endphp
            <li><div class="hostel-number" style="padding:5px 50px; display: inline-block;">
                <img src="{{ $phoneIcon }}"
                    style="width:15px; height:15px;display: inline-block;">
                {{get_option('phone')}}
            </div></li>
            <li>
            <div class="hostel-email" style="padding:5px 50px; display: inline-block;">
                @php
                    $emailIconPath = public_path('uploads/images/email.jpg');
                    $emailIcon = file_exists($emailIconPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($emailIconPath)) : '';
                @endphp
                <img src="{{ $emailIcon }}"
                    style="width:15px; height:15px; display: inline-block;">
                <a href="{{get_option('email')}}" style="color: #ffffff">Bait-ul-Hareem</a>
            </div></li>
            <li>
            <div style="padding:7px; margin-left:40px; display: inline-block;">{{ get_option('address') }}</div></li>
            <div class="" style="margin-left:460; margin-bottom:2; display: inline-block;">Powered By: Logic Consultant</div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="student_print_div">
        <div class="body-shape1">
            @php
                $headerPath = public_path('uploads/HeaderLine.png');
                $headerImage = file_exists($headerPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($headerPath)) : '';
            @endphp
            <img src="{{ $headerImage }}" alt="Header Line">
        </div>

        <div class="student-image">
            <header class="th-header header-layout2">
                <div class="row align-items-center justify-content-end">
                    <div class="col-auto">
                        <div class="header-logo">
                            @php
                                $logoFilename = get_option('logo') ?: '1556705924_1.png';
                                $logoPath = public_path('uploads/'.$logoFilename);
                                $logoImg = file_exists($logoPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath)) : '';
                            @endphp
                            <img src="{{ $logoImg }}" alt="Invar">
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <div class="hostel-name">
            <p><b>Bait-ul-Hareem Girls Hostel</b></p>
        </div>

        <div class="student-details" >
            <div class="heading">
                <p>{{ _lang('Hostel Rules') }}</p>
            </div>
            <ul id="rules-list">
            <ol style="margin-top:-70px; margin-left: -20px;">
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
			</ol>
            </ul>
        </div>

        <div class="body-shape2">
            @php
                $footerPath = public_path('uploads/footerLine.png');
                $footerImage = file_exists($footerPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($footerPath)) : '';
            @endphp
            <img src="{{ $footerImage }}" alt="Footer Line">
        </div>
        <div style="position: fixed; bottom: 0; left: 0; color: #ffffff">
            @php
                $phoneIconPath = public_path('uploads/images/phone-icon.jpg');
                $phoneIcon = file_exists($phoneIconPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($phoneIconPath)) : '';
                $emailIconPath = public_path('uploads/images/email.jpg');
                $emailIcon = file_exists($emailIconPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($emailIconPath)) : '';
            @endphp
            <li><div class="hostel-number" style="padding:5px 50px; display: inline-block;">
                <img src="{{ $phoneIcon }}"
                    style="width:15px; height:15px;display: inline-block;">
                {{get_option('phone')}}
            </div></li>
            <li>
            <div class="hostel-email" style="padding:5px 50px; display: inline-block;">
                <img src="{{ $emailIcon }}"
                    style="width:15px; height:15px; display: inline-block;">
                <a href="{{get_option('email')}}" style="color: #ffffff">Bait-ul-Hareem</a>
            </div></li>
            <li>
            <div style="padding:7px; margin-left:40px; display: inline-block;">{{ get_option('address') }}</div></li>
            <div class="" style="margin-left:460; margin-bottom:2; display: inline-block;">Powered By: Logic Consultant</div>
        </div>
    </div>
</body>
</html>
