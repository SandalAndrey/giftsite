<?php
class ModelCatalogBossRefinesearch extends Model {
	public function createdb(){
		$sqls[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "filter_image` (
		  `filter_group_id` int(11) NOT NULL,
		  `filter_id` int(11) NOT NULL,
		  `image` varchar(255) DEFAULT NULL,
		  PRIMARY KEY (`filter_group_id`,`filter_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		
		$sqls[] = "INSERT INTO `" . DB_PREFIX . "category_filter` (`category_id`, `filter_id`) SELECT `rs`.`path_id`, `rs`.`filter_id` FROM (SELECT `cp`.`path_id`, `pf`.`filter_id` FROM `" . DB_PREFIX . "product_filter` pf LEFT JOIN `" . DB_PREFIX . "product_to_category` ptc ON (`pf`.`product_id` = `ptc`.`product_id`) LEFT JOIN `" . DB_PREFIX . "category_path` cp ON (`cp`.`category_id` = `ptc`.`category_id`) GROUP BY `path_id`,`filter_id`) rs LEFT JOIN `" . DB_PREFIX . "category_filter` cf ON (`cf`.`category_id` = `rs`.`path_id`) AND (`cf`.`filter_id` = `rs`.`filter_id`) WHERE `cf`.`filter_id` IS NULL";
		
		foreach ($sqls as $sql) {
			$this->db->query($sql);
		}
	}
	
	public function addFilter($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_group` SET sort_order = '" . (int)$data['sort_order'] . "'");

		$filter_group_id = $this->db->getLastId();

		foreach ($data['filter_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "filter_group_description SET filter_group_id = '" . (int)$filter_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['filter'])) {
			foreach ($data['filter'] as $filter) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$filter['sort_order'] . "'");

				$filter_id = $this->db->getLastId();

				foreach ($filter['filter_description'] as $language_id => $filter_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filter_description SET filter_id = '" . (int)$filter_id . "', language_id = '" . (int)$language_id . "', filter_group_id = '" . (int)$filter_group_id . "', name = '" . $this->db->escape($filter_description['name']) . "'");
				}
				$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_image` SET filter_group_id = '" . (int)$filter_group_id . "', filter_id='". (int)$filter_id . "', image='". $this->db->escape($filter['image']) . "'");
			}
		}
		
		$filter_image_id = $this->db->getLastId();

		return $filter_image_id;
	}

	public function editFilter($filter_group_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "filter_group` SET sort_order = '" . (int)$data['sort_order'] . "' WHERE filter_group_id = '" . (int)$filter_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "filter_group_description WHERE filter_group_id = '" . (int)$filter_group_id . "'");

		foreach ($data['filter_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "filter_group_description SET filter_group_id = '" . (int)$filter_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "filter WHERE filter_group_id = '" . (int)$filter_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "filter_description WHERE filter_group_id = '" . (int)$filter_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "filter_image WHERE filter_group_id = '" . (int)$filter_group_id . "'");


		if (isset($data['filter'])) {
			foreach ($data['filter'] as $filter) {
				if ($filter['filter_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_id = '" . (int)$filter['filter_id'] . "', filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$filter['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$filter['sort_order'] . "'");
				}

				$filter_id = $this->db->getLastId();

				foreach ($filter['filter_description'] as $language_id => $filter_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filter_description SET filter_id = '" . (int)$filter_id . "', language_id = '" . (int)$language_id . "', filter_group_id = '" . (int)$filter_group_id . "', name = '" . $this->db->escape($filter_description['name']) . "'");
				}
				if ($filter['filter_id']) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_image` SET filter_group_id = '" . (int)$filter_group_id . "', filter_id='". (int)$filter['filter_id'] . "', image='". $this->db->escape($filter['image']) . "'");
				} else {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_image` SET filter_group_id = '" . (int)$filter_group_id . "', filter_id='". (int)$filter_id . "', image='". $this->db->escape($filter['image']) . "'");
				}

			}
		}
	}
	
	public function deleteFilter($filter_group_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter_image` WHERE filter_group_id = '" . (int)$filter_group_id . "'");
	}

	public function getFilterGroup($filter_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "filter_image`  WHERE filter_id = '" . (int)$filter_id . "'");

		return $query->row;
	}

}
