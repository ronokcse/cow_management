<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incomes extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('income_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$filter_meta = cow_parse_date_filter($this->input);
		$start = $filter_meta['start'];
		$end = $filter_meta['end'];
		$data = array(
			'title' => t('incomes'),
			'rows' => $this->income_model->get_all_filtered($start, $end),
			'filter_meta' => $filter_meta,
			'form_action' => site_url('incomes'),
			'filter_sum' => $this->income_model->sum_amount_filtered($start, $end),
		);
		$this->load->view('template/header', $data);
		$this->load->view('incomes/index', $data);
		$this->load->view('template/footer', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('amount', t('amount'), 'required|numeric');
		$this->form_validation->set_rules('income_date', t('date'), 'required');
		$this->form_validation->set_rules('description', t('description'), 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array('title' => t('new_income'));
			$this->load->view('template/header', $data);
			$this->load->view('incomes/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->income_model->create(array(
			'amount' => $this->input->post('amount', TRUE),
			'income_date' => $this->input->post('income_date', TRUE),
			'description' => $this->input->post('description', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', t('saved_msg'));
		redirect('incomes');
	}

	public function edit($id = NULL)
	{
		$row = $this->income_model->get_by_id($id);
		if ( ! $row)
		{
			show_404();
		}

		$this->form_validation->set_rules('amount', t('amount'), 'required|numeric');
		$this->form_validation->set_rules('income_date', t('date'), 'required');
		$this->form_validation->set_rules('description', t('description'), 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => t('edit_income'),
				'row' => $row,
			);
			$this->load->view('template/header', $data);
			$this->load->view('incomes/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->income_model->update($id, array(
			'amount' => $this->input->post('amount', TRUE),
			'income_date' => $this->input->post('income_date', TRUE),
			'description' => $this->input->post('description', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', t('updated_msg'));
		redirect('incomes');
	}

	public function delete($id)
	{
		$this->income_model->delete($id);
		$this->session->set_flashdata('success', t('deleted_msg'));
		redirect('incomes');
	}
}
