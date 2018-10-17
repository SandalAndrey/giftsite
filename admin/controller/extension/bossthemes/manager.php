<?php
class ControllerExtensionBossthemesManager extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('extension/bossthemes/manager');
		$this->load->model('setting/setting');
		
		$data = (isset($data)) ? array_merge($data, $this->language->all()) : $this->language->all();
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_manager', $this->request->post);
			$this->model_setting_setting->editSetting('boss_product', $this->request->post);
			$this->model_setting_setting->editSetting('boss_category', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/bossthemes/manager', 'user_token=' . $this->session->data['user_token'], 'SSL'));
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'href' => $this->url->link('extension/bossthemes/manager', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['action'] = $this->url->link('extension/bossthemes/manager', 'user_token=' . $this->session->data['user_token'], 'SSL');
		
		if (isset($this->request->post['boss_manager'])) {
			$data['boss_manager'] = $this->request->post['boss_manager'];
		} else {
			$data['boss_manager'] = $this->config->get('boss_manager');
		}
		
		if (isset($this->request->post['boss_product'])) {
			$data['boss_product'] = $this->request->post['boss_product'];
		} else {
			$data['boss_product'] = $this->config->get('boss_product');
		}
		
		if (isset($this->request->post['boss_category'])) {
			$data['boss_category'] = $this->request->post['boss_category'];
		} else {
			$data['boss_category'] = $this->config->get('boss_category');
		}
		
		$this->config->set('template_engine', 'template');
		$data['topbar'] = $this->load->controller('extension/bossthemes/topbar');
		$data['sidebar'] = $this->load->controller('extension/bossthemes/sidebar');
		
		$this->config->set('template_engine', 'twig');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->config->set('template_engine', 'template');

		$this->response->setOutput($this->load->view('extension/bossthemes/manager', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/bossthemes/manager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
