<?php
class ControllerExtensionBossthemesSampleData extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('extension/bossthemes/sample_data');
		$this->load->model('setting/setting');
		
		$data = (isset($data)) ? array_merge($data, $this->language->all()) : $this->language->all();
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_sample_data', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/bossthemes/sample_data', 'user_token=' . $this->session->data['user_token'], 'SSL'));
		}
		
		$data['user_token'] = $this->session->data['user_token'];
		
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
			'href' => $this->url->link('extension/bossthemes/sample_data', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['export'] = $this->url->link('extension/bossthemes/sample_data/export', 'user_token=' . $this->session->data['user_token'], 'SSL');
		
		$data['packages'] = array();
		
		$directories = glob(DIR_SYSTEM . 'bossthemes/sample_data/*');
		
		if ($directories) {
			foreach ($directories as $directory) {
				if (is_dir($directory)) {
					$data['packages'][] = basename($directory);
				}
			}
		}
		
		rsort($data['packages']);
		
		$this->config->set('template_engine', 'template');
		$data['topbar'] = $this->load->controller('extension/bossthemes/topbar');
		$data['sidebar'] = $this->load->controller('extension/bossthemes/sidebar');
		
		$this->config->set('template_engine', 'twig');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->config->set('template_engine', 'template');

		$this->response->setOutput($this->load->view('extension/bossthemes/sample_data', $data));
	}
	
	public function getPackage() {
		$this->load->language('extension/bossthemes/sample_data');
		
		$json['modules'] = array();
		$language = new Language($this->config->get('config_language'));
		
		if (isset($this->request->post['package'])) {
			$package = $this->request->post['package'];
			
			$files = glob(DIR_SYSTEM . 'bossthemes/sample_data/' . $package . '/module_*.dat');
			
			if ($files) {
				foreach ($files as $file) {
					$extension = preg_replace('/^module_module_|^module_setting_/', '', basename($file, '.dat'));
					$language->load('extension/module/' . $extension);
					
					if ($extension == 'boss_module_layout') {
						$note = $this->language->get('text_import_last');
					} else {
						$note = '';
					}
					
					$json['modules'][] = array(
						'name'      => $language->get('heading_title'),
						'import'    => html_entity_decode($this->url->link('extension/bossthemes/sample_data/import', 'user_token=' . $this->session->data['user_token'] . '&package=' . urlencode($package) . '&module=' . urlencode(basename($file, '.dat')), true)),
						'note'      => $note
					);
				}
			}
	
			$sort_order = array();
	
			foreach ($json['modules'] as $key => $value) {
				$sort_order[$key] = $value['name'];
			}
	
			array_multisort($sort_order, SORT_ASC, $json['modules']);
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function export() {
		$this->load->model('setting/setting');
		$this->load->model('setting/extension');
		$this->load->model('setting/module');
		
		if ($this->validate()) {
			// Create storage directory
			$package_path = 'bossthemes/sample_data/' . date('Y-m-d-H-i') . '/';
			
			$path = '';

			$directories = explode('/', $package_path);

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				if (!is_dir(DIR_SYSTEM . $path)) {
					@mkdir(DIR_SYSTEM . $path, 0777);
				}
			}
			
			// Manager
			$settings = array(
				'boss_manager',
				'boss_category',
				'boss_product',
				'boss_header',
				'boss_footer',
				'boss_custom',
				'boss_social',
				'boss_payment'
			);
			
			$json = array();
			foreach ($settings as $setting) {
				$json[] = array(
					'code'    => $setting,
					'setting' => $this->model_setting_setting->getSetting($setting)
				);
			}
			
			$handle = fopen(DIR_SYSTEM . $package_path . 'setting_boss_manager.dat', 'w');
			fwrite($handle, json_encode($json));
			fclose($handle);
			
			// Module
			$extensions = $this->model_setting_extension->getInstalled('module');
			
			foreach ($extensions as $key => $value) {
				if (!is_file(DIR_APPLICATION . 'controller/extension/module/' . $value . '.php')) {
					$this->model_setting_extension->uninstall('module', $value);
	
					unset($extensions[$key]);
					
					$this->model_setting_module->deleteModulesByCode($value);
				}
			}
			
			foreach ($extensions as $extension) {
				if ($extension == 'boss_manager') continue;
				$json = array();
				$modules = $this->model_setting_module->getModulesByCode($extension);
				
				if ($modules) {
					foreach ($modules as $module) {
						$json[] = array(
							'module_id' => $module['module_id'],
							'name'      => $module['name'],
							'setting'   => json_decode($module['setting'], true),
							'layout'    => $this->getModuleLayouts($module['code'] . '.' . $module['module_id'])
						);
					}
					
					$handle = fopen(DIR_SYSTEM . $package_path . 'module_module_' . $extension . '.dat', 'w');
					fwrite($handle, json_encode($json));
					fclose($handle);
				} else {
					$json[] = array(
						'setting' => $this->model_setting_setting->getSetting('module_' . $extension),
						'layout'  => $this->getModuleLayouts($extension)
					);
					
					$handle = fopen(DIR_SYSTEM . $package_path . 'module_setting_' . $extension . '.dat', 'w');
					fwrite($handle, json_encode($json));
					fclose($handle);
				}
			}
			
			// Banners
			$banners = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner WHERE `name` LIKE '%Boss%'")->rows;
			
			foreach ($banners as $key => $value) {
				$banner_image_data = array();
				
				$banner_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image WHERE banner_id = '" . (int)$value['banner_id'] . "' ORDER BY sort_order ASC");
				
				foreach ($banner_image_query->rows as $banner_image) {
					$banner_image_data[$banner_image['language_id']][] = array(
						'title'      => $banner_image['title'],
						'link'       => $banner_image['link'],
						'image'      => $banner_image['image'],
						'sort_order' => $banner_image['sort_order']
					);
				}
				
				$banners[$key]['banner_image'] = $banner_image_data;
			}
			
			$handle = fopen(DIR_SYSTEM . $package_path . 'banners.dat', 'w');
			fwrite($handle, json_encode($banners));
			fclose($handle);
		}
		
		$this->response->redirect($this->url->link('extension/bossthemes/sample_data', 'user_token=' . $this->session->data['user_token'], 'SSL'));
	}
	
	public function import() {
		$this->load->language('extension/bossthemes/sample_data');
		$this->load->model('setting/extension');
		$this->load->model('setting/setting');
		$this->load->model('setting/module');
		
		$json = array();
		
		if ($this->validate()) {
			if (isset($this->request->get['package']) && isset($this->request->get['module'])) {
				$package = $this->request->get['package'];
				$module = $this->request->get['module'];
				if (file_exists(DIR_SYSTEM . 'bossthemes/sample_data/' . $package . '/' . $module . '.dat')) {
					$extension = preg_replace('/^module_module_|^module_setting_/', '', $module);
					$this->uninstallModule($extension);
					$this->installModule($extension);
					
					$json_str = file_get_contents(DIR_SYSTEM . 'bossthemes/sample_data/' . $package . '/' . $module . '.dat');
					
					$this->preData($extension, $json_str);
					
					$modules = json_decode($json_str, true);
					
					if (preg_match('/^module_module_/', $module)) {
						foreach ($modules as $module) {
							$this->model_setting_module->addModule($extension, $module['setting']);
							$module_id = $this->db->getLastId();
							
							$this->postData($extension, $module_id, $module['setting']);
							
							foreach ($module['layout'] as $layout) {
								if ($layout['name'] == 'Boss Blog') {
									$layout_id = $this->preLayout('Boss Blog');
								} else {
									$layout_id = $layout['layout_id'];
								}
								
								if ($layout_id) {
									$this->db->query("INSERT INTO `" . DB_PREFIX . "layout_module` SET `layout_id` = '" . (int)$layout_id . "', `code` = '" . $this->db->escape($extension . '.' . $module_id) . "', `position` = '" . $this->db->escape($layout['position']) . "', `sort_order` = '" . (int)$layout['sort_order'] . "'");
								}
							}
						}
						
						$json['success'] = $this->language->get('text_success');
					} else if (preg_match('/^module_setting_/', $module)) {
						foreach ($modules as $module) {
							if ($module['setting']) $this->model_setting_setting->editSetting('module_' . $extension, $module['setting']);
							
							foreach ($module['layout'] as $layout) {
								if ($layout['name'] == 'Boss Blog') {
									$layout_id = $this->preLayout('Boss Blog');
								} else {
									$layout_id = $layout['layout_id'];
								}
								
								if ($layout_id) {
									$this->db->query("INSERT INTO `" . DB_PREFIX . "layout_module` SET `layout_id` = '" . (int)$layout_id . "', `code` = '" . $this->db->escape($extension) . "', `position` = '" . $this->db->escape($layout['position']) . "', `sort_order` = '" . (int)$layout['sort_order'] . "'");
								}
							}
						}
						
						$json['success'] = $this->language->get('text_success');
					}
				} else {
					$json['error'] = $this->language->get('error_package');
				}
			} else {
				$json['error'] = $this->language->get('error_package');
			}
		} else {
			$json['error'] = $this->error['warning'];
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	private function installModule($extension = '') {
		$this->load->model('setting/extension');
		
		$this->model_setting_extension->install('module', $extension);

		$this->load->model('user/user_group');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/module/' . $extension);
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/module/' . $extension);
		
		$this->load->controller('extension/module/' . $extension . '/install');
	}
	
	private function uninstallModule($extension = '') {
		$this->load->model('setting/extension');
		$this->load->model('setting/setting');
		$this->load->model('setting/module');
		
		$this->model_setting_extension->uninstall('module', $extension);
		$this->model_setting_module->deleteModulesByCode($extension);
		$this->model_setting_setting->deleteSetting('module_' . $extension);
		
		$this->load->controller('extension/module/' . $extension . '/uninstall');
	}
	
	private function getModuleLayouts($extension = '') {
		$query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "layout_module` lm LEFT JOIN `" . DB_PREFIX . "layout` l ON (`lm`.`layout_id` = `l`.`layout_id`) WHERE `lm`.`code` = '" . $this->db->escape($extension) . "' ORDER BY `lm`.`position` ASC, `lm`.`sort_order` ASC");

		return $query->rows;
	}
	
	private function getLayoutId($layout_name = '') {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE name = '" . $this->db->escape($layout_name) . "'");
		
		if ($query->num_rows) 
			return (int)$query->row['layout_id'];
		return false;
	}
	
	private function getModuleId($extension, $name) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `code` LIKE '" . $this->db->escape($extension) . "%' AND `name` = '" . $this->db->escape($name) . "'");
		
		if ($query->num_rows) 
			return $query->row['module_id'];
		return false;
	}
	
	private function preData($case = '', &$json_str = '') {
		$package = $this->request->get['package'];
		$module = $this->request->get['module'];
		$extension = preg_replace('/^module_module_|^module_setting_/', '', $module);
		
		switch ($case) {
			case 'boss_carousel':
				$this->load->model('design/banner');
				if (file_exists(DIR_SYSTEM . 'bossthemes/sample_data/' . $package . '/banners.dat')) {
					$banners = json_decode(file_get_contents(DIR_SYSTEM . 'bossthemes/sample_data/' . $package . '/banners.dat'), true);
					
					foreach ($banners as $banner) {
						$old_id = $banner['banner_id'];
						
						$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "banner` WHERE `name` = '" . $this->db->escape($banner['name']) . "'");
						foreach ($query->rows as $result) {
							$this->model_design_banner->deleteBanner($result['banner_id']);
						}
						
						$banner_id = $this->model_design_banner->addBanner($banner);
						
						$json_str = str_replace('"banner_id":"' . $old_id . '"', '"banner_id":"' . $banner_id . '"', $json_str); 
					}
				}
				break;
			case 'boss_module_layout': 
				$_this = $this;
				$json_str = preg_replace_callback('/(\[)(\w+)(\.)(\d+) (.*)(\])/U', function ($matches) use($_this) {
					$package = $_this->request->get['package'];
					
					if ($matches[4] && file_exists(DIR_SYSTEM . 'bossthemes/sample_data/' . $package . '/module_module_' . $matches[2] . '.dat')){
						$module_id = 0;
						$modules = json_decode(file_get_contents(DIR_SYSTEM . 'bossthemes/sample_data/' . $package . '/module_module_' . $matches[2] . '.dat'), true);
						foreach ($modules as $module) {
							if ($module['module_id'] == $matches[4]) {
								$module_id = $_this->getModuleId($matches[2], $module['name']);
								break;
							}
						}
						
						if ($module_id) {
							return $matches[1] . $matches[2] . $matches[3] . $module_id . ' ' . $matches[5] . $matches[6];
						} else {
							return $matches[0];
						}
					} else {
						return $matches[0];
					}
				}, $json_str);
				
				break;
			case 'boss_dynamic_html':
				$base_url = str_replace(array('https:', 'http:'), '', HTTP_CATALOG);
				$json_str = str_replace('src=&quot;image', 'src=&quot;' . addcslashes($base_url . 'image', '/'), $json_str);
				break;
		}
		
		return false;
	}
	
	public function postData($case = '', $module_id = 0, $setting = array()) {
		switch ($case) {
			case 'boss_newmegamenu': 
				$old_id = $setting['boss_newmegamenu_module']['module_id'] ;
				$setting['boss_newmegamenu_module']['module_id'] = $module_id;
				$this->model_setting_module->editModule($module_id, $setting);
				$this->db->query("UPDATE `" . DB_PREFIX . "megamenu` SET `module_id` = '" . (int)$module_id . "' WHERE `module_id` = '" . (int)$old_id . "'");
				break;
			case 'newslettersubscribe':
				$setting['module_id'] = $module_id;
				$this->model_setting_module->editModule($module_id, $setting);
				break;
			case 'boss_dynamic_html': 
				$old_id = filter_var(basename($setting['css_link']), FILTER_SANITIZE_NUMBER_INT);
				$setting['css_link'] = 'catalog/view/stylesheet/boss_dynamic_html' . $module_id . '.css';
				$this->model_setting_module->editModule($module_id, $setting);
				
				if (file_exists(DIR_CATALOG . 'view/stylesheet/boss_dynamic_html' . $old_id . '.css')) {
					rename(DIR_CATALOG . 'view/stylesheet/boss_dynamic_html' . $old_id . '.css', DIR_CATALOG . 'view/stylesheet/boss_dynamic_html' . $module_id . '.css');
				}
				break;
		}
	}
	
	private function preLayout($case = '') {
		switch ($case) {
			case 'Boss Blog': 
				if ($this->getLayoutId('Boss Blog')) {
					return $this->getLayoutId('Boss Blog');
				} else if(file_exists(DIR_APPLICATION . 'controller/extension/module/bossblog.php')) {
					$this->installModule('bossblog');
					return $this->getLayoutId('Boss Blog');
				} else {
					return 0;
				}
				break;
		}
		
		return false;
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/bossthemes/sample_data')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		return !$this->error;
	}
}
