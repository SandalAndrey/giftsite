<?php
class ControllerExtensionBossthemesSocial extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('extension/bossthemes/social');
		$this->load->model('setting/setting');
		
		$data = (isset($data)) ? array_merge($data, $this->language->all()) : $this->language->all();
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->document->addScript('view/javascript/bossthemes/fontawesome-iconpicker/fontawesome-iconpicker.min.js');
		$this->document->addStyle('view/javascript/bossthemes/fontawesome-iconpicker/fontawesome-iconpicker.min.css');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_social', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/bossthemes/social', 'user_token=' . $this->session->data['user_token'], 'SSL'));
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['boss_social'])) {
			$data['error_boss_social'] = $this->error['boss_social'];
		} else {
			$data['error_boss_social'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=bossthemes', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/bossthemes/social', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['action'] = $this->url->link('extension/bossthemes/social', 'user_token=' . $this->session->data['user_token'], 'SSL');
		if (isset($this->request->post['boss_social'])) {
			$boss_socials = $this->request->post['boss_social'];
		} elseif ($this->config->get('boss_social')) {
			$boss_socials = $this->config->get('boss_social');
		} else {
			$boss_socials = array();
		}
		
		$data['boss_socials'] = array();
		
		$this->load->model('tool/image');
		
		foreach ($boss_socials as $boss_social) {
			if (is_file(DIR_IMAGE . $boss_social['image'])) {
				$image = $boss_social['image'];
				$thumb = $boss_social['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}
			
			$data['boss_socials'][] = array(
				'name'                     => $boss_social['name'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100),
				'icon'                     => $boss_social['icon'],
				'link'                     => $boss_social['link'],
				'sort_order'               => $boss_social['sort_order']
			);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$sort_order = array();

		foreach ($data['boss_socials'] as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $data['boss_socials']);
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->config->set('template_engine', 'template');
		$data['topbar'] = $this->load->controller('extension/bossthemes/topbar');
		$data['sidebar'] = $this->load->controller('extension/bossthemes/sidebar');
		
		$this->config->set('template_engine', 'twig');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->config->set('template_engine', 'template');

		$this->response->setOutput($this->load->view('extension/bossthemes/social', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/bossthemes/social')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['boss_social'])) {
			foreach ($this->request->post['boss_social'] as $boss_social_id => $boss_social) {
				foreach ($boss_social['name'] as $language_id => $name) {
					if ((utf8_strlen($name) < 1) || (utf8_strlen($name) > 128)) {
						$this->error['boss_social'][$boss_social_id][$language_id] = $this->language->get('error_boss_social');
					}
				}
			}
		}
		
		return !$this->error;
	}
}
