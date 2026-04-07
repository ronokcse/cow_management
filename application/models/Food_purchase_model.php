<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food_purchase_model extends CI_Model
{
	protected $table = 'food_purchases';

	public function sum_total()
	{
		$this->db->select_sum('total_amount', 'total');
		$row = $this->db->get($this->table)->row();
		return $row && $row->total !== NULL ? (float) $row->total : 0.0;
	}

	public function get_all_with_type()
	{
		$this->db->select('food_purchases.*, food_types.name AS food_type_name');
		$this->db->from($this->table);
		$this->db->join('food_types', 'food_types.id = food_purchases.food_type_id');
		$this->db->order_by('food_purchases.purchase_date', 'DESC');
		$this->db->order_by('food_purchases.id', 'DESC');
		return $this->db->get()->result();
	}

	public function get_all_with_type_filtered($start = NULL, $end = NULL)
	{
		$this->db->select('food_purchases.*, food_types.name AS food_type_name');
		$this->db->from($this->table);
		$this->db->join('food_types', 'food_types.id = food_purchases.food_type_id');
		if ($start !== NULL && $end !== NULL)
		{
			$this->db->where('food_purchases.purchase_date >=', $start);
			$this->db->where('food_purchases.purchase_date <=', $end);
		}
		$this->db->order_by('food_purchases.purchase_date', 'DESC');
		$this->db->order_by('food_purchases.id', 'DESC');
		return $this->db->get()->result();
	}

	public function sum_total_filtered($start = NULL, $end = NULL)
	{
		if ($start === NULL || $end === NULL)
		{
			return $this->sum_total();
		}
		$this->db->select_sum('total_amount', 'total');
		$this->db->where('purchase_date >=', $start);
		$this->db->where('purchase_date <=', $end);
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
