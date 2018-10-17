<?php

class ControllerExtensionModuleBossInstagram extends Controller {
    public function index($setting = array()) {
		$this->document->addScript('catalog/view/javascript/bossthemes/instafeed.min.js');

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_instagram.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_instagram.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_instagram.css');
		}

		$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.css');

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css');
		} else {
			$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.theme.default.min.css');
		}

		$this->document->addScript('catalog/view/javascript/jquery/swiper/js/swiper.jquery.min.js');

		$data['user_id'] = (isset($setting['user_id'])) ? $setting['user_id'] : 0;
		$data['client_id'] = (isset($setting['client_id'])) ? $setting['client_id'] : 0;
		$data['token'] = (isset($setting['token'])) ? $setting['token'] : '';
		$data['limit'] = (isset($setting['limit'])) ? $setting['limit'] : 10;

		$language_id = (int)$this->config->get('config_language_id');
		$data['title'] = (isset($setting['title'][$language_id])) ? $setting['title'][$language_id] : '';
		$data['description'] = (isset($setting['description'][$language_id])) ? html_entity_decode($setting['description'][$language_id]) : '';

        return $this->load->view('extension/module/boss_instagram', $data);
    }
}