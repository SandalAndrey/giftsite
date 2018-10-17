<?php
class ControllerExtensionModuleBlogSearch extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
        if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_blog.css')){
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_blog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_blog.css');
		}

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/blogsearch');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->load->view('extension/module/blogsearch', $data);
	}
}