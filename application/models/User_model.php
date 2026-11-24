<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function get_by_username($username)
	{
		return $this->db->get_where('users', array('username' => $username))->row();
	}

	public function get_by_id($id)
	{
		return $this->db->get_where('users', array('id' => (int) $id))->row();
	}

	public function update_profile($id, $data)
	{
		$this->db->where('id', (int) $id);
		return $this->db->update('users', $data);
	}

	public function verify_login($username, $password)
	{
		$user = $this->get_by_username($username);
		if ($user && password_verify($password, $user->password))
		{
			return $user;
		}
		return FALSE;
	}
}
