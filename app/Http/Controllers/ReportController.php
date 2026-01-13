<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use App\Accounts_detail;
use App\StudentSession;
use App\Transaction;
use App\StudentFeeAssign;
use App\Accounts;
use App\Invoice;

class ReportController extends Controller
{

	public function student_attendance_report(Request $request, $view = "")
	{
		$class_id = 0;
		$section_id = "";
		$month = "";
		if ($view == "") {
			return view('backend.reports.student_attendance_report', compact('class_id', 'section_id', 'month'));
		} else {


			if (checkSchoolId('classes', $request->class_id) != schoolId() || checkSchoolId('sections', $request->section_id) != schoolId()) {
				return redirect()->back()->with('error', 'access denied');
			}

			$class_id = $request->class_id;
			$section_id = $request->section_id;
			$class = get_class_name($class_id);
			$section = get_section_name($section_id);
			$month = (explode("/", $request->month));
			$num_of_days =  now()->parse($month[1] . '-' . $month[0] . '-01')->daysInMonth;

			$query = DB::table('student_attendances')
				->whereMonth('date', $month[0])
				->whereYear('date', $month[1])
				->where('school_id', schoolId())
				->orderBy('date', 'asc')
				->get();

			$query2 = DB::table("students")
				->join("student_sessions", "students.id", "=", "student_sessions.student_id")
				->where("student_sessions.class_id", $class_id)
				->where("student_sessions.section_id", $section_id)
				->where('students.status', 1)
				->where('students.school_id', schoolId())
				->orderBy('students.id', 'asc')
				->get();

			$report_data = array();
			$students = array();

			for ($i = 1; $i <= $num_of_days; $i++) {
				$date = new \DateTime($month[1] . "-" . $month[0] . "-" . $i);
				$date = $date->format('Y-m-d');
				$attendance_value = array("0" => "", "1" => "P", "2" => "A", "3" => "L", "4" => "H");
				foreach ($query as $data) {
					if ($date == $data->date) {
						$report_data[$data->student_id][$date] = $attendance_value[$data->attendance];
					} else {
						if (! isset($report_data[$data->student_id][$date])) {
							$report_data[$data->student_id][$date] = $attendance_value[0];
						}
					}
				}
			}

			foreach ($query2 as $student) {
				$students[$student->student_id] = $student;
			}


			$month = $request->month;
			return view('backend.reports.student_attendance_report', compact('class_id', 'section_id', 'class', 'section', 'report_data', 'num_of_days', 'students', 'month'));
		}
	}

	public function student_list_report(Request $request, $view = "")
	{
		$class_id = 0;
		$section_id = "";

		if ($view == "") {
			return view('backend.reports.student_report', compact('class_id', 'section_id'));
		} else {
			$class_id = $request->class_id;
			$section_id = $request->section_id;

			// Security Check for Floor
			if (checkSchoolId('classes', $class_id) != schoolId()) {
				return redirect()->back()->with('error', 'Access denied');
			}

			// Start the Query
			$query = DB::table("students")
				->join("student_sessions", "students.id", "=", "student_sessions.student_id")
				->join("classes", "classes.id", "=", "student_sessions.class_id")
				->join("sections", "sections.id", "=", "student_sessions.section_id")
				->leftJoin("users", "users.id", "=", "students.user_id")
				->select(
					'students.*',
					'classes.class_name as floor_name',
					'sections.section_name as room_name',
					'users.image as photo'
				)
				->where("student_sessions.class_id", $class_id)
				// ->where('students.status', 1)
				->where('students.school_id', schoolId());

			if ($section_id != "") {
				$query->where("student_sessions.section_id", $section_id);
				$section_name = get_section_name($section_id);
			} else {
				$section_name = _lang('All Rooms');
			}

			$students = $query->orderBy('students.first_name', 'asc')
				->get();
			$class_name = get_class_name($class_id);

			return view('backend.reports.student_report', compact('class_id', 'section_id', 'students', 'class_name', 'section_name'));
		}
	}
	public function staff_attendance_report(Request $request, $view = "")
	{
		$user_type = "";
		$month = "";
		if ($view == "") {
			return view('backend.reports.staff_attendance_report', compact('user_type', 'month'));
		} else {
			$user_type = $request->user_type;
			$month = (explode("/", $request->month));

			$num_of_days =  now()->parse($month[1] . '-' . $month[0] . '-01')->daysInMonth;

			$query = DB::table('staff_attendances')
				->join("users", "users.id", "=", "staff_attendances.user_id")
				->select('staff_attendances.*')
				->where("user_type", $user_type)
				->whereMonth('date', $month[0])
				->whereYear('date', $month[1])
				->where('staff_attendances.school_id', schoolId())
				->orderBy('date', 'asc')
				->get();

			$query2 = DB::table("users")
				->where("users.user_type", $user_type)
				->where('school_id', schoolId())
				->orderBy('users.id', 'asc')
				->get();

			$report_data = array();
			$users = array();

			for ($i = 1; $i <= $num_of_days; $i++) {
				$date = new \DateTime($month[1] . "-" . $month[0] . "-" . $i);
				$date = $date->format('Y-m-d');
				$attendance_value = array("0" => "", "1" => "P", "2" => "A", "3" => "L", "4" => "H");
				foreach ($query as $data) {
					if ($date == $data->date) {
						$report_data[$data->user_id][$date] = $attendance_value[$data->attendance];
					} else {
						if (! isset($report_data[$data->user_id][$date])) {
							$report_data[$data->user_id][$date] = $attendance_value[0];
						}
					}
				}
			}

			foreach ($query2 as $user) {
				$users[$user->id] = $user;
			}


			$month = $request->month;
			return view('backend.reports.staff_attendance_report', compact('user_type', 'report_data', 'users', 'num_of_days', 'month'));
		}
	}

