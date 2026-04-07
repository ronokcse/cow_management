<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food_purchases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('food_purchase_model');
		$this->load->model('food_type_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$filter_meta = cow_parse_date_filter($this->input);
		$start = $filter_meta['start'];
		$end = $filter_meta['end'];
		$data = array(
			'title' => 'খাদ্য ক্রয়',
			'rows' => $this->food_purchase_model->get_all_with_type_filtered($start, $end),
			'filter_meta' => $filter_meta,
			'form_action' => site_url('food_purchases'),
			'filter_sum' => $this->food_purchase_model->sum_total_filtered($start, $end),
		);
		$this->load->view('template/header', $data);
		$this->load->view('food_purchases/index', $data);
		$this->load->view('template/footer', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('food_type_id', 'খাদ্যের ধরন', 'required|integer');
		$this->form_validation->set_rules('quantity_kg', 'পরিমাণ (কেজি)', 'required|numeric');
		$this->form_validation->set_rules('total_amount', 'মোট টাকা', 'required|numeric');
		$this->form_validation->set_rules('purchase_date', 'ক্রয়ের তারিখ', 'required');
		$this->form_validation->set_rules('notes', 'নোট', 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => 'নতুন খাদ্য ক্রয়',
				'food_types' => $this->food_type_model->get_all(),
			);
			$this->load->view('template/header', $data);
			$this->load->view('food_purchases/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->food_purchase_model->create(array(
			'food_type_id' => (int) $this->input->post('food_type_id', TRUE),
			'quantity_kg' => $this->input->post('quantity_kg', TRUE),
			'total_amount' => $this->input->post('total_amount', TRUE),
			'purchase_date' => $this->input->post('purchase_date', TRUE),
			'notes' => $this->input->post('notes', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', 'খাদ্য ক্রয় সেভ হয়েছে।');
		redirect('food_purchases');
	}

	public function edit($id = NULL)
	{
		$row = $this->food_purchase_model->get_by_id($id);
		if ( ! $row)
		{
			show_404();
		}

		$this->form_validation->set_rules('food_type_id', 'খাদ্যের ধরন', 'required|integer');
		$this->form_validation->set_rules('quantity_kg', 'পরিমাণ (কেজি)', 'required|numeric');
		$this->form_validation->set_rules('total_amount', 'মোট টাকা', 'required|numeric');
		$this->form_validation->set_rules('purchase_date', 'ক্রয়ের তারিখ', 'required');
		$this->form_validation->set_rules('notes', 'নোট', 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => 'খাদ্য ক্রয় সম্পাদনা',
				'row' => $row,
				'food_types' => $this->food_type_model->get_all(),
			);
			$this->load->view('template/header', $data);
			$this->load->view('food_purchases/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->food_purchase_model->update($id, array(
			'food_type_id' => (int) $this->input->post('food_type_id', TRUE),
			'quantity_kg' => $this->input->post('quantity_kg', TRUE),
			'total_amount' => $this->input->post('total_amount', TRUE),
			'purchase_date' => $this->input->post('purchase_date', TRUE),
			'notes' => $this->input->post('notes', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', 'আপডেট হয়েছে।');
		redirect('food_purchases');
	}

	public function delete($id)
	{
		$this->food_purchase_model->delete($id);
		$this->session->set_flashdata('success', 'মুছে ফেলা হয়েছে।');
		redirect('food_purchases');
	}
}
