<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other_expenses extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('other_expense_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$filter_meta = cow_parse_date_filter($this->input);
		$start = $filter_meta['start'];
		$end = $filter_meta['end'];
		$data = array(
			'title' => t('other_expenses'),
			'rows' => $this->other_expense_model->get_all_filtered($start, $end),
			'filter_meta' => $filter_meta,
			'form_action' => site_url('other_expenses'),
			'filter_sum' => $this->other_expense_model->sum_amount_filtered($start, $end),
		);
		$this->load->view('template/header', $data);
		$this->load->view('other_expenses/index', $data);
		$this->load->view('template/footer', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('amount', t('amount'), 'required|numeric');
		$this->form_validation->set_rules('expense_date', t('date'), 'required');
		$this->form_validation->set_rules('description', t('description'), 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array('title' => t('new_expense'));
			$this->load->view('template/header', $data);
			$this->load->view('other_expenses/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->other_expense_model->create(array(
			'amount' => $this->input->post('amount', TRUE),
			'expense_date' => $this->input->post('expense_date', TRUE),
			'description' => $this->input->post('description', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', t('saved_msg'));
		redirect('other_expenses');
	}

	public function edit($id = NULL)
	{
		$row = $this->other_expense_model->get_by_id($id);
		if ( ! $row)
		{
			show_404();
		}

		$this->form_validation->set_rules('amount', t('amount'), 'required|numeric');
		$this->form_validation->set_rules('expense_date', t('date'), 'required');
		$this->form_validation->set_rules('description', t('description'), 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => t('edit_expense'),
				'row' => $row,
			);
			$this->load->view('template/header', $data);
			$this->load->view('other_expenses/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->other_expense_model->update($id, array(
			'amount' => $this->input->post('amount', TRUE),
			'expense_date' => $this->input->post('expense_date', TRUE),
			'description' => $this->input->post('description', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', t('updated_msg'));
		redirect('other_expenses');
	}

	public function delete($id)
	{
		$this->other_expense_model->delete($id);
		$this->session->set_flashdata('success', t('deleted_msg'));
		redirect('other_expenses');
	}
}
