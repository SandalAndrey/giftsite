<?php
class ControllerExtensionBossthemesPayment extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('extension/bossthemes/payment');
		$this->load->model('setting/setting');
		
		$data = (isset($data)) ? array_merge($data, $this->language->all()) : $this->language->all();
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->document->addScript('view/javascript/bossthemes/fontawesome-iconpicker/fontawesome-iconpicker.min.js');
		$this->document->addStyle('view/javascript/bossthemes/fontawesome-iconpicker/fontawesome-iconpicker.min.css');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_payment', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/bossthemes/payment', 'user_token=' . $this->session->data['user_token'], 'SSL'));
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['boss_payment'])) {
			$data['error_boss_payment'] = $this->error['boss_payment'];
		} else {
			$data['error_boss_payment'] = '';
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
			'href' => $this->url->link('extension/bossthemes/payment', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['action'] = $this->url->link('extension/bossthemes/payment', 'user_token=' . $this->session->data['user_token'], 'SSL');
		
		if (isset($this->request->post['boss_payment'])) {
			$boss_payments = $this->request->post['boss_payment'];
		} elseif ($this->config->get('boss_payment')) {
			$boss_payments = $this->config->get('boss_payment');
		} else {
			$boss_payments = array();
		}
		
		$data['boss_payments'] = array();
		
		$this->load->model('tool/image');
		
		foreach ($boss_payments as $boss_payment) {
			if (is_file(DIR_IMAGE . $boss_payment['image'])) {
				$image = $boss_payment['image'];
				$thumb = $boss_payment['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}
			
			$data['boss_payments'][] = array(
				'name'                     => $boss_payment['name'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100),
				'icon'                     => $boss_payment['icon'],
				'link'                     => $boss_payment['link'],
				'sort_order'               => $boss_payment['sort_order']
			);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$sort_order = array();

		foreach ($data['boss_payments'] as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $data['boss_payments']);
		
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

		$this->response->setOutput($this->load->view('extension/bossthemes/payment', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/bossthemes/payment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['boss_payment'])) {
			foreach ($this->request->post['boss_payment'] as $boss_payment_id => $boss_payment) {
				foreach ($boss_payment['name'] as $language_id => $name) {
					if ((utf8_strlen($name) < 1) || (utf8_strlen($name) > 128)) {
						$this->error['boss_payment'][$boss_payment_id][$language_id] = $this->language->get('error_boss_payment');
					}
				}
			}
		}
		
		return !$this->error;
	}
}
