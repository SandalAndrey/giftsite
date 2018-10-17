<?php
class ControllerExtensionModuleBossRefinesearch extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/boss_refinesearch');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('catalog/filter');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_boss_refinesearch', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['add_link'] =  $this->url->link('catalog/boss_refinesearch_setting', 'user_token=' . $this->session->data['user_token'], 'SSL');
		$data['setting_link'] =  $this->url->link('extension/module/boss_refinesearch', 'user_token=' . $this->session->data['user_token'], 'SSL');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/boss_refinesearch', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/module/boss_refinesearch', 'user_token=' . $this->session->data['user_token'], 'SSL');

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL');

		if (isset($this->request->post['module_boss_refinesearch_module'])) {
			$data['module'] = $this->request->post['module_boss_refinesearch_module'];
		} else {
			$data['module'] = $this->config->get('module_boss_refinesearch_module');
		}
		
		
		if (isset($this->request->post['module_boss_refinesearch_status'])) {
			$data['module_boss_refinesearch_status'] = $this->request->post['module_boss_refinesearch_status'];
		} else {
			$data['module_boss_refinesearch_status'] = $this->config->get('module_boss_refinesearch_status');
		}

		$data['filters'] = array();
		$filter_data = array(
			'sort'  => 'fg.sort_order',
			'order' => 'ASC',			
		);
		
		$filter_total = $this->model_catalog_filter->getTotalFilterGroups();

		$results = $this->model_catalog_filter->getFilterGroups($filter_data);

		foreach ($results as $result) {
			$data['filters'][] = array(
				'filter_group_id' => $result['filter_group_id'],
				'name'            => $result['name'],
				'sort_order'      => $result['sort_order'],				
			);
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/boss_refinesearch', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/boss_refinesearch')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		$boss_refinesearch_module = $this->request->post['module_boss_refinesearch_module'];
		
		if (isset($boss_refinesearch_module)) { 			
			if (!$boss_refinesearch_module['image_width']) { 
				$this->error['image_width'] = $this->language->get('error_image_width');
			}
			if (!$boss_refinesearch_module['image_height']) { 
				$this->error['image_height'] = $this->language->get('error_image_height');
			}
		}
		return !$this->error;
	}
	
	public function updateCategoriesFilters($route = '', $data = array(), $product_id = 0) {
		if ($route == 'catalog/product/editProduct') {
			$product_id = $data[0];
		}
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_filter` (`category_id`, `filter_id`) SELECT `rs`.`path_id`, `rs`.`filter_id` FROM (SELECT `cp`.`path_id`, `pf`.`filter_id` FROM `" . DB_PREFIX . "product_filter` pf LEFT JOIN `" . DB_PREFIX . "product_to_category` ptc ON (`pf`.`product_id` = `ptc`.`product_id`) LEFT JOIN `" . DB_PREFIX . "category_path` cp ON (`cp`.`category_id` = `ptc`.`category_id`) WHERE `pf`.`product_id` = '" . (int)$product_id . "' GROUP BY `path_id`,`filter_id`) rs LEFT JOIN `" . DB_PREFIX . "category_filter` cf ON (`cf`.`category_id` = `rs`.`path_id`) AND (`cf`.`filter_id` = `rs`.`filter_id`) WHERE `cf`.`filter_id` IS NULL");
	}
	
	public function install() {
        $this->load->model('catalog/boss_refinesearch');
		$this->load->model('user/user_group');
		$this->load->model('setting/event');
		
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/boss_refinesearch_setting');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/boss_refinesearch_setting');
        $this->model_catalog_boss_refinesearch->createdb();
		$this->model_setting_event->addEvent('boss_refinesearch', 'admin/model/catalog/product/addProduct/after', 'extension/module/boss_refinesearch/updateCategoriesFilters', 1);
		$this->model_setting_event->addEvent('boss_refinesearch', 'admin/model/catalog/product/editProduct/after', 'extension/module/boss_refinesearch/updateCategoriesFilters', 1);
 	}
        
    public function uninstall() {   
		$this->load->model('setting/event');
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "filter_image`");
		$this->model_setting_event->deleteEvent('boss_refinesearch');
    }
}