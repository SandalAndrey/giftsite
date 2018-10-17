<?php
class ControllerExtensionModuleBossProcate extends Controller {
    public function index($setting) {
		if(empty($setting))	return;
        static $module = 0;

        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('tool/image');

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_procate.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_procate.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_procate.css');
		}

		if ($setting['show_slider']) {
			$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.css');

			if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css');
			} else {
				$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.theme.default.min.css');
			}

			$this->document->addScript('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.js');
		}

        $_language = new Language($this->config->get('config_language'));
        $_language->load('extension/module/boss_procate');
        $data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		$language_id = $this->config->get('config_language_id');

		$text_save_off = $this->config->get('theme_' . $this->config->get('config_theme') . '_text_save_off');
		$data['text_save_off'] = (isset($text_save_off[$language_id])) ? $text_save_off[$language_id] : '';

        $data['heading_title'] = !empty($setting['title'][$language_id]) ? $setting['title'][$language_id] : '';

        $mainproduct = array();

        $data['product_datas'] = array();

        if (!empty($setting['image_width'])) {
            $image_width = $setting['image_width'];
        } else {
            $image_width = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width');
        }

        if (!empty($setting['image_height'])) {
            $image_height = $setting['image_height'];
        } else {
            $image_height = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height');
        }

        if (!empty($setting['bg_image'])) {
            $data['bg_image'] = 'image/' . $setting['bg_image'];
        } else {
            $data['bg_image'] = '';
        }

        if (!empty($setting['position']) && $setting['position'] == 'sidebar') {
            $data['sidebar'] = 1;
        } else {
            $data['sidebar'] = 0;
        }

		$limit = (!empty($setting['limit'])) ? $setting['limit'] : 8;

		$data['num_row'] = (!empty($setting['num_row'])) ? $setting['num_row'] : 1;
		$data['per_row'] = (!empty($setting['per_row'])) ? $setting['per_row'] : 3;
		$data['show_slider'] = (!empty($setting['show_slider'])) ? $setting['show_slider'] : 0;
		$data['column'] = (!empty($setting['column'])) ? $setting['column'] : 4;
		$data['product_layout'] = (!empty($setting['product_layout'])) ? $setting['product_layout'] : 'product-grid';

		$data['categories'] = array();

        if (!empty($setting['category'])) {
			foreach ($setting['category'] as $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id);

				if ($category_info) {

					$data_sort = array(
						'filter_category_id' => $category_id,
						'sort'  => 'pd.name',
						'order' => 'ASC',
						'start' => 0,
						'limit' => $limit
					);

					$products = array();

					$results = $this->model_catalog_product->getProducts($data_sort);

					foreach ($results as $result) {
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', $image_width, $image_height);
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
							$rating = (int)$result['rating'];
						} else {
							$rating = false;
						}

						$products[] = array(
							'product_id'  => $result['product_id'],
							'thumb'       => $image,
							'name'        => $result['name'],
							'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
							'price'       => $price,
							'special'     => $special,
							'tax'         => $tax,
							'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
							'rating'      => $result['rating'],
							'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
						);
					}

					$data['categories'][] = array(
						'category_id' => $category_info['category_id'],
						'name' => $category_info['name'],
						'products' => $products
					);
				}
			}
		}

        $data['module'] = $module++;

        return $this->load->view('extension/module/boss_procate', $data);

    }
}