	public function student_id_card(Request $request, $view = "")
	{
		$class_id = 0;
		$section_id = "";

		if ($view == "") {
			return view('backend.reports.student_id_card', compact('class_id', 'section_id'));
		} else {
			if (checkSchoolId('classes', $request->class_id) != schoolId() || checkSchoolId('sections', $request->section_id) != schoolId()) {
				return redirect()->back()->with('error', 'access denied');
			}

			$class_id = $request->class_id;
			$section_id = $request->section_id;
			$student_id = $request->student_id;
			$student = DB::table("students")
				->join('users', 'users.id', '=', 'students.user_id')
				->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->join('classes', 'classes.id', '=', 'student_sessions.class_id')
				->join('sections', 'sections.id', '=', 'student_sessions.section_id')
				->where('student_sessions.session_id', get_option('academic_year'))
				->where('students.id', $student_id)
				->where('students.school_id', schoolId())->first();
			return view('backend.reports.student_id_card', compact('class_id', 'section_id', 'student'));
		}
	}

	public function exam_report(Request $request, $view = "")
	{
		$class_id = 0;
		$section_id = "";
		$exam_id = "";

		if ($view == "") {
			return view('backend.reports.exam_report', compact('class_id', 'section_id', 'exam_id'));
		} else {

			if (checkSchoolId('classes', $request->class_id) != schoolId() || checkSchoolId('sections', $request->section_id) != schoolId() || checkSchoolId('exams', $request->exam_id) != schoolId() || checkSchoolId('students', $request->student_id) != schoolId()) {
				return redirect()->back()->with('error', 'access denied');
			}

			$class_id = $request->class_id;
			$section_id = $request->section_id;
			$exam_id = $request->exam_id;
			$student_id = $request->student_id;


			$student =  DB::table("students")->join('users', 'users.id', '=', 'students.user_id')
				->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->join('classes', 'classes.id', '=', 'student_sessions.class_id')
				->leftjoin('student_groups', 'student_groups.id', '=', 'students.group')
				->join('sections', 'sections.id', '=', 'student_sessions.section_id')
				->where('student_sessions.session_id', get_option('academic_year'))
				->where('students.id', $student_id)->where('students.school_id', schoolId())->first();

			$exam = DB::table("exams")->where("id", $exam_id)->where("school_id", schoolId())->first();


			$subjects = DB::table("subjects")->where("class_id", $class_id)->where("school_id", schoolId())->get();

			$existing_marks = DB::select("SELECT marks.subject_id, marks.exam_id,mark_details.* from mark_details,marks WHERE mark_details.mark_id=marks.id 
			AND marks.class_id=:class AND marks.student_id=:student AND marks.exam_id=:exam_id", ["class" => $class_id, "student" => $student_id, "exam_id" => $exam_id]);


			$mark_head = DB::select("SELECT distinct mark_details.mark_type from mark_distributions 
			JOIN mark_details JOIN marks ON mark_details.mark_type = mark_distributions.mark_distribution_type 
			AND mark_details.mark_id=marks.id WHERE 
			marks.class_id=:class AND marks.student_id=:student AND marks.exam_id=:exam_id", ["class" => $class_id, "student" => $student_id, "exam_id" => $exam_id]);

			$mark_details = [];

			foreach ($existing_marks as $key => $val) {
				if ($val->mark_id != "") {
					$mark_details[$val->subject_id][$val->exam_id][$val->mark_type] = $val;
				}
			}

			return view('backend.reports.exam_report', compact('class_id', 'section_id', 'exam_id', 'student', 'exam', 'mark_head', 'mark_details', 'subjects'));
		}
	}

	public function progress_card(Request $request, $view = "")
	{
		$class_id = 0;
		$section_id = "";
		$exam_id = "";

		if ($view == "") {
			return view('backend.reports.progress_card', compact('class_id', 'section_id'));
		} else {
			if (checkSchoolId('classes', $request->class_id) != schoolId() || checkSchoolId('sections', $request->section_id) != schoolId() || checkSchoolId('students', $request->student_id) != schoolId()) {
				return redirect()->back()->with('error', 'access denied');
			}
			$class_id = $request->class_id;
			$section_id = $request->section_id;
			$student_id = $request->student_id;


			$student = DB::table("students")->join('users', 'users.id', '=', 'students.user_id')
				->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->join('classes', 'classes.id', '=', 'student_sessions.class_id')
				->leftjoin('student_groups', 'student_groups.id', '=', 'students.group')
				->join('sections', 'sections.id', '=', 'student_sessions.section_id')
				->where('student_sessions.session_id', get_option('academic_year'))
				->where('students.id', $student_id)->first();

			$exams = DB::select("SELECT marks.exam_id,marks.class_id,marks.section_id,marks.subject_id, exams.name 
			FROM marks,exams WHERE marks.exam_id=exams.id AND marks.student_id=:student_id
			AND marks.class_id=:class GROUP BY marks.exam_id", ["student_id" => $student_id, "class" => $class_id]);

			$subjects = DB::table("subjects")->where("class_id", $class_id)->get();

			$existing_marks = DB::select("SELECT marks.subject_id, marks.exam_id,mark_details.* from mark_details,marks WHERE mark_details.mark_id=marks.id 
			AND marks.class_id=:class AND marks.student_id=:student", ["class" => $class_id, "student" => $student_id]);


			$mark_head = DB::select("SELECT distinct mark_details.mark_type from mark_distributions 
			JOIN mark_details JOIN marks ON mark_details.mark_type = mark_distributions.mark_distribution_type 
			AND mark_details.mark_id=marks.id WHERE 
			marks.class_id=:class AND marks.student_id=:student", ["class" => $class_id, "student" => $student_id]);

			$mark_details = [];

			foreach ($existing_marks as $key => $val) {
				if ($val->mark_id != "") {
					$mark_details[$val->subject_id][$val->exam_id][$val->mark_type] = $val;
				}
			}

			return view('backend.reports.progress_card', compact('class_id', 'section_id', 'student', 'exams', 'mark_head', 'mark_details', 'subjects'));
		}
	}

	public function class_routine(Request $request, $view = "")
	{
		$class_id = 0;
		$section_id = "";

		if ($view == "") {
			return view('backend.reports.class_routine', compact('class_id', 'section_id'));
		} else {
			if (checkSchoolId('classes', $request->class_id) != schoolId() || checkSchoolId('sections', $request->section_id) != schoolId()) {
				return redirect()->back()->with('error', 'access denied');
			}
			$data = array();
			$data['class_id'] = $request->class_id;
			$data['section_id'] = $request->section_id;
			$data['class'] = \App\ClassModel::find($request->class_id);
			$data['section'] = \App\Section::find($request->section_id);
			$data['routine'] = \App\ClassRoutine::getRoutineView($request->class_id, $request->section_id);

			return view('backend.reports.class_routine', $data);
		}
	}

	public function exam_routine(Request $request, $view = "")
	{
		$class_id = 0;
		$exam_id = "";

		if ($view == "") {
			return view('backend.reports.exam_routine', compact('class_id', 'exam_id'));
		} else {
			if (checkSchoolId('classes', $request->class_id) != schoolId() || checkSchoolId('exams', $request->exam_id) != schoolId()) {
				return redirect()->back()->with('error', 'access denied');
			}

			$data = array();
			$data['class_id'] = $request->class_id;
			$data['exam_id'] = $request->exam_id;
			$exam = $request->exam_id;;
			$data['subjects'] = \App\Subject::select('*', 'exam_schedules.id as schedules_id', 'subjects.id as subject_id')
				->leftJoin('exam_schedules', function ($join) use ($exam) {
					$join->on('subjects.id', '=', 'exam_schedules.subject_id');
					$join->where('exam_schedules.exam_id', $exam);
				})
				->where('subjects.class_id', $request->class_id)
				->where('subjects.school_id', schoolId())
				->get();

			return view('backend.reports.exam_routine', $data);
		}
	}

	public function income_report(Request $request, $view = "")
	{
		$date1 = "";
		$date2 = "";
		if ($view == "") {
			return view('backend.reports.income_report', compact('date1', 'date2'));
		} else {
			$date1 = $request->date1;
			$date2 = $request->date2;

			$report_data = \App\Transaction::select(
				'transactions.*',
				'account_detail.account_name as c_type',
				'account.account_name as account_name'
			)
				->join("account_detail", "account_detail.id", "=", "transactions.chart_id")
				->leftJoin("account_detail as account", "account.id", "=", "transactions.account_id")  // FIXED JOIN
				->where("transactions.trans_type", "income")
				->where("transactions.school_id", schoolId())
				->whereBetween('trans_date', [$date1, $date2])
				->orderBy("transactions.id", "DESC")->get();

			$summary = DB::select("SELECT SUM(amount) as total 
					   FROM transactions WHERE trans_type='income' AND school_id='" . schoolId() . "'
					   AND trans_date BETWEEN :date1 AND :date2", ["date1" => $date1, "date2" => $date2])[0];


			return view('backend.reports.income_report', compact('date1', 'date2', 'report_data', 'summary'));
		}
	}

	public function expense_report(Request $request, $view = "")
	{
		$date1 = "";
		$date2 = "";
		if ($view == "") {
			return view('backend.reports.expense_report', compact('date1', 'date2'));
		} else {
			$date1 = $request->date1;
			$date2 = $request->date2;
			$report_data = \App\Transaction::select(
				'transactions.*',
				'account_detail.account_name as c_type',
				'account.account_name as account_name',
				'transactions.id as id'
			)
				->join("account_detail", "account_detail.id", "=", "transactions.chart_id")
				->leftJoin("account_detail as account", "account.id", "=", "transactions.account_id")  // FIXED JOIN
				->where("transactions.trans_type", "expense")
				->where("transactions.school_id", schoolId())
				->whereBetween('trans_date', [$date1, $date2])
				->orderBy("transactions.id", "DESC")->get();

			$summary = DB::select("SELECT SUM(amount) as total 
					   FROM transactions WHERE trans_type='expense' AND school_id='" . schoolId() . "'
					   AND trans_date BETWEEN :date1 AND :date2", ["date1" => $date1, "date2" => $date2])[0];


			return view('backend.reports.expense_report', compact('date1', 'date2', 'report_data', 'summary'));
		}
	}

	public function account_balance(Request $request)
	{
		$accounts = Accounts_detail::pluck('id', 'account_name'); // ['Account Name' => ID]

		$report_income = [];
		$report_expense = [];

		$dateFrom = $request->input('date_from');
		$dateTo = $request->input('date_to');

		foreach ($accounts as $name => $id) {
			// Base query builder
			$baseQuery = Transaction::where(function ($q) use ($id) {
				$q->where('chart_id', $id)
					->orWhere('account_id', $id);
			});

			if ($dateFrom) {
				$baseQuery->whereDate('trans_date', '>=', $dateFrom);
			}
			if ($dateTo) {
				$baseQuery->whereDate('trans_date', '<=', $dateTo);
			}

			// Clone query for cr and dr separately
			$total_cr = (clone $baseQuery)->where('dr_cr', 'cr')->sum('amount');
			$total_dr = (clone $baseQuery)->where('dr_cr', 'dr')->sum('amount');

			$net_balance = $total_cr - $total_dr;

			// Categorize by net_balance
			if ($net_balance > 0) {
				$report_income[] = [
					'c_type' => $name,
					'current_amount' => number_format($net_balance, 2, '.', '')
				];
			} elseif ($net_balance < 0) {
				$report_expense[] = [
					'c_type' => $name,
					'current_amount' => number_format(abs($net_balance), 2, '.', '') // make it positive
				];
			}
		}

		if ($request->ajax()) {
			return response()->json([
				'income' => $report_income,
				'expense' => $report_expense
			]);
		}

		return view('backend.reports.financial_account_balace', compact('report_income', 'report_expense'));
	}

	public function report_area(Request $request)
	{
		if (!empty($request->session)) {
			$data['session'] = $request->session;
		} else {
			$data['session'] = get_option('academic_year');
		}

		$data['class_id'] = $request->class_id;
		$data['section_id'] = $request->section_id;
		$data['date_from'] = $request->date_from;
		$data['date_to'] = $request->date_to;
		return view('backend.reports.report_area', $data);
	}

	public function generate_report(Request $request)
	{
		if (empty($request->report_name)) {
			return redirect()->back()->with('error', 'Please select report name');
		}

		$data['title'] = '';
		$data['session'] = \App\AcademicYear::find($request->session);
		if ($request->class_id == 'All') {
			$data['class'] = $request->class_id;
		} else {
			$data['class'] = \App\ClassModel::find($request->class_id);
		}
		if ($request->section_id == 'All') {
			$data['section'] = $request->section_id;
		} else {
			$data['section'] = \App\Section::find($request->section_id);
		}
		$data['date_from'] = $request->date_from;
		$data['date_to'] = $request->date_to;
		if ($request->report_name == 'fee_summary') {
			$data['title'] = 'Fee summary register';
			$data['fees'] = \App\FeeType::where('school_id', schoolId())->orderBy('id', 'ASC')->get(); //This define column orders
			$invoices = Invoice::with(['invoice_item'])->join('students', 'invoices.student_id', '=', 'students.id')
				->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->join('classes', 'classes.id', '=', 'student_sessions.class_id')
				->join('sections', 'sections.id', '=', 'student_sessions.section_id')
				->select('invoices.*', 'students.first_name', 'students.last_name', 'students.register_no', 'student_sessions.roll', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
				// ->where('invoices.school_id',schoolId())

				//->where('invoices.status','Paid')

				->where('invoices.paid', '>', 0) //filter data with partial payments
				->where('invoices.session_id', $request->session)
				->orderby('sections.id', 'ASC');

			//->orderBy('student_sessions.class_id', 'ASC')
			//->orderBy('student_sessions.section_id', 'ASC')
			//->orderBy('students.first_name', 'ASC')

			if ($request->class_id != 'All') {
				$invoices = $invoices->where('student_sessions.class_id', $request->class_id);
			}
			if ($request->section_id != 'All') {
				$invoices = $invoices->where('student_sessions.section_id', $request->section_id);
			}
			if (!empty($request->date_from)) {
				$invoices = $invoices->whereDate('payment_date', '>=', now()->parse($request->date_from)->format('Y-m-d'));
			}
			if (!empty($request->date_to)) {
				$invoices = $invoices->whereDate('payment_date', '<=', now()->parse($request->date_to)->format('Y-m-d'));
			}


			$data['invoices'] = $invoices->get();
			// dd($invoices->get()[0]);

			return view('backend.pdf.reports.fee_summary', $data); //if you not need to print with PDF plugin

			/*if you need to print with PDF plugin
			$pdf = PDF::loadView('backend.pdf.reports.fee_summary',$data)->setPaper('a4');

			@unlink('pdf/reports/' . 'fee_summary.pdf');
            $pdf->save('pdf/reports/' . 'fee_summary.pdf');
            return redirect('pdf/reports/' . 'fee_summary.pdf');
            */
		} else if ($request->report_name == 'fee_summary_with_dues') {
			$data['title'] = 'Fee summary with dues register';
			$data['fees'] = \App\FeeType::where('school_id', schoolId())->orderBy('id', 'ASC')->get(); //This define column orders

			$data['invoices'] = \App\Student::with(['invoices.invoice_item'])
				->leftJoin('invoices', 'students.id', '=', 'invoices.student_id')
				->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->join('classes', 'classes.id', '=', 'student_sessions.class_id')
				->join('sections', 'sections.id', '=', 'student_sessions.section_id')
				->where('students.status', '1')
				->where(function ($query) {
					$query->where('invoices.school_id', schoolId())
						->orWhereNull('invoices.school_id');
				})
				->where(function ($query) use ($request) {
					$query->where('invoices.session_id', $request->session)
						->orWhereNull('invoices.session_id');
				})
				->when($request->class_id != 'All', function ($q) use ($request) {
					$q->where('student_sessions.class_id', $request->class_id);
				})
				->when($request->section_id != 'All', function ($q) use ($request) {
					$q->where('student_sessions.section_id', $request->section_id);
				})
				->when(!empty($request->date_from), function ($q) use ($request) {
					$q->where(function ($query) use ($request) {
						$query->whereDate('invoices.due_date', '>=', now()->parse($request->date_from)->format('Y-m-d'))
							->orWhereNull('invoices.due_date');
					});
				})
				->when(!empty($request->date_to), function ($q) use ($request) {
					$q->where(function ($query) use ($request) {
						$query->whereDate('invoices.due_date', '<=', now()->parse($request->date_to)->format('Y-m-d'))
							->orWhereNull('invoices.due_date');
					});
				})
				->select(
					DB::raw('COALESCE(SUM(invoices.total), 0) as total'),
					DB::raw('COALESCE(SUM(invoices.paid), 0) as paid'),
					'students.id as student_id',
					'students.first_name',
					'students.last_name',
					'students.register_no',
					'classes.class_name',
					'sections.section_name',
					'student_sessions.roll'
				)
				->groupBy('students.id', 'students.first_name', 'students.last_name', 'students.register_no', 'classes.class_name', 'sections.section_name', 'student_sessions.roll')
				->orderBy('sections.id', 'ASC')
				->get();


			$data['previousInvoices'] = DB::table('invoices')
				->join('students', 'invoices.student_id', '=', 'students.id')
				->select([
					DB::raw("student_id"),
					DB::raw("SUM(total) as total"),
					DB::raw("SUM(total) - SUM(paid) as total_dues")
				])
				->where('due_date', '<', now()->parse($request->date_from)->format('Y-m-d'))
				->groupBy('student_id')
				->get();

			$data['request'] = $request;

			return view('backend.pdf.reports.fee_summary_with_dues', $data); //if you not need to print with PDF plugin

			/*if you need to print with PDF plugin
			$pdf = PDF::loadView('backend.pdf.reports.fee_summary_with_dues',$data)->setPaper('a4');

			@unlink('pdf/reports/' . 'fee_summary_with_dues.pdf');
            $pdf->save('pdf/reports/' . 'fee_summary_with_dues.pdf');
            return redirect('pdf/reports/' . 'fee_summary_with_dues.pdf');
            */
		} elseif ($request->report_name == 'daily_fee_receipt_report') {
			$data['title'] = 'Detailed Fee Receipts (Bank-Cash Wise)';

			$feesTypes = \App\FeeType::all();
			$transactions = Transaction::where('school_id', schoolId())
				->with('invoice', 'invoice.student', 'feeType') // Eager load the feeType relationship
				->whereBetween('trans_date', [now()->parse($request->date_from), now()->parse($request->date_to)])
				->get();

			$groupedTransactions = $transactions->groupBy('invoice.student_id');

			$tableData = [];

			foreach ($groupedTransactions as $studentId => $studentTransactions) {
				$invoice = $studentTransactions?->first()->invoice;
				$student = $invoice?->student;

				if (!$student) continue;

				// Fetch all invoices for the student to calculate overall balance
				$allStudentInvoices = \App\Invoice::where('student_id', $studentId)->get();
				$balance = $allStudentInvoices->sum(function ($inv) {
					return $inv->total - $inv->paid;
				});

				// Use the latest transaction date for the row
				$date = $studentTransactions->max('trans_date');

				// Prepare row data
				$row = [
					'Room#' => '120 Common', // Adjust based on actual data source if available (e.g., from student model)
					'Date' => $date,
					'Student Information' => "{$student->phone}-{$student->first_name} {$student->last_name}", // Adjust format as needed
				];

				// Initialize fee types to 0
				foreach ($feesTypes as $feeType) {
					$row[$feeType->fee_type] = 0; // Use fee_type from FeeType model
				}

				$paidInPeriod = 0;

				foreach ($studentTransactions as $transaction) {
					$feeType = $transaction->feeType; // Access the related fee type

					if ($feeType) {
						$feeTypeName = $feeType->fee_type; // Use the fee_type name from the related FeeType model
						$row[$feeTypeName] = ($row[$feeTypeName] ?? 0) + $transaction->amount;
						$paidInPeriod += $transaction->amount;
					}
				}

				// Add paid and balance for the last column
				$row['paid'] = $paidInPeriod;
				$row['balance'] = $balance; // Use balance instead of total for consistency with your table's intent

				$tableData[] = $row;
			}

			// Convert to collection for easier summing
			$data['transactions'] = collect($tableData);

			$data['feesTypes'] = $feesTypes;

			return view('backend.pdf.reports.daily_fee_receipt_report', $data); //if you not need to print with PDF plugin

			/*if you need to print with PDF plugin
			$pdf = PDF::loadView('backend.pdf.reports.daily_fee_receipt_report',$data)->setPaper('a4');

			@unlink('pdf/reports/' . 'daily_fee_receipt_report.pdf');
            $pdf->save('pdf/reports/' . 'daily_fee_receipt_report.pdf');
            return redirect('pdf/reports/' . 'daily_fee_receipt_report.pdf');
            */
		} elseif ($request->report_name == 'fee_definition_student_wise') {
			$data['title'] = 'Fee Definition Report(Student Wise)';
			$students = StudentFeeAssign::where('student_fee_assigns.school_id', schoolId())
				->leftJoin('students', 'student_fee_assigns.student_id', '=', 'students.id')
				->leftJoin('student_sessions', 'student_sessions.student_id', '=', 'students.id')
				->leftJoin('classes', 'classes.id', '=', 'student_sessions.class_id')
				->leftJoin('sections', 'sections.id', '=', 'student_sessions.section_id')
				->select(
					'student_fee_assigns.school_id',
					'student_fee_assigns.amount',
					'sections.section_name',
					'classes.class_name',
					'students.first_name',
					'students.father_name',
					'students.last_name'
				)
				// ->leftJoin('classes', 'classes.id', '=', 'student_sessions.class_id')
				// ->leftJoin('sections', 'sections.id', '=', 'student_sessions.section_id')
				->where('students.status', 1)
				->get();

			if ($request->class_id != 'All') {
				$students = $students->where('class_id', $request->class_id);
			}
			if ($request->section_id != 'all') {
				$students = $students->where('section_id', $request->section_id);
			}
			// dd($students);
			$data['studentFeeAssign'] = $students;
			return view('backend.pdf.reports.fee_definition_student_wise', $data); //if you not need to print with PDF plugin

			/*if you need to print with PDF plugin
			$pdf = PDF::loadView('backend.pdf.reports.fee_definition_student_wise',$data)->setPaper('a4');

			@unlink('pdf/reports/' . 'fee_definition_student_wise.pdf');
            $pdf->save('pdf/reports/' . 'fee_definition_student_wise.pdf');
            return redirect('pdf/reports/' . 'fee_definition_student_wise.pdf');
            */
		} elseif ($request->report_name == 'invoice_dues_feebill') {
			$data['title'] = 'Dues Fee Bill';
			$invoices = \App\Invoice::with(['invoice_item'])
				->join('students', 'invoices.student_id', '=', 'students.id')
				->leftJoin('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->leftJoin('classes', 'classes.id', '=', 'student_sessions.class_id')
				->leftJoin('sections', 'sections.id', '=', 'student_sessions.section_id')
				->leftJoin('parents', 'parents.id', '=', 'students.parent_id')
				->select('invoices.*', 'students.first_name', 'students.last_name', 'parents.parent_name', 'student_sessions.roll', 'student_sessions.department_id', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
				->where("invoices.status", "Unpaid")
				->where("invoices.school_id", schoolId())
				->where('invoices.session_id', $request->session)
				->orderBy("invoices.payment_date", "DESC")
				->orderBy("invoices.class_id", "ASC")
				->orderBy("invoices.section_id", "ASC")
				->get();

			if ($request->class_id != 'All') {
				$invoices = $invoices->where('class_id', $request->class_id);
			}
			if ($request->section_id != 'All') {
				$invoices = $invoices->where('class_id', $request->section_id);
			}

			if (!empty($request->date_from)) {
				$invoices = $invoices->where('payment_date', '>=', now()->parse($request->date_from)->format('Y-m-d'));
			}
			if (!empty($request->date_to)) {
				$invoices = $invoices->where('payment_date', '<=', now()->parse($request->date_to)->format('Y-m-d'));
			}
			$invoice_lists = array();
			if (count($invoices) > 0) {
				foreach ($invoices as $key => $row_data) {
					$invoice_lists[$row_data['student_id']][] = $row_data;
				}
			}
			// dd($invoice_lists);
			$data['invoices'] = $invoice_lists;
			$data['currency'] = get_option('currency_symbol');
			return view('backend.pdf.reports.invoice_dues_feebill', $data); //if you not need to print with PDF plugin
			/*if you need to print with PDF plugin
			$pdf = PDF::loadView('backend.pdf.reports.invoice_dues_feebill',$data)->setPaper('A4', 'landscape');

			@unlink('pdf/reports/' . 'invoice_dues_feebill.pdf');
            $pdf->save('pdf/reports/' . 'invoice_dues_feebill.pdf');
            return redirect('pdf/reports/' . 'invoice_dues_feebill.pdf');
            */
		} elseif ($request->report_name == 'unpaid_details') {
			$data['title'] = 'Unpaid Details';
			$invoices = \App\Invoice::join('students', 'invoices.student_id', '=', 'students.id')
				->leftJoin('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->leftJoin('classes', 'classes.id', '=', 'student_sessions.class_id')
				->leftJoin('sections', 'sections.id', '=', 'student_sessions.section_id')
				->leftJoin('parents', 'parents.id', '=', 'students.parent_id')
				->select('invoices.*', 'students.first_name', 'students.last_name', 'students.register_no', 'students.phone', 'students.home_phone', 'parents.parent_name', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
				->where("invoices.status", "Unpaid")
				->where("invoices.school_id", schoolId())
				->where('invoices.session_id', $request->session)
				->orderBy("invoices.class_id", "ASC")
				->orderBy("invoices.section_id", "ASC")
				->orderBy("students.first_name", "ASC");

			if ($request->class_id != 'All') {
				$invoices = $invoices->where('student_sessions.class_id', $request->class_id);
			}
			if ($request->section_id != 'All') {
				$invoices = $invoices->where('student_sessions.class_id', $request->section_id);
			}

			if (!empty($request->date_from)) {
				$invoices = $invoices->whereDate('due_date', '>=', now()->parse($request->date_from)->format('Y-m-d'));
			}
			if (!empty($request->date_to)) {
				$invoices = $invoices->whereDate('due_date', '<=', now()->parse($request->date_to)->format('Y-m-d'));
			}

			$invoices = $invoices->get();
			$invoice_lists = array();
			if (count($invoices) > 0) {
				foreach ($invoices as $key => $row_data) {
					$invoice_lists[$row_data['student_id']][] = $row_data;
				}
			}
			// dd($invoice_lists);
			$data['invoices'] = $invoice_lists;
			$data['currency'] = get_option('currency_symbol');
			return view('backend.pdf.reports.unpaid_details', $data); //if you not need to print with PDF plugin

			/*if you need to print with PDF plugin
			$pdf = PDF::loadView('backend.pdf.reports.unpaid_details',$data)->setPaper('A4');

			@unlink('pdf/reports/' . 'unpaid_details.pdf');
            $pdf->save('pdf/reports/' . 'unpaid_details.pdf');
            return redirect('pdf/reports/' . 'unpaid_details.pdf');
            */
		} elseif ($request->report_name == 'unpaid_summary') {
			$data['title'] = 'Unpaid Fee Details for All';
			$invoices = \App\Invoice::join('students', 'invoices.student_id', '=', 'students.id')
				->leftJoin('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->leftJoin('classes', 'classes.id', '=', 'student_sessions.class_id')
				->leftJoin('sections', 'sections.id', '=', 'student_sessions.section_id')
				->leftJoin('parents', 'parents.id', '=', 'students.parent_id')
				->select('invoices.*', 'students.first_name', 'students.last_name', 'students.register_no', 'students.phone', 'students.home_phone', 'parents.parent_name', 'classes.class_name', 'sections.section_name', 'invoices.id as id')

				->where("invoices.status", "Unpaid")
				->where("invoices.school_id", schoolId())
				// ->where('invoices.session_id',$request->session)

				->orderBy("invoices.class_id", "ASC")
				->orderBy("invoices.section_id", "ASC")
				->orderBy("students.first_name", "ASC");

			if ($request->class_id != 'All') {
				$invoices = $invoices->where('invoices.class_id', $request->class_id);
			}
			if ($request->section_id != 'all' && $request->section_id != 'All') {
				$invoices = $invoices->where('invoices.section_id', $request->section_id);
			}

			if (!empty($request->date_from)) {
				// $invoices = $invoices->whereDate('payment_date','>=',now()->parse($request->date_from)->format('Y-m-d'));
			}
			if (!empty($request->date_to)) {
				$invoices = $invoices->whereDate('due_date', '<=', now()->parse($request->date_to)->format('Y-m-d'));
			}

			$invoices = $invoices->get();

			$invoice_lists = array();
			if (count($invoices) > 0) {
				foreach ($invoices as $key => $row_data) {
					$invoice_lists[$row_data['student_id']][] = $row_data;
				}
			}
			// dd($invoice_lists);
			$data['classes'] = \App\ClassModel::where('school_id', schoolId())->orderBy('id', 'DESC')->get();
			$data['invoices'] = $invoice_lists;
			$data['currency'] = get_option('currency_symbol');
			return view('backend.pdf.reports.unpaid_summary', $data); //if you not need to print with PDF plugin

			/*if you need to print with PDF plugin
			$pdf = PDF::loadView('backend.pdf.reports.unpaid_summary',$data)->setPaper('A4');

			@unlink('pdf/reports/' . 'unpaid_summary.pdf');
            $pdf->save('pdf/reports/' . 'unpaid_summary.pdf');
            return redirect('pdf/reports/' . 'unpaid_summary.pdf');
            */
		} elseif ($request->report_name == 'unpaid_summary_current') {
			$data['title'] = 'Unpaid Fee Details for Current';
			$invoices = \App\Invoice::join('students', 'invoices.student_id', '=', 'students.id')
				->leftJoin('student_sessions', 'students.id', '=', 'student_sessions.student_id')
				->leftJoin('classes', 'classes.id', '=', 'student_sessions.class_id')
				->leftJoin('sections', 'sections.id', '=', 'student_sessions.section_id')
				->leftJoin('parents', 'parents.id', '=', 'students.parent_id')
				->select('invoices.*', 'students.first_name', 'students.last_name', 'students.register_no', 'students.phone', 'students.home_phone', 'parents.parent_name', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
				->where("invoices.status", "Unpaid")
				->where("invoices.school_id", schoolId())
				->where('invoices.session_id', $request->session)
				->where("students.status", 1)
				->orderBy("invoices.class_id", "ASC")
				->orderBy("invoices.section_id", "ASC")
				->orderBy("students.first_name", "ASC");

			if ($request->class_id != 'All') {
				$invoices = $invoices->where('student_sessions.class_id', $request->class_id);
			}
			if ($request->section_id != 'All') {
				$invoices = $invoices->where('student_sessions.class_id', $request->section_id);
			}

			if (!empty($request->date_from)) {
				$invoices = $invoices->whereDate('due_date', '>=', now()->parse($request->date_from)->format('Y-m-d'));
			}
			if (!empty($request->date_to)) {
				$invoices = $invoices->whereDate('due_date', '<=', now()->parse($request->date_to)->format('Y-m-d'));
			}

			$invoices = $invoices->get();
			$invoice_lists = array();
			if (count($invoices) > 0) {
				foreach ($invoices as $key => $row_data) {
					$invoice_lists[$row_data['student_id']][] = $row_data;
				}
			}
			// dd($invoice_lists);
			$data['classes'] = \App\ClassModel::where('school_id', schoolId())->orderBy('id', 'DESC')->get();
			$data['invoices'] = $invoice_lists;
			$data['currency'] = get_option('currency_symbol');
			return view('backend.pdf.reports.unpaid_summary', $data); //if you not need to print with PDF plugin

			/*if you need to print with PDF plugin
			$pdf = PDF::loadView('backend.pdf.reports.unpaid_summary_current',$data)->setPaper('A4');

			@unlink('pdf/reports/' . 'unpaid_summary_current.pdf');
            $pdf->save('pdf/reports/' . 'unpaid_summary_current.pdf');
            return redirect('pdf/reports/' . 'unpaid_summary_current.pdf');
            */
		} else {
			return redirect()->back()->with('error', 'Report not found!');
		}
	}

	public function get_account_balance()
	{
		$accounts = Accounts_detail::pluck('id', 'account_name'); // ['Account A' => 1, 'Account B' => 2]
		$report_income = [];

		foreach ($accounts as $name => $id) {
			$balance = Transaction::where('chart_id', $id)->ORwhere('account_id', $id)->where('dr_cr', 'cr')->sum('amount');
			$report_income[$name] = $balance;
		}

		$report_expense = [];

		foreach ($accounts as $name => $id) {
			$balance = Transaction::where('chart_id', $id)->ORwhere('account_id', $id)->where('dr_cr', 'dr')->sum('amount');
			$report_expense[$name] = $balance;
		}

		dd($report_income, $report_expense); // ['Account A' => 1200, 'Account B' => 3400, ...]
	}
}
