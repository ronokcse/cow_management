<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('investment_model');
		$this->load->model('food_purchase_model');
		$this->load->model('daily_feeding_model');
		$this->load->model('income_model');
		$this->load->model('other_expense_model');
	}

	public function index()
	{
		$total_investment = $this->investment_model->sum_total();
		$total_food_cost = $this->food_purchase_model->sum_total();
		$total_other = $this->other_expense_model->sum_total();
		$total_income = $this->income_model->sum_total();

		$total_expense_ops = $total_food_cost + $total_other;
		$net_profit = $total_income - $total_expense_ops;

		$recent_feeding = $this->daily_feeding_model->get_all_with_type();
		$recent_feeding = array_slice($recent_feeding, 0, 20);

		$consumption_30d = $this->daily_feeding_model->consumption_by_type_since(30);

		$today = date('Y-m-d');
		$today_rows = $this->daily_feeding_model->get_by_date($today);

		$data = array(
			'title' => 'ড্যাশবোর্ড',
			'total_investment' => $total_investment,
			'total_food_cost' => $total_food_cost,
			'total_other' => $total_other,
			'total_income' => $total_income,
			'total_expense_ops' => $total_expense_ops,
			'net_profit' => $net_profit,
			'recent_feeding' => $recent_feeding,
			'consumption_30d' => $consumption_30d,
			'today_rows' => $today_rows,
			'today' => $today,
		);

		$this->load->view('template/header', $data);
		$this->load->view('dashboard/index', $data);
		$this->load->view('template/footer', $data);
	}
}
