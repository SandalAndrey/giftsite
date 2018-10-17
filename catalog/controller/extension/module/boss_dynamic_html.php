<?php
class ControllerExtensionModuleBossDynamicHTML extends Controller {
	public function index($setting) {
		$this->document->addStyle($setting['css_link']);

		$language_id = $this->config->get('config_language_id');

		$data['html'] = (isset($setting['description'][$language_id])) ? html_entity_decode($setting['description'][$language_id], ENT_QUOTES, 'UTF-8') : '';

		return $this->load->view('extension/module/boss_dynamic_html', $data);
	}
}