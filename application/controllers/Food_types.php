<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food_types extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('food_type_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = array(
			'title' => t('food_types'),
			'rows' => $this->food_type_model->get_stock_summary(),
		);
		$this->load->view('template/header', $data);
		$this->load->view('food_types/index', $data);
		$this->load->view('template/footer', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('name', t('name'), 'required|max_length[120]|is_unique[food_types.name]');
		$this->form_validation->set_rules('sort_order', t('sort_order'), 'integer');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array('title' => t('new_food_type'));
			$this->load->view('template/header', $data);
			$this->load->view('food_types/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$this->food_type_model->create(array(
			'name' => $this->input->post('name', TRUE),
			'sort_order' => (int) $this->input->post('sort_order', TRUE),
		));
		$this->session->set_flashdata('success', t('saved_msg'));
		redirect('food_types');
	}

	public function edit($id = NULL)
	{
		$row = $this->food_type_model->get_by_id($id);
		if ( ! $row)
		{
			show_404();
		}

		$this->form_validation->set_rules('name', t('name'), 'required|max_length[120]');
		$this->form_validation->set_rules('sort_order', t('sort_order'), 'integer');

		if ($this->form_validation->run() === FALSE)
		{
			$data = array(
				'title' => t('edit_food_type'),
				'row' => $row,
			);
			$this->load->view('template/header', $data);
			$this->load->view('food_types/form', $data);
			$this->load->view('template/footer', $data);
			return;
		}

		$name = $this->input->post('name', TRUE);
		$dup = $this->db->where('name', $name)->where('id !=', (int) $id)->count_all_results('food_types');
		if ($dup > 0)
		{
			$this->session->set_flashdata('error', t('dup_name_err'));
			redirect('food_types/edit/'.$id);
		}

		$this->food_type_model->update($id, array(
			'name' => $name,
			'sort_order' => (int) $this->input->post('sort_order', TRUE),
		));
		$this->session->set_flashdata('success', t('updated_msg'));
		redirect('food_types');
	}

	public function delete($id)
	{
		if ( ! $this->food_type_model->delete($id))
		{
			$this->session->set_flashdata('error', t('in_use_err'));
		}
		else
		{
			$this->session->set_flashdata('success', t('deleted_msg'));
		}
		redirect('food_types');
	}
}
