<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_feeding extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('daily_feeding_model');
		$this->load->model('food_type_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$filter_meta = cow_parse_date_filter($this->input);
		$start = $filter_meta['start'];
		$end = $filter_meta['end'];
		$data = array(
			'title' => t('daily_feeding'),
			'rows' => $this->daily_feeding_model->get_all_with_type_filtered($start, $end),
			'filter_meta' => $filter_meta,
			'form_action' => site_url('daily_feeding'),
			'filter_sum' => $this->daily_feeding_model->sum_quantity_filtered($start, $end),
		);
		$this->load->view('template/header', $data);
		$this->load->view('daily_feeding/index', $data);
		$this->load->view('template/footer', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('food_type_id', t('type'), 'required|integer');
		$this->form_validation->set_rules('quantity_kg', t('kg'), 'required|numeric');
		$this->form_validation->set_rules('feeding_date', t('date'), 'required');
		$this->form_validation->set_rules('notes', t('notes'), 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => t('new_daily_feeding'),
				'food_types' => $this->food_type_model->get_all(),
			);
			$this->load->view('template/header', $data);
			$this->load->view('daily_feeding/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->daily_feeding_model->create(array(
			'food_type_id' => (int) $this->input->post('food_type_id', TRUE),
			'quantity_kg' => $this->input->post('quantity_kg', TRUE),
			'feeding_date' => $this->input->post('feeding_date', TRUE),
			'notes' => $this->input->post('notes', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', t('saved_msg'));
		redirect('daily_feeding');
	}

	public function edit($id = NULL)
	{
		$row = $this->daily_feeding_model->get_by_id($id);
		if ( ! $row)
		{
			show_404();
		}

		$this->form_validation->set_rules('food_type_id', t('type'), 'required|integer');
		$this->form_validation->set_rules('quantity_kg', t('kg'), 'required|numeric');
		$this->form_validation->set_rules('feeding_date', t('date'), 'required');
		$this->form_validation->set_rules('notes', t('notes'), 'trim|max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => t('edit_daily_feeding'),
				'row' => $row,
				'food_types' => $this->food_type_model->get_all(),
			);
			$this->load->view('template/header', $data);
			$this->load->view('daily_feeding/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->daily_feeding_model->update($id, array(
			'food_type_id' => (int) $this->input->post('food_type_id', TRUE),
			'quantity_kg' => $this->input->post('quantity_kg', TRUE),
			'feeding_date' => $this->input->post('feeding_date', TRUE),
			'notes' => $this->input->post('notes', TRUE) ?: NULL,
		));
		$this->session->set_flashdata('success', t('updated_msg'));
		redirect('daily_feeding');
	}

	public function delete($id)
	{
		$this->daily_feeding_model->delete($id);
		$this->session->set_flashdata('success', t('deleted_msg'));
		redirect('daily_feeding');
	}
}
