<?php
class ControllerExtensionModuleBossCategory extends Controller {
	public function index($setting) {
		if(empty($setting)) return;

		if(!isset($setting['status'])) return;

		static $module = 0;

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_category.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_category.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_category.css');
		}

		$this->document->addScript('catalog/view/javascript/bossthemes/jquery.dcjqaccordion.min.js');

		$language_id = $this->config->get('config_language_id');

		$data['heading_title'] = isset($setting['title'][$language_id]) ? $setting['title'][$language_id] : '';

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$total = ($this->config->get('config_product_count')) ? $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category['category_id'])) : '';
			
			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $total . ')' : ''),
				'children'	  => $this->getChildrenCategory($category, $category['category_id']),
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}
		
		$data['module'] = $module++;
		$data['rend_child'] = false;
		$data['_this'] = $this;

		return $this->load->view('extension/module/boss_category', $data);
	}

	private function getChildrenCategory($category, $path) {
		$children_data = array();

		$children = $this->model_catalog_category->getCategories($category['category_id']);

		foreach ($children as $child) {
			/*$data = array(
				'filter_category_id'  => $child['category_id'],
				'filter_sub_category' => true
			);	*/

			$children_data[] = array(
				'category_id' => $child['category_id'],
				'name'  	=> $child['name'],
				'children' 	=> $this->getChildrenCategory($child, $path . '_' . $child['category_id']),
				'column'   	=> 1,
				'href'  => $this->url->link('product/category', 'path=' . $path . '_' . $child['category_id'])
			);

		}
		return $children_data;
	}
	
	public function rendChildrenCategories($category = array(), $level = 0) {
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		$data['child_id'] = (isset($parts[$level])) ? (int)$parts[$level] : 0;
		$data['category'] = $category;
		$data['rend_child'] = true;
		$data['_this'] = $this;
		$data['level'] = ($level+1);
		
		return $this->load->view('extension/module/boss_category', $data);
	}
}