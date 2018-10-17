<?php
class ControllerExtensionModuleBossFeatured extends Controller {
	public function index($setting) {

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_featured.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_featured.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_featured.css');
		}

		$data['mode'] = '';
		$data['js'] = '';

		if (isset($setting['show_slider'])) {
			$data['show_slider'] = $setting['show_slider'];
		} else {
			$data['show_slider'] = 0;
		}

		if (isset($setting['center'])) {
			$data['center'] = (int)$setting['center'];
		} else {
			$data['center'] = 0;
		}

		if ($data['center']) {
			$data['mode'] = 'center-mode';
		}

		if (isset($setting['column'])) {
			$data['column'] = (int)$setting['column'];
		} else {
			$data['column'] = 4;
		}

		if (isset($setting['num_row'])) {
			$data['num_row'] = $setting['num_row'];
		} else {
			$data['num_row'] = 1;
		}

		if (isset($setting['per_row'])) {
			$data['per_row'] = (int)$setting['per_row'];
		} else {
			$data['per_row'] = 4;
		}

		if(isset($setting['pagination'])){
			$data['pagination'] = $setting['pagination'];
		} else {
			$data['pagination'] = 0;
		}

		$data['product_layout'] = $setting['product_layout'];

		if ($setting['position'] == 'sidebar') {
			$data['sidebar'] = 1;
		} else {
			$data['sidebar'] = 0;
		}

		if ($data['per_row'] == 0) {
			$data['infinite'] = 1;
		} else {
			$data['infinite'] = 0;
		}

		if ($data['infinite']) {
			$data['mode'] = 'infinite-mode';
		}

		$data['banner_left'] = (!empty($setting['banner_left']['image'])) ? $setting['banner_left'] : array();
		$data['banner_right'] = (!empty($setting['banner_right']['image'])) ? $setting['banner_right'] : array();

		if ($setting['show_slider'] && $data['mode'] == 'center-mode') {
				$this->document->addScript('catalog/view/javascript/bossthemes/slick/slick.min.js');
				$this->document->addStyle('catalog/view/javascript/bossthemes/slick/slick.css');
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/slick-theme.css');

				$data['js'] = 'slick';
		} else if ($setting['show_slider']) {
			$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.css');

			if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css');
			} else {
				$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.theme.default.min.css');
			}

			$this->document->addScript('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.js');

			$data['js'] = 'owl';
		}

		static $module = 0;

		$language_id = $this->config->get('config_language_id');

		$text_save_off = $this->config->get('theme_' . $this->config->get('config_theme') . '_text_save_off');
		$data['text_save_off'] = (isset($text_save_off[$language_id])) ? $text_save_off[$language_id] : '';

		$data['template'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_directory');

		$data['heading_title'] = isset($setting['title'][$language_id]) ? $setting['title'][$language_id] : '';
		$data['description'] = isset($setting['description'][$language_id]) ? html_entity_decode($setting['description'][$language_id]) : '';

		$data['box_class_css'] = isset($setting['class_css'])?$setting['class_css']:'none-class';

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$mainproduct = array();
		$data['images'] = array();

		$products = array();

		if(isset($setting['show_pro_large']) && $setting['show_pro_large']){

			if (isset($setting['product_id'])) {
				$product_id = $setting['product_id'];
			}

			$product_info = array();

			$results = $this->model_catalog_product->getProductImages($product_id);
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if(isset($setting['img_width'])){
				$img_width = $setting['img_width'];
			} else {
				$img_width = 380;
			}

			if(isset($setting['img_height'])){
				$img_height = $setting['img_height'];
			} else {
				$img_height = 380;
			}

			foreach ($results as $result) {
				$data['images'][] = array(
					'thumb' => $this->model_tool_image->resize($result['image'], $img_width, $img_height)
				);
			}

			if (!empty($product_info)) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $img_width, $img_height);
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}

				$mainproduct = array(
					'product_id' => $product_info['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $product_info['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'   	 => $price,
					'special' 	 => $special,
					'minimum' 	 => $product_info['minimum'],
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
				);
			}
		}

		if(isset($setting['limit'])){
			$limit = $setting['limit'];
		} else {
			$limit = 8;
		}

		if ($setting['type_product'] == "popular") {
			$results = $this->model_catalog_product->getPopularProducts($limit);
		} else if ($setting['type_product'] == "special") {
			$data_sort = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $limit
			);
			$results = $this->model_catalog_product->getProductSpecials($data_sort);
		} else if ($setting['type_product'] == "best_seller") {
			$results = $this->model_catalog_product->getBestSellerProducts($limit);
		} else if ($setting['type_product'] == "latest") {
			$results = $this->model_catalog_product->getLatestProducts($limit);
		} else if ($setting['type_product'] == "category") {
			$data_sort = array(
				'filter_category_id' => $setting['category_id'],
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $limit
			);
			$results = $this->model_catalog_product->getProducts($data_sort);
		} else if ($setting['type_product'] == "featured") {
			if(isset($setting['product_featured'])){
				$pros_id = $setting['product_featured'];
			} else {
				$pros_id = array();
			}

			if(!empty($pros_id)){
				foreach ($pros_id as $product_id) {
					$product_info = $this->model_catalog_product->getProduct($product_id);

					if ($product_info) {
						$results[$product_id] = $product_info;
					}
				}
			}
		} else if ($setting['type_product'] == "related") {
			if (isset($this->request->get['product_id'])) {
				$results = $this->model_catalog_product->getProductRelated((int)$this->request->get['product_id']);
			}
		}

		if(!empty($results)){

			if(isset($setting['image_width'])){
				$image_width = $setting['image_width'];
			} else {
				$image_width = 200;
			}

			if(isset($setting['image_height'])){
				$image_height = $setting['image_height'];
			} else {
				$image_height = 200;
			}

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

					$money_save_original = $result['price'] - $result['special'];
					$percent = round((float)($money_save_original/$result['price']*100),0);
				} else {
					$special = false;
					$percent = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				$products[] = array(
					'product_id' => $result['product_id'],
					'percent' 	 => $percent,
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'   	 => $price,
					'special' 	 => $special,
					'minimum' 	 => $result['minimum'],
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}
		}

		if (isset($image_width)) {
			$data['image_width'] = $image_width;
		} else {
			$data['image_width'] = 200;
		}

		$data['product_data'] = array();

		$data['product_data'] = array(
			'products'       => $products,
			'mainproduct'    => $mainproduct
		);

		$data['module'] = $module++;

		return $this->load->view('extension/module/boss_featured', $data);
	}
}