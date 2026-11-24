<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food_type_model extends CI_Model
{
	protected $table = 'food_types';

	public function get_all()
	{
		return $this->db->order_by('sort_order', 'ASC')->order_by('id', 'ASC')->get($this->table)->result();
	}

	public function get_stock_summary()
	{
		$sql = "
			SELECT
				ft.id,
				ft.name,
				ft.sort_order,
				COALESCE(p.purchased_kg, 0) AS purchased_kg,
				COALESCE(p.purchased_cost, 0) AS purchased_cost,
				COALESCE(f.consumed_kg, 0) AS consumed_kg,
				(COALESCE(p.purchased_kg, 0) - COALESCE(f.consumed_kg, 0)) AS stock_kg
			FROM food_types ft
			LEFT JOIN (
				SELECT food_type_id, SUM(quantity_kg) AS purchased_kg, SUM(total_amount) AS purchased_cost
				FROM food_purchases
				GROUP BY food_type_id
			) p ON p.food_type_id = ft.id
			LEFT JOIN (
				SELECT food_type_id, SUM(quantity_kg) AS consumed_kg
				FROM daily_feeding
				GROUP BY food_type_id
			) f ON f.food_type_id = ft.id
			ORDER BY ft.sort_order ASC, ft.id ASC
		";
		return $this->db->query($sql)->result();
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
		$used_p = $this->db->where('food_type_id', (int) $id)->count_all_results('food_purchases');
		$used_f = $this->db->where('food_type_id', (int) $id)->count_all_results('daily_feeding');
		if ($used_p > 0 || $used_f > 0)
		{
			return FALSE;
		}
		$this->db->where('id', (int) $id)->delete($this->table);
		return $this->db->affected_rows();
	}
}
