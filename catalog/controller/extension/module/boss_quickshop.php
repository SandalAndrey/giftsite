<?php
class ControllerExtensionModuleBossQuickshop extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
		$data['selecters'] = array();
		$data['selecters'] = explode(",", html_entity_decode($setting['array_class_selected'], ENT_QUOTES, 'UTF-8'));

		$this->document->addScript('catalog/view/javascript/bossthemes/jquery.zoom.min.js');
		$this->document->addScript('catalog/view/javascript/bossthemes/jquery.jgrowl.min.js');

		$this->document->addScript('catalog/view/javascript/bossthemes/slick/slick.min.js');
		$this->document->addStyle('catalog/view/javascript/bossthemes/slick/slick.css');
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/slick-theme.css');

		$data['text'] = isset($setting['title'][$this->config->get('config_language_id')]) ? $setting['title'][$this->config->get('config_language_id')] : '';

		$data['width'] =  $setting['width'];

		$data['seo_data'] = array();

		$this->load->model('catalog/product');

		$seo_url_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query LIKE 'product_id=%' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($seo_url_query->rows as $seo_url) {
			$data['seo_data'][]= array(
				'query' => $seo_url['query'],
				'keyword' => $seo_url['keyword']
			);
		}

		return $this->load->view('extension/module/boss_quickshop', $data);
	}
}