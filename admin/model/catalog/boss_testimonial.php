<?php
class ModelCatalogBossTestimonial extends Model {

	public function addTestimonial($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial SET name='".$this->db->escape($data['name'])."', avatar = '".$this->db->escape($data['avatar'])."', city = '".$this->db->escape($data['city'])."', status = '" . (int)$data['status'] . "',rating = '".(int)$data['rating'] . "',date_added = '" . $this->db->escape($data['date_added']) . "',email='" . $this->db->escape($data['email']) . "'");

		$testimonial_id = $this->db->getLastId();

		foreach ($data['testimonial_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_description SET testimonial_id = '" . (int)$testimonial_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

	}

	public function editTestimonial($testimonial_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET name='".$this->db->escape($data['name'])."', avatar = '".$this->db->escape($data['avatar'])."', city = '".$this->db->escape($data['city'])."', status = '" . (int)$data['status'] . "',date_added = '".$this->db->escape($data['date_added']). "',rating = '".(int)$data['rating']."',email='". $this->db->escape($data['email']) ."' WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_description WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($data['testimonial_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_description SET testimonial_id = '" . (int)$testimonial_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

	}

	public function deleteTestimonial($testimonial_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_description WHERE testimonial_id = '" . (int)$testimonial_id . "'");
	}

	public function getTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		return $query->row;
	}

	public function getTestimonials($data = array()) {

		if ($data) {
			if (!isset($data['language_id']))  $data['language_id']=$this->config->get('config_language_id');
			$sql = "SELECT * FROM " . DB_PREFIX . "testimonial t LEFT JOIN " . DB_PREFIX . "testimonial_description td ON (t.testimonial_id = td.testimonial_id) where language_id = " . $data['language_id'];

			$sort_data = array(
				'td.description',
				'td.title',
				't.name',
				't.date_added',
				't.status'
			);



			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY td.description";
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
			//print_r($sql);exit;
			$query = $this->db->query($sql);



			return $query->rows;
		} else {

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial t LEFT JOIN " . DB_PREFIX . "testimonial_description td ON (t.testimonial_id = td.testimonial_id) WHERE td.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY td.title");

			$testimonial_data = $query->rows;


			return $testimonial_data;
		}
	}

	public function getTestimonialDescriptions($testimonial_id) {
		$testimonial_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_description WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($query->rows as $result) {
			$testimonial_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description']
			);
		}

		return $testimonial_description_data;
	}

	public function isTableExists() {

		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "testimonial'");
		if (count($query->rows) == 0)
			return FALSE;
		else
			return TRUE;


	}


	public function getTotalTestimonials() {
		if ($this->isTableExists() == false)
			return -1;

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "testimonial");

		return $query->row['total'];
	}

	public function getCurrentDateTime() {
		$query = $this->db->query("SELECT NOW() AS cdatetime ");

		return $query->row['cdatetime'];
	}



	public function createDatabaseTables() {
		$sql[] = "DROP TABLE IF EXISTS `".DB_PREFIX."testimonial`";
		$sql[] = "DROP TABLE IF EXISTS `".DB_PREFIX."testimonial_description`";
		
		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."testimonial` (
		  `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
		  `avatar` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
		  `city` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
		  `email` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
		  `status` int(1) NOT NULL DEFAULT '0',
		  `rating` int(1) NOT NULL DEFAULT '0',
		  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (`testimonial_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
		
		$sql[] = "INSERT INTO `".DB_PREFIX."testimonial` (`testimonial_id`, `name`, `avatar`, `city`, `email`, `status`, `rating`, `date_added`) VALUES
		(1, 'Xakurata', 'catalog/bt_description/user.png', 'San Diego', 'xakurata@hotmail.com', 1, 5, '2017-03-14 09:05:46'),
		(2, 'Xakurata', 'catalog/bt_description/user.png', 'San Diego', 'xakurata@hotmail.com', 1, 3, '2017-03-14 09:25:48');";
		
		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."testimonial_description` (
		  `testimonial_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `title` varchar(64) NOT NULL DEFAULT '',
		  `description` text NOT NULL,
		  PRIMARY KEY (`testimonial_id`,`language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		
		$sql[] = "INSERT INTO `oc_testimonial_description` (`testimonial_id`, `language_id`, `title`, `description`) VALUES
		(2, 1, 'Aliquam', 'Aliquam quis risus viverra sum masset congue tellus tibulum nunct. Lorem ipsum dolor sit amet assa tetur Fusce fringilla faucibus hendrerit.'),
		(1, 1, 'Aliquam', 'Aliquam quis risus viverra sum masset congue tellus tibulum nunct. Lorem ipsum dolor sit amet assa tetur Fusce fringilla faucibus hendrerit.'),
		(2, 2, 'Aliquam', '<p>Aliquam quis risus viverra sum masset congue tellus tibulum nunct. Lorem ipsum dolor sit amet assa tetur Fusce fringilla faucibus hendrerit.<br></p>'),
		(1, 2, 'Aliquam', '<p>Aliquam quis risus viverra sum masset congue tellus tibulum nunct. Lorem ipsum dolor sit amet assa tetur Fusce fringilla faucibus hendrerit.<br></p>');";
		
		foreach ($sql as $query) {
			$this->db->query($query);
		}
	}

	public function dropDatabaseTables() {
		$sql = "DROP TABLE IF EXISTS `".DB_PREFIX."testimonial`;";
		$this->db->query($sql);
		$sql = "DROP TABLE IF EXISTS `".DB_PREFIX."testimonial_description`;";
		$this->db->query($sql);
	}

}
?>