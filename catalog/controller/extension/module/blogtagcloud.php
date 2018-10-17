<?php
class ControllerExtensionModuleBlogTagCloud extends Controller {

	public function index($setting) {
		if(empty($setting)) return;
		static $module = 0;

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/blogtagcloud');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		$boss_blogtagcloud = $setting['blogtagcloud_module'];
		$data['heading_title'] = isset($boss_blogtagcloud['title'][$this->config->get('config_language_id')])?$boss_blogtagcloud['title'][$this->config->get('config_language_id')]:'';

        if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_blog.css')){
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_blog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_blog.css');
		}

		$this->load->model('bossblog/blogtagcloud');

		$data['blogtagcloud'] = $this->model_bossblog_blogtagcloud->getRandomTags(
			$boss_blogtagcloud['limit'],
			(int)$boss_blogtagcloud['min_font_size'],
			(int)$boss_blogtagcloud['max_font_size'],
			$boss_blogtagcloud['font_weight']
		);

		$data['module'] = $module++;

		return $this->load->view('extension/module/blogtagcloud', $data);
	}
}
?>
