<?php
class ControllerExtensionModuleBossRefinesearch extends Controller {
	public function index() {
		static $module = 0;

		$this->load->model('catalog/category');

		$this->load->model('bossthemes/boss_refinesearch');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		} else {
			$route = 'common/home';
		}

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_filter.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_filter.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_filter.css');
		}

		$this->document->addScript('catalog/view/javascript/bossthemes/selectbox/bootstrap-select.js');

		$setting = $this->config->get('module_boss_refinesearch_module');

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/boss_refinesearch');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		$url = '';

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['tag'])) {
			$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if ($route == 'product/category') {

			$category_id = end($parts);

			$category_info = $this->model_catalog_category->getCategory($category_id);

			$data['action'] = html_entity_decode($this->url->link('product/category', 'path=' . $this->request->get['path'] . $url));

			if (isset($this->request->get['filter'])) {
				$data['filter_filter'] = array_map('intval', explode(',', $this->request->get['filter']));
			} else {
				$data['filter_filter'] = array();
			}

			$this->load->model('catalog/product');

			$data['filter_groups'] = array();

			$filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);

			foreach ($filter_groups as $filter_group) {
				if (isset($setting[$filter_group['filter_group_id']])) {
					$childen_data = array();

					foreach ($filter_group['filter'] as $filter) {
						$filter_data = array(
							'filter_category_id' => $category_id,
							'filter_filter'      => $filter['filter_id']
						);

						$result = $this->model_bossthemes_boss_refinesearch->getFilterImage($filter['filter_id']);

						if(!empty($result)){
							$image = $this->model_tool_image->resize($result['image'], isset($setting['image_width'])?$setting['image_width']:20,isset($setting['image_height'])?$setting['image_height']:20);
						}else{
							$image = '';
						}

						$childen_data[] = array(
							'filter_id' => $filter['filter_id'],
							'image' 	=> $image,
							'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')
						);
					}

					$data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'show_image'      => $setting[$filter_group['filter_group_id']]['display'],
						'show_product'    => $setting[$filter_group['filter_group_id']]['under'],
						'filter'          => $childen_data
					);
				}
			}
		} else {
			$data['action'] = html_entity_decode($this->url->link('bossthemes/filter', $url));

			if (isset($this->request->get['filter'])) {
				$data['filter_filter'] = array_map('intval', explode(',', $this->request->get['filter']));
			} else {
				$data['filter_filter'] = array();
			}

			$data['filter_groups'] = array();

			$filter_var = array(
				'sort'  => 'fg.sort_order',
				'order' => 'ASC'
			);

			$filter_groups = $this->model_bossthemes_boss_refinesearch->getFilters($filter_var);

			foreach ($filter_groups as $filter_group) {
				if (isset($setting[$filter_group['filter_group_id']])) {
					$childen_data = array();

					foreach ($filter_group['filter'] as $filter) {

						$result = $this->model_bossthemes_boss_refinesearch->getFilterImage($filter['filter_id']);

						if(!empty($result)){
							$image = $this->model_tool_image->resize($result['image'], isset($setting['image_width'])?$setting['image_width']:20,isset($setting['image_height'])?$setting['image_height']:20);
						}else{
							$image = '';
						}

						$childen_data[] = array(
							'filter_id' => $filter['filter_id'],
							'image' 	=> $image,
							'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts(array('filter_filter' => $filter)) . ')' : '')
						);
					}

					$data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'show_image'      => $setting[$filter_group['filter_group_id']]['display'],
						'show_product'    => $setting[$filter_group['filter_group_id']]['under'],
						'filter'          => $childen_data
					);
				}
			}

			if (isset($this->request->get['search'])) {
				$data['search'] = $this->request->get['search'];
			} else {
				$data['search'] = '';
			}
		}

		$data['route'] = $route;
		$data['module'] = $module++;

		return $this->load->view('extension/module/boss_refinesearch', $data);
	}
}