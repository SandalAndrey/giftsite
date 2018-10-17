<?php
class ModelBossthemesUtilities extends Model {
	public function getOptionValue($option_value_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$option_value_id ."'");
		
		return $query->row;
	}
	
	public function getDiscount($product_id = 0, $quantity = 0) {
		$customer_group_id = 1;
		
		$query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->customer->getGroupId() . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

		if ($query->num_rows) {
			return $query->row['price'];
		} else {
			return false;
		}
	}
}