<?php
//-----------------------------------------------------
// TagCloud for Opencart v1.5.3    
// Created by villagedefrance                          
// contact@villagedefrance.net                                    
//-----------------------------------------------------

class ModelBossblogBlogTagCloud extends Model {

	public function getRandomTags($limit = 5, $min_font_size = 9, $max_font_size = 25, $font_weight) {
		$blog_article_id	= array();
		$names			= array();
		$totals			= array();
		$tags			= array();
		$blogtagcloud		= false;
		
		$tagNameQuery = $this->db->query("SELECT DISTINCT tag FROM " . DB_PREFIX . "blog_article_description WHERE language_id=" . (int)$this->config->get('config_language_id'));

		if (count($tagNameQuery->rows) > 0) {
			foreach ($tagNameQuery->rows as $row) {
				if($row['tag']){
					$names = explode(',', $row['tag']);
					$totals = array_merge($totals, $names);
				}
			}
			$tags = array_slice($totals, 0, $limit); 
			if($tags){
				$blogtagcloud = $this->generateBlogTagCloud($tags, true, $min_font_size, $max_font_size, $font_weight);
			}
		}
		
		return $blogtagcloud;
	}

	private function generateBlogTagCloud($tags, $resize = true, $min_font_size = 9, $max_font_size = 25, $font_weight) {

		if ($resize == true) {
			arsort($tags);

			$max_qty = max(array_keys($tags));
			$min_qty = min(array_keys($tags));

			$spread = $max_qty - $min_qty;

			if ($spread == 0) { $spread = 1; }

			$step = ((int)$max_font_size - (int)$min_font_size) / ($spread);

			$cloud = array();

			foreach ($tags as $key => $value) {
				$size=rand((int)$min_font_size,(int)$max_font_size);
			
				$cloud[] = '<a href="' . $this->url->link('bossblog/blogsearch', 'filter_tag=' . $value) . '" style="text-decoration:none;font-size:' . $size . 'px;font-weight:' . $font_weight . ';" title="">' . $value . '</a> ';
			}
			
		} else {
		
			foreach ($tags as $key => $value) {
				$cloud[] = '<a href="' . $this->url->link('bossblog/blogsearch', 'filter_tag=' . $value) . '" style="text-decoration:none;" title="">' . $value . '</a> ';
			}
		}

		$blogtagcloud = '';

		shuffle($cloud);

		for ($x = 0; $x < count($cloud); $x++) {
			$blogtagcloud .= $cloud[$x];
		}

		return $blogtagcloud;
	}
	public function checkModule($code) {					
		$result = $this->db->query("Select *from " . DB_PREFIX . "extension where code = '" . $this->db->escape($code) . "'");
		if($result->num_rows)
			return true;
		return false;
   	}
}
?>