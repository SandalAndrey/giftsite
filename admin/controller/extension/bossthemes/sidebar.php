<?php
class ControllerExtensionBossthemesSidebar extends Controller {
	public function index() {
		$this->load->language('extension/bossthemes/sidebar');
		$data = (isset($data)) ? array_merge($data, $this->language->all()) : $this->language->all();
		
		// Menu
		$data['menus'][] = array(
			'id'       => 'bt-menu-manager',
			'icon'	   => '',
			'name'	   => $this->language->get('text_manager'),
			'route'    => 'extension/bossthemes/manager',
			'href'     => $this->url->link('extension/bossthemes/manager', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$data['menus'][] = array(
			'id'       => 'bt-menu-header',
			'icon'	   => '',
			'name'	   => $this->language->get('text_header'),
			'route'    => 'extension/bossthemes/header',
			'href'     => $this->url->link('extension/bossthemes/header', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$data['menus'][] = array(
			'id'       => 'bt-menu-footer',
			'icon'	   => '',
			'name'	   => $this->language->get('text_footer'),
			'route'    => 'extension/bossthemes/footer',
			'href'     => $this->url->link('extension/bossthemes/footer', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$data['menus'][] = array(
			'id'       => 'bt-menu-social',
			'icon'	   => '',
			'name'	   => $this->language->get('text_social'),
			'route'    => 'extension/bossthemes/social',
			'href'     => $this->url->link('extension/bossthemes/social', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$data['menus'][] = array(
			'id'       => 'bt-menu-payment',
			'icon'	   => '',
			'name'	   => $this->language->get('text_payment'),
			'route'    => 'extension/bossthemes/payment',
			'href'     => $this->url->link('extension/bossthemes/payment', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$data['menus'][] = array(
			'id'       => 'bt-menu-font-color',
			'icon'	   => '',
			'name'	   => $this->language->get('text_font_color'),
			'route'    => 'extension/bossthemes/customizer',
			'href'     => $this->url->link('extension/bossthemes/customizer', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$data['menus'][] = array(
			'id'       => 'bt-menu-custom',
			'icon'	   => '',
			'name'	   => $this->language->get('text_custom'),
			'route'    => 'extension/bossthemes/custom',
			'href'     => $this->url->link('extension/bossthemes/custom', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$data['menus'][] = array(
			'id'       => 'bt-menu-sample-data',
			'icon'	   => '',
			'name'	   => $this->language->get('text_sample_data'),
			'route'    => 'extension/bossthemes/sample_data',
			'href'     => $this->url->link('extension/bossthemes/sample_data', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$data['menus'][] = array(
			'id'       => 'bt-menu-xml',
			'icon'	   => '',
			'name'	   => $this->language->get('text_xml'),
			'route'    => 'extension/bossthemes/xml',
			'href'     => $this->url->link('extension/bossthemes/xml', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		
		$this->load->model('setting/extension');

		$data['modules'] = array();

		// Create a new language container so we don't pollute the current one
		$language = new Language($this->config->get('config_language'));
		
		// Compatibility code for old extension folders
		$files = glob(DIR_APPLICATION . 'controller/extension/module/boss*.php');

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				if ($extension != 'boss_manager') {
					$language->load('extension/module/' . $extension);
	
					$data['modules'][] = array(
						'name'      => $language->get('heading_title'),
						'id'        => 'bt-module-' . $extension,
						'edit'      => $this->url->link('extension/bossthemes/module', 'user_token=' . $this->session->data['user_token'] . '&module=' . $extension, true)
					);
				}
			}
		}

		$sort_order = array();

		foreach ($data['modules'] as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $data['modules']);
		
		$data['route'] = $this->request->get['route'];
		
		return $this->load->view('extension/bossthemes/sidebar', $data);
	}
}