<?php
class ControllerExtensionModuleBossMenuCategory extends Controller {
	public function index($setting) {

		$this->load->model('tool/image');

		$this->load->model('catalog/category');

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_menu_category.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_menu_category.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_menu_category.css');
		}

		$language_id = (int)$this->config->get('config_language_id');

		$data['heading_title'] = (isset($setting['title'][$language_id])) ? $setting['title'][$language_id] : '';

		$menus = array();

		$menus = $setting['boss_menucategory_config'];

		$data['menus'] = array();

		if(isset($menus) && !empty($menus)){

			$sort_order = array();

			foreach ($menus as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $menus);

			foreach ($menus as $menu) {
				if (isset($menu['icon']) && file_exists(DIR_IMAGE . $menu['icon'])) {
					$icon = $this->model_tool_image->resize($menu['icon'], 20, 25);
				} else {
					$icon = $this->model_tool_image->resize('no_image.jpg', 20, 25);
				}

				if (!empty($menu['bgimage']) && file_exists(DIR_IMAGE . $menu['bgimage'])) {
					$bgimage = 'image/'.$menu['bgimage'];
				} else {
					$bgimage = false;
				}

				$categories = array();

				if(isset($menu['category_id'])){
					$category_id = (int)$menu['category_id'];
				}else{
					$category_id = '';
				}

				if($category_id != '' && $menu['sub_category']){

					$results = $this->model_catalog_category->getCategories($category_id);

					foreach ($results as $category) {
						$categories[] = array(
							'name'     		=> $category['name'],
							'children'		=> $this->getChildrenCategory($category, $category['category_id']),
							'href'     		=> $this->url->link('product/category', 'path=' . $category['category_id'])
						);
					}
				}

				$data['menus'][] = array(
					'title'			=> (isset($menu['title'][$language_id])) ? $menu['title'][$language_id] : '',
					'icon'			=> $icon,
					'categories'	=> $categories,
					'category_id'	=> $menu['category_id'],
					'column'		=> $menu['column'],
					'sub_width'		=> $menu['sub_width'],
					'bgimage'		=> $bgimage,
					'sort_order'	=> $menu['sort_order'],
					'href'			=> $this->url->link('product/category', 'path=' . $menu['category_id'])
				);
			}

		}

		return $this->load->view('extension/module/boss_menucategory', $data);
	}

	private function getChildrenCategory($category, $path){
		$children_data = array();
		$children = $this->model_catalog_category->getCategories($category['category_id']);

		foreach ($children as $child) {
			$data = array(
				'filter_category_id'  => $child['category_id'],
				'filter_sub_category' => true
			);

			$children_data[] = array(
				'name'  	=> $child['name'],
				'children' 	=> $this->getChildrenCategory($child, $path . '_' . $child['category_id']),
				'href'  => $this->url->link('product/category', 'path=' . $path . '_' . $child['category_id'])
			);

		}
		return $children_data;
	}
}
?>