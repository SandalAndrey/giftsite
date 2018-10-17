<?php
class ControllerExtensionModuleBossDynamicHTML extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/boss_dynamic_html');
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_dynamic_html.css');
		
		$this->document->addScript('view/javascript/bossthemes/jqColorPicker.min.js');
		
		$this->document->addScript('view/javascript/bossthemes/tinymce/jquery.tinymce.min.js');
		$this->document->addScript('view/javascript/bossthemes/tinymce/tinymce.min.js');
		$this->document->addScript('view/javascript/bossthemes/tinymce/plugins/table/plugin.min.js');
		$this->document->addScript('view/javascript/bossthemes/tinymce/plugins/paste/plugin.min.js');
		$this->document->addScript('view/javascript/bossthemes/tinymce/plugins/spellchecker/plugin.min.js');
		
		$this->document->addScript('view/javascript/bossthemes/ace/ace.js');
		$this->document->addScript('view/javascript/bossthemes/ace/theme-twilight.js');
		$this->document->addScript('view/javascript/bossthemes/ace/mode-html.js');
		$this->document->addScript('view/javascript/bossthemes/ace/mode-css.js');
		$this->document->addScript('view/javascript/bossthemes/ace/jquery-ace.js');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			foreach ($this->request->post['description'] as $index => $description) {
				$this->request->post['description'][$index] = str_replace('&lt;/img&gt;', '', $description);
			}
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('boss_dynamic_html', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			
			if (isset($this->request->get['module_id'])) {
				$module_id = $this->request->get['module_id'];
			} else {
				$module_id = $this->db->getLastId();
			}
			
			$css_storage = 'view/stylesheet/boss_dynamic_html' . $module_id . '.css';
			
			$directories = explode('/', dirname(str_replace('../', '', $css_storage)));
			
			$path = '';
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_CATALOG . $path)) {
					@mkdir(DIR_CATALOG . $path, 0777);
				}
			}
			
			$f_handle = fopen(DIR_CATALOG . $css_storage, 'w+');
			fwrite($f_handle, str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', html_entity_decode($this->request->post['css'])));
			fclose($f_handle);
			
			if (!isset($this->request->get['module_id'])) {
				$this->request->post['css_link'] = 'catalog/view/stylesheet/boss_dynamic_html' . $module_id . '.css';
				$this->model_setting_module->editModule($module_id, $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		
		$modules = $this->model_setting_module->getModulesByCode('boss_dynamic_html');
		
		$modules_id = array();
		
		foreach ($modules as $module) {
			$modules_id[] = $module['module_id'];
		}
		
		if (file_exists(DIR_CATALOG . 'view/stylesheet/')) {
			$files = glob(DIR_CATALOG . 'view/stylesheet/boss_dynamic_html*.css', GLOB_BRACE);
			
			if ($files) {
				foreach ($files as $file) {
					$id = (int)filter_var(basename($file), FILTER_SANITIZE_NUMBER_INT);
					
					if (!in_array($id, $modules_id)) {
						unlink($file);
					}
				}
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_css'] = $this->language->get('entry_css');
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['button_paste'] = $this->language->get('button_paste');
		$data['button_preview'] = $this->language->get('button_preview');
		$data['button_code'] = $this->language->get('button_code');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_change'] = $this->language->get('button_change');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['tab_css'] = $this->language->get('tab_css');

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
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_dynamic_html', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_dynamic_html', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/boss_dynamic_html', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/boss_dynamic_html', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
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

		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} elseif (!empty($module_info)) {
			$data['description'] = $module_info['description'];
		} else {
			$data['description'] = array();
		}
		
		if (isset($this->request->post['css'])) {
			$data['css'] = $this->request->post['css'];
		} elseif (!empty($module_info)) {
			$data['css'] = $module_info['css'];
		} else {
			$data['css'] = '';
		}
		
		if (isset($this->request->post['css_link'])) {
			$data['css_link'] = $this->request->post['css_link'];
		} elseif (!empty($module_info)) {
			$data['css_link'] = 'catalog/view/stylesheet/boss_dynamic_html' . $this->request->get['module_id'] . '.css';
		} else {
			$data['css_link'] = '';
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/boss_dynamic_html', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/boss_dynamic_html')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}