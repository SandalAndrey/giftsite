<?php
class ModelBossthemesBossRefinesearch extends Model {
	public function getFilter($filter_id = 0) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id = '" . (int)$filter_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	public function getFilters($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "filter_group` fg LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'fgd.name',
			'fg.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY fgd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$filter_group_query = $this->db->query($sql);
		
		$filter_group_data = array();
		
		foreach ($filter_group_query->rows as $filter_group) {
			$filter_data = array();

			$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

			foreach ($filter_query->rows as $filter) {
				$filter_data[] = array(
					'filter_id' => $filter['filter_id'],
					'name'      => $filter['name']
				);
			}

			if ($filter_data) {
				$filter_group_data[] = array(
					'filter_group_id' => $filter_group['filter_group_id'],
					'name'            => $filter_group['name'],
					'filter'          => $filter_data
				);
			}
		}

		return $filter_group_data;
	}
	
	public function getFilterImage($filter_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter_image WHERE filter_id = '" . (int)$filter_id . "'");

		return $query->row;
	}
	public function getFilterByProductId($product_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_filter` pf  LEFT JOIN " . DB_PREFIX . "filter_image fi ON (fi.filter_id = pf.filter_id) LEFT JOIN " . DB_PREFIX . "filter_description fd ON (fd.filter_id = pf.filter_id) WHERE pf.product_id = '" . (int)$product_id . "' and fd.language_id='".(int)$this->config->get('config_language_id')."'");

		return $query->rows;
	}
}