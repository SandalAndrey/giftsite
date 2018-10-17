<?php
class ControllerExtensionModuleBossFilterProduct extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('extension/module/boss_filterproduct');

		$this->document->addStyle('view/javascript/bossthemes/theme-manager/fontawesome-iconpicker/fontawesome-iconpicker.min.css');
		$this->document->addScript('view/javascript/bossthemes/theme-manager/fontawesome-iconpicker/fontawesome-iconpicker.min.js');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('boss_filterproduct', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL'));
		}
		
		// Text
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		
		//button
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_add_tab'] = $this->language->get('button_add_tab');

		//module
		$data['module_stt'] = $this->language->get('module_stt');
		$data['module_setting'] = $this->language->get('module_setting');
		$data['module_tab'] = $this->language->get('module_tab');
		$data['text_module'] = $this->language->get('text_module');

		//entry 
		$data['entry_numrow'] = $this->language->get('entry_numrow');
		$data['entry_perrow'] = $this->language->get('entry_perrow');
		$data['entry_column'] = $this->language->get('entry_column');
		$data['entry_class_css'] = $this->language->get('entry_class_css');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_icon'] = $this->language->get('entry_icon');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_scroll'] = $this->language->get('entry_scroll');
		$data['entry_scrolling_panel'] = $this->language->get('entry_scrolling_panel');
		$data['entry_tab'] = $this->language->get('entry_tab');
		$data['entry_slide'] = $this->language->get('entry_slide');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_scrolling_tab'] = $this->language->get('entry_scrolling_tab');
		$data['entry_slide_tab'] = $this->language->get('entry_slide_tab');
		$data['entry_num_tab'] = $this->language->get('entry_num_tab');
		$data['entry_prolarge'] = $this->language->get('entry_prolarge');
		$data['entry_show_prolarge'] = $this->language->get('entry_show_prolarge');
		$data['entry_get_prolarge'] = $this->language->get('entry_get_prolarge');
		$data['entry_img_large'] = $this->language->get('entry_img_large');
		$data['entry_add_img_large'] = $this->language->get('entry_add_img_large');

		//column  
		$data['column_number'] = $this->language->get('column_number');
		$data['column_title'] = $this->language->get('column_title');
		$data['column_icon'] = $this->language->get('column_icon');
		$data['column_icon_hover'] = $this->language->get('column_icon_hover');
		$data['column_get_product'] = $this->language->get('column_get_product');
		
		// Tab
		$data['tab_tabs'] = $this->language->get('tab_tabs');
		$data['tab_setting'] = $this->language->get('tab_setting');

		//load text type filter
		$data['filter_types'] = array(
			"popular" =>$this->language->get('tab_popular_products'),
			"special" =>$this->language->get('tab_special_products'),
			"best_seller" =>$this->language->get('tab_best_seller_products'),
			"latest" =>$this->language->get('tab_latest_products'),
			"featured" =>$this->language->get('tab_featured'),
			"category" =>$this->language->get('tab_choose_a_category')
		);

		$data['columns'] = array("1","2","3","4","5","6","7","8","9","10","11","12");

		$data['class_csss'] = array(
			"product-list" =>$this->language->get('class_product_list'),
			"product-grid" =>$this->language->get('class_product_grid')
		);
		
		$data['positions'] = array(
			"sidebar" => $this->language->get('text_sidebar'),
			"content" => $this->language->get('text_content'),
		);

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
		if (isset($this->error['limit'])) {
			$data['error_limit'] = $this->error['limit'];
		} else {
			$data['error_limit'] = '';
		}
		if (isset($this->error['image_width'])) {
			$data['error_image_width'] = $this->error['image_width'];
		} else {
			$data['error_image_width'] = '';
		}
		if (isset($this->error['image_height'])) {
			$data['error_image_height'] = $this->error['image_height'];
		} else {
			$data['error_image_height'] = '';
		}
		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = array();
		}

		if (isset($this->error['error_perrow'])) {
			$data['error_perrow'] = $this->error['error_perrow'];
		} else {
			$data['error_perrow'] = array();
		}

		if (isset($this->error['error_numrow'])) {
			$data['error_numrow'] = $this->error['error_numrow'];
		} else {
			$data['error_numrow'] = array();
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner', 'user_token=' . $this->session->data['user_token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_filterproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/boss_filterproduct', 'user_token=' . $this->session->data['user_token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/module/boss_filterproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL');
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (isset($module_info['name'])) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (isset($module_info['title'])) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = '';
		}
		
		if (isset($this->request->post['icon'])) {
			$data['icon'] = $this->request->post['icon'];
		} elseif (isset($module_info['icon'])) {
			$data['icon'] = $module_info['icon'];
		} else {
			$data['icon'] = '';
		}
		
		if (isset($this->request->post['position'])) {
			$data['position'] = $this->request->post['position'];
		} elseif (isset($module_info['position'])) {
			$data['position'] = $module_info['position'];
		} else {
			$data['position'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (isset($module_info['status'])) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		//load modules
		if (isset($this->request->post['config'])) {
			$data['config'] = $this->request->post['config'];
		} elseif (!empty($module_info)) {
			$data['config'] = $module_info['config'];
		}else{
			$data['config'] = array();
		}
		
		if (isset($this->request->post['tabs'])) {
			$data['tabs'] = $this->request->post['tabs'];
		} elseif (!empty($module_info['tabs'])) {
			$data['tabs'] = $module_info['tabs'];
		}else{
			$data['tabs'] = array();
		}
		
		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['products'] = array();

		$this->load->model('catalog/product');
		
		foreach($data['tabs'] as $index => $tab){
			if (!empty($tab['icon']) && file_exists(DIR_IMAGE . $tab['icon'])) {
				$data['tabs'][$index]['thumb'] = $this->model_tool_image->resize($tab['icon'], 100, 100);
			} else {
				$data['tabs'][$index]['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			
			if (isset($tab['product_featured'])) {
				$products = $tab['product_featured'];
			}else{
				$products = array();
			}

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					$data['products'][] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				}
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		//load languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		//load categoriescatalog_product
		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories(0);


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/boss_filterproduct', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/boss_filterproduct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		$config = $this->request->post['config'];

		if (isset($config)) {
			if (!$config['limit']) {
				$this->error['limit'] = $this->language->get('error_limit');
			}
			if (!$config['image_height']) {
				$this->error['image_height'] = $this->language->get('error_image_height');
			}
			if (!$config['image_width']) {
				$this->error['image_width'] = $this->language->get('error_image_width');
			}
			if (!$config['numrow']) {
				$this->error['error_numrow'] = $this->language->get('error_numrow');
			}
			if (!$config['perrow']) {
				$this->error['error_perrow'] = $this->language->get('error_perrow');
			}
			if(isset($config['tabs'])){
				foreach ($config['tabs'] as $key => $valuetab) {
					if ($valuetab['type_product'] == 'category' && !isset($valuetab['filter_type_category'])) {
						$this->error['category'][$key] = $this->language->get('error_category');
						$this->error['warning'] = $this->language->get('error_category');
					}
				}
			}
		}

		return !$this->error;
	}
}