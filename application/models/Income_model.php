<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income_model extends CI_Model
{
	protected $table = 'incomes';

	public function sum_total()
	{
		$this->db->select_sum('amount', 'total');
		$row = $this->db->get($this->table)->row();
		return $row && $row->total !== NULL ? (float) $row->total : 0.0;
	}

	public function get_all()
	{
		return $this->db->order_by('income_date', 'DESC')->order_by('id', 'DESC')->get($this->table)->result();
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
