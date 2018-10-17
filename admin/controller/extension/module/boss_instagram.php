<?php
class ControllerExtensionModuleBossInstagram extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/boss_instagram');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('boss_instagram', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_user_id'] = $this->language->get('entry_user_id');
		$data['entry_client_id'] = $this->language->get('entry_client_id');
		$data['entry_token'] = $this->language->get('entry_token');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['help_user_id'] = $this->language->get('help_user_id');
		$data['help_client_id'] = $this->language->get('help_client_id');
		$data['help_user_token'] = $this->language->get('help_user_token');
		$data['help_limit'] = $this->language->get('help_limit');
		
		$data['error_title'] = $this->language->get('error_title');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/boss_instagram', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		if (isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/boss_instagram', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/boss_instagram', 'user_token=' . $this->session->data['user_token'], true);
		}

		$data['cancel'] = $this->url->link('extension/module', 'user_token=' . $this->session->data['user_token'], true);
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		}else if (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		}else if (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['user_id'])) {
			$data['user_id'] = $this->request->post['user_id'];
		}else if (!empty($module_info)) {
			$data['user_id'] = $module_info['user_id'];
		} else {
			$data['user_id'] = '';
		}
		
		if (isset($this->request->post['client_id'])) {
			$data['client_id'] = $this->request->post['client_id'];
		}else if (!empty($module_info)) {
			$data['client_id'] = $module_info['client_id'];
		} else {
			$data['client_id'] = '';
		}
		
		if (isset($this->request->post['token'])) {
			$data['token'] = $this->request->post['token'];
		}else if (!empty($module_info)) {
			$data['token'] = $module_info['token'];
		} else {
			$data['token'] = '';
		}

		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		}else if (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = '';
		}
		
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		}else if (!empty($module_info)) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = array();
		}
		
		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		}else if (!empty($module_info)) {
			$data['description'] = $module_info['description'];
		} else {
			$data['description'] = array();
		}
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/boss_instagram', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/boss_instagram')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}