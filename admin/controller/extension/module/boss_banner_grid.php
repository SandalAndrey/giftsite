<?php
class ControllerExtensionModuleBossBannerGrid extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('extension/extension/module');
		$this->load->language('extension/module/boss_banner_grid');
		$this->load->model('setting/module');
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');
		
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_install'] = $this->language->get('button_install');
		$data['button_uninstall'] = $this->language->get('button_uninstall');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/boss_banner_grid', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);
		
		$modules = $this->model_setting_module->getModulesByCode('boss_banner_grid');
		
		$data['modules'] = array();
		
		foreach ($modules as $module) {
			$data['modules'][] = array(
				'module_id' => $module['module_id'],
				'name'      => $this->language->get('heading_title') . ' &gt; ' . $module['name'],
				'edit'      => $this->url->link('extension/module/boss_banner_grid/edit', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $module['module_id'], 'SSL'),
				'delete'    => $this->url->link('extension/extension/module/delete', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $module['module_id'], 'SSL')
			);
		}
		
		$data['edit'] = $this->url->link('extension/module/boss_banner_grid/edit', 'user_token=' . $this->session->data['user_token'], 'SSL');
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
	
		$this->response->setOutput($this->load->view('extension/module/boss_banner_grid_list', $data));
	}
	
	public function edit() {
		$this->load->language('extension/module/boss_banner_grid');
		
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_banner_grid.css');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('boss_banner_grid', $this->request->post);
				
				$this->session->data['success'] = $this->language->get('text_success');
				
				$this->response->redirect($this->url->link('extension/module/boss_banner_grid', 'user_token=' . $this->session->data['user_token'], 'SSL'));
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
				
				$this->session->data['success'] = $this->language->get('text_success');

				$this->response->redirect($this->url->link('extension/module/boss_banner_grid', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL'));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_fixed'] = $this->language->get('text_fixed');
		$data['text_cover'] = $this->language->get('text_cover');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_per_row'] = $this->language->get('entry_per_row');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_banner'] = $this->language->get('entry_banner');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_autoplay'] = $this->language->get('entry_autoplay');
		$data['entry_effect'] = $this->language->get('entry_effect');
		$data['entry_auto'] = $this->language->get('entry_auto');
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['button_add'] = $this->language->get('button_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_banner'] = $this->language->get('tab_banner');

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
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_banner_grid/edit', 'user_token=' . $this->session->data['user_token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_banner_grid/edit', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/boss_banner_grid/edit', 'user_token=' . $this->session->data['user_token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/module/boss_banner_grid/edit', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/module/boss_banner_grid', 'user_token=' . $this->session->data['user_token'], 'SSL');

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
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['banners'])) {
			$data['banners'] = $this->request->post['banners'];
		} elseif (!empty($module_info)) {
			$data['banners'] = $module_info['banners'];
		} else {
			$data['banners'] = array();
		}
		
		foreach($data['banners'] as $key => $value){
			if($data['banners'][$key]['image'] && file_exists(DIR_IMAGE.$data['banners'][$key]['image'])){
				$data['banners'][$key]['thumb'] = $this->model_tool_image->resize($data['banners'][$key]['image'], 100, 100);
			}else{
				$data['banners'][$key]['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['per_row'])) {
			$data['per_row'] = $this->request->post['per_row'];
		} elseif (!empty($module_info)) {
			$data['per_row'] = $module_info['per_row'];
		} else {
			$data['per_row'] = 1;
		}
		
		if (isset($this->request->post['auto'])) {
			$data['auto'] = $this->request->post['auto'];
		} elseif (!empty($module_info)) {
			$data['auto'] = $module_info['auto'];
		} else {
			$data['auto'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/boss_banner_grid_form', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/boss_banner_grid')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}