<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food_type_model extends CI_Model
{
	protected $table = 'food_types';

	public function get_all()
	{
		return $this->db->order_by('sort_order', 'ASC')->order_by('id', 'ASC')->get($this->table)->result();
	}

	public function get_by_id($id)
	{
		return $this->db->get_where($this->table, array('id' => (int) $id))->row();
	}

	public function create(array $data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, array $data)
	{
		$this->db->where('id', (int) $id)->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->where('id', (int) $id)->delete($this->table);
		return $this->db->affected_rows();
	}
}
