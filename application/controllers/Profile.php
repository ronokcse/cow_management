<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$user_id = (int) $this->session->userdata('user_id');
		$user = $this->user_model->get_by_id($user_id);

		$data = array(
			'title' => 'প্রোফাইল',
			'user'  => $user,
		);

		$this->load->view('template/header', $data);
		$this->load->view('profile/index', $data);
		$this->load->view('template/footer');
	}

	public function update_name()
	{
		if ($this->input->method() !== 'post')
		{
			redirect('profile');
		}

		$user_id = (int) $this->session->userdata('user_id');
		$name = trim((string) $this->input->post('name', TRUE));

		if ($name === '')
		{
			$this->session->set_flashdata('error', 'নাম খালি রাখা যাবে না।');
			redirect('profile');
		}

		$this->user_model->update_profile($user_id, array('name' => $name));
		$this->session->set_userdata('user_name', $name);
		$this->session->set_flashdata('success', 'নাম সফলভাবে পরিবর্তন হয়েছে।');
		redirect('profile');
	}

	public function change_password()
	{
		if ($this->input->method() !== 'post')
		{
			redirect('profile');
		}

		$user_id = (int) $this->session->userdata('user_id');
		$user = $this->user_model->get_by_id($user_id);

		$current_password = (string) $this->input->post('current_password');
		$new_password     = (string) $this->input->post('new_password');
		$confirm_password = (string) $this->input->post('confirm_password');

		if (!$user || !password_verify($current_password, $user->password))
		{
			$this->session->set_flashdata('error', 'বর্তমান পাসওয়ার্ড সঠিক নয়।');
			redirect('profile');
		}

		if (strlen($new_password) < 6)
		{
			$this->session->set_flashdata('error', 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।');
			redirect('profile');
		}

		if ($new_password !== $confirm_password)
		{
			$this->session->set_flashdata('error', 'নতুন পাসওয়ার্ড এবং কনফার্ম পাসওয়ার্ড মিলছে না।');
			redirect('profile');
		}

		$hash = password_hash($new_password, PASSWORD_DEFAULT);
		$this->user_model->update_profile($user_id, array('password' => $hash));
		$this->session->set_flashdata('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে।');
		redirect('profile');
	}
}
