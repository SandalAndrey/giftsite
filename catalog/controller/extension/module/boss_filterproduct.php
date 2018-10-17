<?php
class ControllerExtensionModuleBossFilterProduct extends Controller {
	public function index($setting) {
		if(empty($setting))	return;
		static $module = 0;

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_filterproduct.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_filterproduct.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_filterproduct.css');
		}

		if ($setting['config']['scrolling_panel']) {
			$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.css');

			if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css');
			} else {
				$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.theme.default.min.css');
			}

			$this->document->addScript('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.js');
		}

		$data['heading_title'] = isset($setting['title'][$this->config->get('config_language_id')]) ? $setting['title'][$this->config->get('config_language_id')] : '';

		$language_id = $this->config->get('config_language_id');

		$text_save_off = $this->config->get('theme_' . $this->config->get('config_theme') . '_text_save_off');
		$data['text_save_off'] = (isset($text_save_off[$language_id])) ? $text_save_off[$language_id] : '';

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/boss_filterproduct');
		$_language->load('product/category');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		$data['icon'] = (isset($setting['icon'])) ? $setting['icon'] : '';

		//Get config
		$data['column'] = (int)$setting['config']['column'];
		$data['scrolling_panel'] = $setting['config']['scrolling_panel'];
		$data['use_tab'] = $setting['config']['use_tab'];
		$data['num_row'] = $setting['config']['numrow'];
		$data['per_row'] = $setting['config']['perrow'];
		$data['class_css'] = $setting['config']['class_css'];
		$data['image_width'] = $setting['config']['image_width'];
		$data['image_height'] = $setting['config']['image_height'];
		$data['scrolling_tab'] = $setting['config']['scrolling_tab'];
		$data['num_tab'] = $setting['config']['num_tab'];
		$data['product_large'] = $setting['config']['product_large'];

		if ($setting['config']['product_large']) {
			if ($setting['config']['add_img_width']) {
				$add_img_width = (int)$setting['config']['add_img_width'];
			} else {
				$add_img_width = (int)$this->config->get($this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '_image_additional_width');
			}

			if ($setting['config']['add_img_height']) {
				$add_img_height = (int)$setting['config']['add_img_height'];
			} else {
				$add_img_height = (int)$this->config->get($this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '_image_additional_height');
			}
		}

		if ($setting['position'] == 'sidebar') {
			$data['sidebar'] = 1;
		} else {
			$data['sidebar'] = 0;
		}

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$data['tabs'] = array();
		$data['products'] = array();

		//load tab for module
		if (isset($setting['tabs'])) {
			foreach ($setting['tabs'] as $tab) {
				//
				if (isset($tab['icon']) && file_exists(DIR_IMAGE . $tab['icon'])) {
					$icon = $this->model_tool_image->resize($tab['icon'], 39, 28);
				} else {
					$icon = $this->model_tool_image->resize('no_image.jpg', 39, 28);
				}

				$results = array();
				if ($tab['type_product'] == "popular") {
					$results = $this->model_catalog_product->getPopularProducts($setting['config']['limit']);
				}
				if ($tab['type_product'] == "special") {
					if ($setting['config']['product_large']) {
						$sort = 'rating';
						$order = 'DESC';
					} else {
						$sort = 'p.date_added';
						$order = 'DESC';
					}

					$data_sort = array(
						'sort'  => $sort,
						'order' => $order,
						'start' => 0,
						'limit' => $setting['config']['limit']
					);

					$results = $this->model_catalog_product->getProductSpecials($data_sort);
				}
				if ($tab['type_product'] == "best_seller") {
					$results = $this->model_catalog_product->getBestSellerProducts($setting['config']['limit']);
				}
				if ($tab['type_product'] == "latest") {
					$results = $this->model_catalog_product->getLatestProducts($setting['config']['limit']);
				}
				if ($tab['type_product'] == "category") {
					if ($setting['config']['product_large']) {
						$sort = 'rating';
						$order = 'DESC';
					} else {
						$sort = 'p.date_added';
						$order = 'DESC';
					}

					$data_sort = array(
						'filter_category_id' => $tab['filter_type_category'],
						'sort'  => $sort,
						'order' => $order,
						'start' => 0,
						'limit' => $setting['config']['limit']
					);
					$results = $this->model_catalog_product->getProducts($data_sort);
				}

				if ($tab['type_product'] == "featured") {
					if(isset($tab['product_featured'])){
						$pros_id = $tab['product_featured'];
					}else{
						$pros_id = array();
					}
					foreach ($pros_id as $product_id) {
						$product_info = $this->model_catalog_product->getProduct($product_id);

						if ($product_info) {
							$results[$product_id] = $product_info;
						}
					}
				}

				$products = array();

				$sort_order = 1;

				foreach ($results as $result) {
					$product_id = $result['product_id'];

					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['config']['image_width'], $setting['config']['image_height']);
					} else {
						$image = false;
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}

					if ($setting['config']['product_large']) {
						$product_images = $this->model_catalog_product->getProductImages($product_id);

						$images = array();

						$images[] = array(
							'popup' => $this->model_tool_image->resize($result['image'], $setting['config']['image_width'], $setting['config']['image_height']),
							'thumb' => $this->model_tool_image->resize($result['image'], $add_img_width, $add_img_height)
						);

						foreach ($product_images as $index => $value) {
							if ($index == 3) break;

							$images[] = array(
								'popup' => $this->model_tool_image->resize($value['image'], $setting['config']['image_width'], $setting['config']['image_height']),
								'thumb' => $this->model_tool_image->resize($value['image'], $add_img_width, $add_img_height)
							);
						}
					} else {
						$images = array();
					}

					$products[] = $data['products'][$product_id] = array(
						'product_id' => $result['product_id'],
						'thumb'   	 => $image,
						'images'     => $images,
						'name'    	 => $result['name'],
						'price'   	 => $price,
						'special' 	 => $special,
						'minimum' 	 => $result['minimum'],
						'description'=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 140),
						'tax'        => $tax,
						'rating'     => $rating,
						'reviews'    => sprintf($_language->get('text_reviews'), (int)$result['reviews']),
						'sort_order' => $sort_order,
						'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					);

					$sort_order++;
				}

				$data['tabs'][] = array(
					'title'	 		 =>	isset($tab['title'][$this->config->get('config_language_id')])?$tab['title'][$this->config->get('config_language_id')]:'',
					'icon'           => $icon,
					'products'       => $products,
				);
			}
		}

		$data['products'] = str_replace(array('\r', '\n', '\t'), '', json_encode($data['products'], true));

		$data['module'] = $module++;

		return $this->load->view('extension/module/boss_filterproduct', $data);
	}

	public function getProduct() {
		$json = array();

		if (!empty($this->request->post['product_id'])) {
			if (isset($this->request->post['img_width'])) {
				$img_width= (int)$this->request->post['img_width'];
			} else {
				$img_width = (int)$this->config->get($this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '_image_product_width');
			}

			if (isset($this->request->post['img_height'])) {
				$img_height = (int)$this->request->post['img_height'];
			} else {
				$img_height = (int)$this->config->get($this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '_image_product_height');
			}

			if (isset($this->request->post['add_img_width'])) {
				$add_img_width = (int)$this->request->post['add_img_width'];
			} else {
				$add_img_width = (int)$this->config->get($this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '_image_additional_width');
			}

			if (isset($this->request->post['add_img_height'])) {
				$add_img_height = (int)$this->request->post['add_img_height'];
			} else {
				$add_img_height = (int)$this->config->get($this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '_image_additional_height');
			}

		} else {
			$json = array(
				'result' => 'error'
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>