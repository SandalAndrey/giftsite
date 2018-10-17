<?php
class ControllerExtensionModuleBossTagCloud extends Controller {
	public function index($setting) {
		static $module = 0;

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/boss_tagcloud');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_tagcloud.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_tagcloud.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_tagcloud.css');
		}

		if (isset($setting['boss_tagcloud_module'][$this->config->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['boss_tagcloud_module'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');

			$this->load->model('bossthemes/boss_tagcloud');

			$data['boss_tagcloud'] = $this->model_bossthemes_boss_tagcloud->getRandomTags(
				$setting['boss_tagcloud_module_limit'],
				(int)$setting['boss_tagcloud_module_min_size'],
				(int)$setting['boss_tagcloud_module_max_size'],
				$setting['boss_tagcloud_module_font_weight']
			);

			$data['module'] = $module++;

			return $this->load->view('extension/module/boss_tagcloud', $data);
		}
	}
}
?>
