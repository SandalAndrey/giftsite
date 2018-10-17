<?php

class ControllerExtensionModuleBossModuleLayout extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/boss_module_layout');
		
		$this->document->addStyle('view/javascript/bootstrap/css/bootstrap-switch.min.css');
		$this->document->addScript('view/javascript/bootstrap/js/bootstrap-switch.min.js');
		
		$this->document->addStyle('view/javascript/jquery/jquery-ui/jquery-ui.min.css');
		$this->document->addScript('view/javascript/jquery/jquery-ui/jquery-ui.min.js');
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_module_layout.css');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('boss_module_layout', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->cache->delete('product');

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_full_width'] = $this->language->get('text_full_width');
		$data['text_1170_px'] = $this->language->get('text_1170_px');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_num_cols'] = $this->language->get('entry_num_cols');
		$data['entry_col_sm'] = $this->language->get('entry_col_sm');
		$data['entry_col_xs'] = $this->language->get('entry_col_xs');
		$data['entry_class'] = $this->language->get('entry_class');
		$data['entry_width'] = $this->language->get('entry_width');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_module_layout', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_module_layout', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/boss_module_layout', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/boss_module_layout', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['raw'])) {
			$data['raw'] = $this->request->post['raw'];
		} elseif (!empty($module_info)) {
			$data['raw'] = $module_info['raw'];
		} else {
			$data['raw'] = '';
		}
		
		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (!empty($module_info)) {
			$data['publish'] = $module_info['publish'];
		} else {
			$data['publish'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$this->load->model('setting/extension');

		$this->load->model('setting/module');

		$data['extensions'] = array();

		// Get a list of installed modules
		$extensions = $this->model_setting_extension->getInstalled('module');

		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			if ($code != 'boss_module_layout') {
				$this->load->language('extension/module/' . $code);

				$module_data = array();

				$modules = $this->model_setting_module->getModulesByCode($code);

				foreach ($modules as $module) {
					$module_data[] = array(
						'name' => strip_tags($module['name']),
						'code' => $code . '.' .  $module['module_id']
					);
				}

				if ($this->config->has($code . '_status') || $module_data) {
					$data['extensions'][] = array(
						'name'   => strip_tags($this->language->get('heading_title')),
						'code'   => $code,
						'module' => $module_data
					);
				}
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/boss_module_layout', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/boss_module_layout')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}