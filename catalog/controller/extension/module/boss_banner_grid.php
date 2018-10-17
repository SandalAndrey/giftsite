<?php
class ControllerExtensionModuleBossBannerGrid extends Controller {
	public function index($setting) {
		static $module = 0;

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/image.hover.effect.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/image.hover.effect.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/image.hover.effect.css');
		}

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_banner_grid.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_banner_grid.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_banner_grid.css');
		}

		if ($setting['auto']) {
			$this->document->addScript('catalog/view/javascript/bossthemes/masonry.pkgd.min.js');
		}

		$data['per_row'] = $setting['per_row'];

		$data['auto'] = $setting['auto'];

		$data['banners'] = array();

		$language_id = $this->config->get('config_language_id');

		if ($this->request->server['HTTPS']) {
			$url = $this->config->get('config_ssl') . 'image/';
		} else {
			$url = $this->config->get('config_url') . 'image/';
		}

		if (!empty($setting['banners'])) {
			foreach ($setting['banners'] as $banner) {
				$data['banners'][] = array(
					'title' => $banner['title'],
					'image' => $url . $banner['image'],
					'link' => $banner['link'],
					'caption' => (isset($banner['caption'][$language_id])) ? html_entity_decode($banner['caption'][$language_id]) : '',
					'effect' => $banner['effect'],
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/boss_banner_grid', $data);
	}
}