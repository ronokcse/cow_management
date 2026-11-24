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
		$this->load->model('food_type_model');
		$this->load->model('income_model');
		$this->load->model('other_expense_model');
	}

	public function index()
	{
		$filter_meta = cow_parse_date_filter($this->input);
		$start = $filter_meta['start'];
		$end = $filter_meta['end'];

		$total_investment = $this->investment_model->sum_amount_filtered($start, $end);
		$total_food_cost = $this->food_purchase_model->sum_total_filtered($start, $end);
		$total_other = $this->other_expense_model->sum_amount_filtered($start, $end);
		$total_income = $this->income_model->sum_amount_filtered($start, $end);

		$total_expense_ops = $total_food_cost + $total_other;
		$net_profit = $total_income - $total_expense_ops;

		$recent_feeding = $this->daily_feeding_model->get_all_with_type_filtered($start, $end);
		$recent_feeding = array_slice($recent_feeding, 0, 5);

		$incomes_list = $this->income_model->get_all_filtered($start, $end);
		$expenses_list = $this->other_expense_model->get_all_filtered($start, $end);

		$recent_transactions = array();
		foreach (array_slice($incomes_list, 0, 5) as $inc)
		{
			$recent_transactions[] = (object) array(
				'type' => 'income',
				'date' => $inc->income_date,
				'id' => (int) $inc->id,
				'description' => $inc->description ?: t('incomes'),
				'amount' => (float) $inc->amount,
			);
		}
		foreach (array_slice($expenses_list, 0, 5) as $exp)
		{
			$recent_transactions[] = (object) array(
				'type' => 'expense',
				'date' => $exp->expense_date,
				'id' => (int) $exp->id,
				'description' => $exp->description ?: t('other_expenses'),
				'amount' => (float) $exp->amount,
			);
		}
		usort($recent_transactions, function($a, $b) {
			$cmp = strcmp($b->date, $a->date);
			return $cmp !== 0 ? $cmp : ($b->id - $a->id);
		});
		$recent_transactions = array_slice($recent_transactions, 0, 5);

		$consumption_30d = $this->daily_feeding_model->consumption_by_type_since(30);
		$stock_summary = $this->food_type_model->get_stock_summary();

		$today = date('Y-m-d');
		$today_rows = $this->daily_feeding_model->get_by_date($today);
		$today_total_kg = 0.0;
		foreach ($today_rows as $tr)
		{
			$today_total_kg += (float) $tr->quantity_kg;
		}

		$data = array(
			'title' => t('dashboard'),
			'filter_meta' => $filter_meta,
			'form_action' => site_url('dashboard'),
			'total_investment' => $total_investment,
			'total_food_cost' => $total_food_cost,
			'total_other' => $total_other,
			'total_income' => $total_income,
			'total_expense_ops' => $total_expense_ops,
			'net_profit' => $net_profit,
			'recent_feeding' => $recent_feeding,
			'recent_transactions' => $recent_transactions,
			'consumption_30d' => $consumption_30d,
			'stock_summary' => $stock_summary,
			'today_rows' => $today_rows,
			'today_total_kg' => $today_total_kg,
			'today' => $today,
		);

		$this->load->view('template/header', $data);
		$this->load->view('dashboard/index', $data);
		$this->load->view('template/footer', $data);
	}
}
