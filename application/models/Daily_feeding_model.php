<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_feeding_model extends CI_Model
{
	protected $table = 'daily_feeding';

	public function get_all_with_type()
	{
		$this->db->select('daily_feeding.*, food_types.name AS food_type_name');
		$this->db->from($this->table);
		$this->db->join('food_types', 'food_types.id = daily_feeding.food_type_id');
		$this->db->order_by('daily_feeding.feeding_date', 'DESC');
		$this->db->order_by('daily_feeding.id', 'DESC');
		return $this->db->get()->result();
	}

	public function get_all_with_type_filtered($start = NULL, $end = NULL)
	{
		$this->db->select('daily_feeding.*, food_types.name AS food_type_name');
		$this->db->from($this->table);
		$this->db->join('food_types', 'food_types.id = daily_feeding.food_type_id');
		if ($start !== NULL && $end !== NULL)
		{
			$this->db->where('daily_feeding.feeding_date >=', $start);
			$this->db->where('daily_feeding.feeding_date <=', $end);
		}
		$this->db->order_by('daily_feeding.feeding_date', 'DESC');
		$this->db->order_by('daily_feeding.id', 'DESC');
		return $this->db->get()->result();
	}

	public function sum_quantity_filtered($start = NULL, $end = NULL)
	{
		if ($start === NULL || $end === NULL)
		{
			$this->db->select_sum('quantity_kg', 'total');
			$row = $this->db->get($this->table)->row();
			return $row && $row->total !== NULL ? (float) $row->total : 0.0;
		}
		$this->db->select_sum('quantity_kg', 'total');
		$this->db->where('feeding_date >=', $start);
		$this->db->where('feeding_date <=', $end);
		$row = $this->db->get($this->table)->row();
		return $row && $row->total !== NULL ? (float) $row->total : 0.0;
	}

	/** সাম্প্রতিক N দিনের খাদ্য ব্যবহার (ধরন অনুযায়ী গ্রুপ) */
	public function consumption_by_type_since($days = 30)
	{
		$since = date('Y-m-d', strtotime('-'.(int) $days.' days'));
		$this->db->select('food_types.name AS food_type_name, SUM(daily_feeding.quantity_kg) AS total_kg');
		$this->db->from($this->table);
		$this->db->join('food_types', 'food_types.id = daily_feeding.food_type_id');
		$this->db->where('daily_feeding.feeding_date >=', $since);
		$this->db->group_by('daily_feeding.food_type_id');
		$this->db->order_by('food_types.sort_order', 'ASC');
		return $this->db->get()->result();
	}

	/** নির্দিষ্ট তারিখের জন্য সারি */
	public function get_by_date($date)
	{
		$this->db->select('daily_feeding.*, food_types.name AS food_type_name');
		$this->db->from($this->table);
		$this->db->join('food_types', 'food_types.id = daily_feeding.food_type_id');
		$this->db->where('daily_feeding.feeding_date', $date);
		$this->db->order_by('food_types.sort_order', 'ASC');
		return $this->db->get()->result();
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
