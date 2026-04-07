<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incomes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('income_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = array(
			'title' => 'আয় (দুধ বিক্রি ইত্যাদি)',
			'rows' => $this->income_model->get_all(),
		);
		$this->load->view('template/header', $data);
		$this->load->view('incomes/index', $data);
		$this->load->view('template/footer', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('amount', 'টাকার পরিমাণ', 'required|numeric');
		$this->form_validation->set_rules('income_date', 'তারিখ', 'required');
		$this->form_validation->set_rules('description', 'বিবরণ', 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array('title' => 'নতুন আয়');
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
		$this->session->set_flashdata('success', 'আয় সেভ হয়েছে।');
		redirect('incomes');
	}

	public function edit($id = NULL)
	{
		$row = $this->income_model->get_by_id($id);
		if ( ! $row)
		{
			show_404();
		}

		$this->form_validation->set_rules('amount', 'টাকার পরিমাণ', 'required|numeric');
		$this->form_validation->set_rules('income_date', 'তারিখ', 'required');
		$this->form_validation->set_rules('description', 'বিবরণ', 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => 'আয় সম্পাদনা',
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
		$this->session->set_flashdata('success', 'আপডেট হয়েছে।');
		redirect('incomes');
	}

	public function delete($id)
	{
		$this->income_model->delete($id);
		$this->session->set_flashdata('success', 'মুছে ফেলা হয়েছে।');
		redirect('incomes');
	}
}
