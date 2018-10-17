<?php
class ControllerExtensionBossthemesTopBar extends Controller {
	public function index() {
		$data = array();
		$this->load->language('extension/bossthemes/header');
		
		$data = (isset($data)) ? array_merge($data, $this->language->all()) : $this->language->all();
		
		$this->document->addStyle('view/stylesheet/bossthemes/theme-manager/AdminLTE.css');
		$this->document->addStyle('view/stylesheet/bossthemes/theme-manager/skins/skin-blue.css');
		
		$this->document->addScript('view/javascript/bossthemes/theme-manager/app.js');
		
		$this->document->addScript('view/javascript/bossthemes/theme-manager/common.js');
		
		return $this->load->view('extension/bossthemes/topbar', $data);
	}
}