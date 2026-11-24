<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		if ($this->session->userdata('user_id'))
		{
			redirect('dashboard');
		}
		redirect('auth/login');
	}

	public function login()
	{
		if ($this->session->userdata('user_id'))
		{
			redirect('dashboard');
		}

		if ($this->input->method() === 'post')
		{
			$username = trim((string) $this->input->post('username', TRUE));
			$password = (string) $this->input->post('password');

			$user = $this->user_model->verify_login($username, $password);
			if ($user)
			{
				$this->session->set_userdata(array(
					'user_id'   => $user->id,
					'user_name' => $user->name,
					'username'  => $user->username,
				));
				$this->session->set_flashdata('success', 'সফলভাবে লগইন হয়েছে।');
				redirect('dashboard');
			}

			$this->session->set_flashdata('error', 'ইউজারনেম অথবা পাসওয়ার্ড সঠিক নয়।');
			redirect('auth/login');
		}

		$this->load->view('auth/login');
	}

	public function logout()
	{
		$this->session->unset_userdata(array('user_id', 'user_name', 'username'));
		$this->session->set_flashdata('success', 'সফলভাবে লগআউট হয়েছে।');
		redirect('auth/login');
	}
}
