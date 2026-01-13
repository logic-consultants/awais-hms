<?php

namespace App\Http\Controllers;

use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Auth;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{

	public function index()
	{
		$method = Auth::User()->user_type . '_dashboard';
		return $this->$method();
	}

	private function Admin_dashboard()
	{
		$month = date('m');
		$year = date('Y');

		$data = array();
		$data['currency'] = get_option('currency_symbol');
		$data['total_class'] = \App\ClassModel::where('school_id', schoolId())->get();
		$data['total_student'] = \App\Student::join("student_sessions", "students.id", "student_sessions.student_id")
			->selectRaw("COUNT(students.id) as total_student")
			->where("student_sessions.session_id", get_option("academic_year"))->where('students.status', 1)->where('students.school_id', schoolId())->first()->total_student;

		$data['student_payments'] = \App\Invoice::where('status', 'Paid')->whereBetween('payment_date', [Carbon::now()->startOfMonth(), Carbon::now()])
			->sum('paid');

		$data['monthly_income'] = \App\Transaction::selectRaw("IFNULL(SUM(amount),0) as total")
			->where("dr_cr", "cr")
			->whereMonth("trans_date", $month)
			->whereYear("trans_date", $year)
			->where('school_id', schoolId())
			->first()->total;

		$data['income'] = \App\Transaction::select(
			'transactions.*',
			"account_detail.account_name as f_type"
		)
			->leftJoin("account_detail as chart", "chart.id", "=", "transactions.chart_id")->where('dr_cr', 'cr')
			->whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
		// dd($data['income']);

		$data['expenses'] = \App\Transaction::select(
			'transactions.*',
			"account_detail.account_name as f_type"
		)
			->leftJoin("account_detail as chart", "chart.id", "=", "transactions.chart_id")
			->where('dr_cr', 'dr')
			->whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])
			->sum('amount');

		$income = \App\Transaction::where('dr_cr', 'cr')->whereDate('trans_date', '<=', Carbon::now())
			->sum('amount');

		$atif_acc = $expense = \App\Transaction::select(
			'transactions.*',
			"chart.account_name as c_type"
		)
			->leftJoin("account_detail as chart", "chart.id", "=", "transactions.chart_id")
			->where('dr_cr', 'dr')
			->where('chart_id', '=', 11)
			->where('chart_id', '=', 12)
			->sum('amount');

		$expense = \App\Transaction::where('dr_cr', 'dr')->whereDate('trans_date', '<=', Carbon::now())
			->sum('amount');

		$data['cash_in_hand'] = $income - $expense;

		$data['monthly_expense'] = \App\Transaction::where("dr_cr", "dr")
			->whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])
			->sum('amount');

		$atif_sahb_bank_income = \App\Transaction::where('dr_cr', 'cr')->where('chart_id', '12')
			->whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
		$atif_sahb_bank_expense = \App\Transaction::where('dr_cr', 'dr')->where('chart_id', '12')
			->whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');

		$data['atif_bank'] = $atif_sahb_bank_expense;

		$atif_sahb_income_cash = \App\Transaction::where('dr_cr', 'cr')->where('chart_id', '11')
			->whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
		$atif_sahb_expense_cash = \App\Transaction::where('dr_cr', 'dr')->where('chart_id', '11')
			->whereBetween('trans_date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');

		$data['atif_sahb'] = $atif_sahb_expense_cash;
		$data['yearly_income'] = $this->yearly_income();
		$data['yearly_expense'] = $this->yearly_expense();


		// Get the data from the database, still grouping by year and month to aggregate counts
		$data['student_active_report'] = User::selectRaw('YEAR(left_date) as year, MONTH(left_date) as month, 
			SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as status_0_count,
			SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as status_1_count')
			->groupBy('year', 'month')
			->orderBy('year', 'asc')
			->orderBy('month', 'asc')
			->get()
			->toArray();

		// Get unique years from the data
		$years = array_unique(array_column($data['student_active_report'], 'year'));
		$years = array_filter($years); // Remove null values, if any

		// Initialize the final result array
		$finalReport = [];

		// Loop through each year
		foreach ($years as $year) {
			$yearData = [
				'year' => $year,
				'months' => []
			];

			// Initialize all months (1 to 12) with 0 counts
			for ($month = 1; $month <= 12; $month++) {
				$yearData['months'][] = [ // Use [] to append as numeric-indexed array
					'month' => $month,
					'status_0_count' => 0,
					'status_1_count' => 0
				];
			}

			// Merge actual data for the year
			foreach ($data['student_active_report'] as $record) {
				if ($record['year'] == $year) {
					// Update the corresponding month (adjust index to 0-based)
					$monthIndex = $record['month'] - 1;
					$yearData['months'][$monthIndex] = [
						'month' => $record['month'],
						'status_0_count' => $record['status_0_count'],
						'status_1_count' => $record['status_1_count']
					];
				}
			}

			// Calculate totals for the year
			$yearData['total_status_0'] = array_sum(array_column($yearData['months'], 'status_0_count'));
			$yearData['total_status_1'] = array_sum(array_column($yearData['months'], 'status_1_count'));

			$finalReport[] = $yearData;
		}

		$data['student_active_report'] = $finalReport;

		// 		dd($data['monthly_income']);
		return view('backend.dashboard.' . Auth::User()->user_type, $data);
	}

	private function Student_dashboard()
	{
		//return redirect('login');
		$month = date('m');
		$year = date('Y');
		$data = array();

		$data['total_paid'] = \App\Invoice::join("student_payments", "student_payments.invoice_id", "invoices.id")
			->where("student_id", get_student_id())
			->where("session_id", get_option("academic_year"))
			->selectRaw("IFNULL(SUM(student_payments.amount),0) as total_paid")->where('invoices.school_id', schoolId())
			->first()->total_paid;

		$data['paid_invoice'] = \App\Invoice::where("student_id", get_student_id())
			->where("status", "paid")
			->where("session_id", get_option("academic_year"))
			->selectRaw("COUNT(id) as total_invoice")
			->where('school_id', schoolId())
			->first()->total_invoice;

		$data['unpaid_invoice'] = \App\Invoice::where("student_id", get_student_id())
			->where("status", "unpaid")
			->where("session_id", get_option("academic_year"))
			->where('school_id', schoolId())
			->selectRaw("COUNT(id) as total_invoice")
			->first()->total_invoice;

		return view('backend.dashboard.' . Auth::User()->user_type, $data);
	}

	private function Teacher_dashboard()
	{
		//return redirect('login');
		$month = date('m');
		$year = date('Y');
		$data = array();

		$data['total_student'] = \App\Student::join("student_sessions", "students.id", "student_sessions.student_id")
			->selectRaw("COUNT(students.id) as total_student")
			->where("student_sessions.session_id", get_option("academic_year"))->where('students.school_id', schoolId())->first()->total_student;

		$data['my_subject_count'] = \App\Subject::join("assign_subjects", "subjects.id", "assign_subjects.subject_id")
			->where("assign_subjects.teacher_id", get_teacher_id())
			->selectRaw(" COUNT(subjects.id) as my_subject_count")
			->where('subjects.school_id', schoolId())
			->first()->my_subject_count;


		return view('backend.dashboard.' . Auth::User()->user_type, $data);
	}

	private function Parent_dashboard()
	{
		//return redirect('login');
		$month = date('m');
		$year = date('Y');
		$data = array();

		return view('backend.dashboard.' . Auth::User()->user_type, $data);
	}

	private function Librarian_dashboard()
	{
		//return redirect('login');
		$month = date('m');
		$year = date('Y');
		$data = array();

		$data['total_books'] = \App\Book::selectRaw("SUM(quantity) as quantity")
			->where('school_id', schoolId())
			->first()->quantity;

		$data['total_member'] = \App\LibraryMember::selectRaw("COUNT(id) as total")
			->where('school_id', schoolId())
			->first()->total;

		$data['issuing_book'] = \App\BookIssue::selectRaw("COUNT(id) as total")
			->where('school_id', schoolId())
			->where("status", 1)
			->first()->total;

		return view('backend.dashboard.' . Auth::User()->user_type, $data);
	}

	private function Accountant_dashboard()
	{
		//return redirect('login');
		$month = date('m');
		$year = date('Y');
		$data = array();

		$data['currency'] = get_option('currency_symbol');
		$data['total_student'] = \App\Student::join("student_sessions", "students.id", "student_sessions.student_id")
			->selectRaw("COUNT(students.id) as total_student")
			->where("student_sessions.session_id", get_option("academic_year"))->where('students.school_id', schoolId())->first()->total_student;

		$data['student_payments'] = \App\StudentPayment::selectRaw("IFNULL(SUM(amount),0) as total")
			->whereMonth("date", $month)
			->whereYear("date", $year)
			->where('school_id', schoolId())
			->first()->total;

		$data['monthly_income'] = \App\Transaction::selectRaw("IFNULL(SUM(amount),0) as total")
			->where("dr_cr", "cr")
			->whereMonth("trans_date", $month)
			->whereYear("trans_date", $year)
			->where('school_id', schoolId())
			->first()->total;

		$data['monthly_expense'] = \App\Transaction::selectRaw("IFNULL(SUM(amount),0) as total")
			->where("dr_cr", "dr")
			->whereMonth("trans_date", $month)
			->whereYear("trans_date", $year)
			->where('school_id', schoolId())
			->first()->total;

		$data['yearly_income'] = $this->yearly_income();
		$data['yearly_expense'] = $this->yearly_expense();

		return view('backend.dashboard.' . Auth::User()->user_type, $data);
	}

	private function Employee_dashboard()
	{
		//return redirect('login');
		$month = date('m');
		$year = date('Y');
		$data = array();

		return view('backend.dashboard.' . Auth::User()->user_type, $data);
	}


	private function yearly_income()
	{
		$school_id = schoolId();
		$date = date("Y-m-d");
		$income  = "[";
		$income_query = DB::select("SELECT m.month, IFNULL(SUM(t.amount),0) as income_amount 
		FROM ( SELECT 1 AS MONTH UNION SELECT 2 AS MONTH UNION SELECT 3 AS MONTH 
		UNION SELECT 4 AS MONTH UNION SELECT 5 AS MONTH UNION SELECT 6 AS MONTH 
		UNION SELECT 7 AS MONTH UNION SELECT 8 AS MONTH UNION SELECT 9 AS MONTH 
		UNION SELECT 10 AS MONTH UNION SELECT 11 AS MONTH UNION SELECT 12 AS MONTH ) AS m 
		LEFT JOIN transactions t ON t.school_id =$school_id AND m.month = MONTH(t.trans_date) AND YEAR(t.trans_date)=YEAR('$date') 
		AND t.trans_type='income' GROUP BY m.month ORDER BY m.month ASC");
		foreach ($income_query as $row) {
			$income .= $row->income_amount . ",";
		}
		return $income . "]";
	}

	private function yearly_expense()
	{
		$school_id = schoolId();
		$date = date("Y-m-d");
		$expense  = "[";
		$expense_query = DB::select("SELECT m.month, IFNULL(SUM(t.amount),0) as expense_amount 
		FROM ( SELECT 1 AS MONTH UNION SELECT 2 AS MONTH UNION SELECT 3 AS MONTH 
		UNION SELECT 4 AS MONTH UNION SELECT 5 AS MONTH UNION SELECT 6 AS MONTH 
		UNION SELECT 7 AS MONTH UNION SELECT 8 AS MONTH UNION SELECT 9 AS MONTH 
		UNION SELECT 10 AS MONTH UNION SELECT 11 AS MONTH UNION SELECT 12 AS MONTH ) AS m 
		LEFT JOIN transactions t ON t.school_id =$school_id AND m.month = MONTH(t.trans_date) AND YEAR(t.trans_date)=YEAR('$date') 
		AND t.trans_type='expense' GROUP BY m.month ORDER BY m.month ASC");
		foreach ($expense_query as $row) {
			$expense .= $row->expense_amount . ",";
		}

		return $expense . "]";
	}
}
