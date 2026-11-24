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
			'title' => t('profile'),
			'user'  => $user,
		);

		$this->load->view('template/header', $data);
		$this->load->view('profile/index', $data);
		$this->load->view('template/footer', $data);
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
			$this->session->set_flashdata('error', t('err_name_empty'));
			redirect('profile');
		}

		$this->user_model->update_profile($user_id, array('name' => $name));
		$this->session->set_userdata('user_name', $name);
		$this->session->set_flashdata('success', t('msg_name_updated'));
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
			$this->session->set_flashdata('error', t('err_curr_pwd'));
			redirect('profile');
		}

		if (strlen($new_password) < 6)
		{
			$this->session->set_flashdata('error', t('err_pwd_len'));
			redirect('profile');
		}

		if ($new_password !== $confirm_password)
		{
			$this->session->set_flashdata('error', t('err_pwd_mismatch'));
			redirect('profile');
		}

		$hash = password_hash($new_password, PASSWORD_DEFAULT);
		$this->user_model->update_profile($user_id, array('password' => $hash));
		$this->session->set_flashdata('success', t('msg_pwd_updated'));
		redirect('profile');
	}
}
