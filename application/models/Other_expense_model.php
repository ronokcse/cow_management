<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other_expense_model extends CI_Model
{
	protected $table = 'other_expenses';

	public function sum_total()
	{
		$this->db->select_sum('amount', 'total');
		$row = $this->db->get($this->table)->row();
		return $row && $row->total !== NULL ? (float) $row->total : 0.0;
	}

	public function get_all()
	{
		return $this->db->order_by('expense_date', 'DESC')->order_by('id', 'DESC')->get($this->table)->result();
	}

	public function get_all_filtered($start = NULL, $end = NULL)
	{
		if ($start !== NULL && $end !== NULL)
		{
			$this->db->where('expense_date >=', $start);
			$this->db->where('expense_date <=', $end);
		}
		return $this->db->order_by('expense_date', 'DESC')->order_by('id', 'DESC')->get($this->table)->result();
	}

	public function sum_amount_filtered($start = NULL, $end = NULL)
	{
		if ($start === NULL || $end === NULL)
		{
			return $this->sum_total();
		}
		$this->db->select_sum('amount', 'total');
		$this->db->where('expense_date >=', $start);
		$this->db->where('expense_date <=', $end);
		$row = $this->db->get($this->table)->row();
		return $row && $row->total !== NULL ? (float) $row->total : 0.0;
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
