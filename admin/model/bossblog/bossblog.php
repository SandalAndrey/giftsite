<?php
class ModelBossblogBossblog extends Model {
	public function dropBlog(){
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article`, `" . DB_PREFIX . "blog_article_category`, `" . DB_PREFIX . "blog_article_description`, `" . DB_PREFIX . "blog_article_layout`, `" . DB_PREFIX . "blog_article_related`, `" . DB_PREFIX . "blog_article_store`, `" . DB_PREFIX . "blog_category`, `" . DB_PREFIX . "blog_category_description`, `" . DB_PREFIX . "blog_category_layout`, `" . DB_PREFIX . "blog_category_store`, `" . DB_PREFIX . "blog_comment`, `" . DB_PREFIX . "blog_product_related`");
	}
	public function checkBlogCode($type, $code) {	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE type = '" . $this->db->escape($type) . "'AND code = '" . $this->db->escape($code) . "'");
		
		if($query->rows) {
			return true;
		}else {
			return false;
		}
	}
	
	public function getSeoUrl($query) {
		$seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = '" . $this->db->escape($query) . "'");

		foreach ($query->rows as $result) {
			$seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $seo_url_data;
	}
	
	public function editSeoUrl($query, $seo_url){
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = '" . $this->db->escape($query) . "'");
		
		if ($seo_url) {
			foreach ($seo_url as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (trim($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = '" . $this->db->escape($query) . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}
	}
}