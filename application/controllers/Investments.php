<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Investments extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('investment_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$filter_meta = cow_parse_date_filter($this->input);
		$start = $filter_meta['start'];
		$end = $filter_meta['end'];
		$data = array(
			'title' => t('investments'),
			'rows' => $this->investment_model->get_all_filtered($start, $end),
			'filter_meta' => $filter_meta,
			'form_action' => site_url('investments'),
			'filter_sum' => $this->investment_model->sum_amount_filtered($start, $end),
		);
		$this->load->view('template/header', $data);
		$this->load->view('investments/index', $data);
		$this->load->view('template/footer', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('amount', t('amount'), 'required|numeric');
		$this->form_validation->set_rules('investment_date', t('date'), 'required');
		$this->form_validation->set_rules('description', t('description'), 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array('title' => t('new_investment'));
			$this->load->view('template/header', $data);
			$this->load->view('investments/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->investment_model->create(array(
			'amount' => $this->input->post('amount', TRUE),
			'investment_date' => $this->input->post('investment_date', TRUE),
			'description' => $this->input->post('description', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', t('saved_msg'));
		redirect('investments');
	}

	public function edit($id = NULL)
	{
		$row = $this->investment_model->get_by_id($id);
		if ( ! $row)
		{
			show_404();
		}

		$this->form_validation->set_rules('amount', t('amount'), 'required|numeric');
		$this->form_validation->set_rules('investment_date', t('date'), 'required');
		$this->form_validation->set_rules('description', t('description'), 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => t('edit_investment'),
				'row' => $row,
			);
			$this->load->view('template/header', $data);
			$this->load->view('investments/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->investment_model->update($id, array(
			'amount' => $this->input->post('amount', TRUE),
			'investment_date' => $this->input->post('investment_date', TRUE),
			'description' => $this->input->post('description', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', t('updated_msg'));
		redirect('investments');
	}

	public function delete($id)
	{
		$this->investment_model->delete($id);
		$this->session->set_flashdata('success', t('deleted_msg'));
		redirect('investments');
	}
}
