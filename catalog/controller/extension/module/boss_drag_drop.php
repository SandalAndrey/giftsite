<?php  
class ControllerExtensionModuleBossDragDrop extends Controller {
	public function index($setting) { 
		if(empty($setting)) return;

		$this->document->addScript('catalog/view/javascript/bossthemes/dragdrop/jquery.event.drag-2.2.js');
		$this->document->addScript('catalog/view/javascript/bossthemes/ui/jquery-ui.min.js');

		$this->document->addStyle('catalog/view/javascript/bossthemes/ui/jquery-ui.min.css');

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_drag_drop.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_drag_drop.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_drag_drop.css');
		}

		$data['selecters'] = array();
		$data['selecters'] = explode(",", html_entity_decode($setting['classes'], ENT_QUOTES, 'UTF-8'));

		$language_id = (int)$this->config->get('config_language_id');

		$data['seo_data'] = array();
		$data['type_product'] = $setting['type_product'];
		$data['title'] = (isset($setting['module_language'][$language_id]['title'])) ? $setting['module_language'][$language_id]['title'] : '';
		$data['description'] = (isset($setting['module_language'][$language_id]['description'])) ? $setting['module_language'][$language_id]['description'] : '';
		$data['handle'] = (isset($setting['module_language'][$language_id]['handle'])) ? $setting['module_language'][$language_id]['handle'] : '';

		$this->load->model('catalog/product');
		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/boss_drag_drop');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		$seo_url_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query LIKE 'product_id=%' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($seo_url_query->rows as $seo_url) {
			$data['seo_data'][]= array(
				'query' => $seo_url['query'],
				'keyword' => $seo_url['keyword']
			);
		}

		return $this->load->view('extension/module/boss_drag_drop', $data);
	}
}