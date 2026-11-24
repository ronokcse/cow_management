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
		$data = array(
			'title' => 'অন্যান্য খরচ (চিকিৎসা, শ্রমিক ইত্যাদি)',
			'rows' => $this->other_expense_model->get_all(),
		);
		$this->load->view('template/header', $data);
		$this->load->view('other_expenses/index', $data);
		$this->load->view('template/footer', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('amount', 'টাকার পরিমাণ', 'required|numeric');
		$this->form_validation->set_rules('expense_date', 'তারিখ', 'required');
		$this->form_validation->set_rules('description', 'বিবরণ', 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array('title' => 'নতুন খরচ');
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
		$this->session->set_flashdata('success', 'খরচ সেভ হয়েছে।');
		redirect('other_expenses');
	}

	public function edit($id = NULL)
	{
		$row = $this->other_expense_model->get_by_id($id);
		if ( ! $row)
		{
			show_404();
		}

		$this->form_validation->set_rules('amount', 'টাকার পরিমাণ', 'required|numeric');
		$this->form_validation->set_rules('expense_date', 'তারিখ', 'required');
		$this->form_validation->set_rules('description', 'বিবরণ', 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => 'খরচ সম্পাদনা',
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
		$this->session->set_flashdata('success', 'আপডেট হয়েছে।');
		redirect('other_expenses');
	}

	public function delete($id)
	{
		$this->other_expense_model->delete($id);
		$this->session->set_flashdata('success', 'মুছে ফেলা হয়েছে।');
		redirect('other_expenses');
	}
}
