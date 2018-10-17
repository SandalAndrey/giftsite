<?php
class ControllerExtensionModuleBossProductShowing extends Controller {
	public function index($setting) {
		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/boss_product_showing');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_product_showing.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_product_showing.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_product_showing.css');
		}

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$language_id = (int)$this->config->get('config_language_id');

		$product_info = $this->model_catalog_product->getProduct($setting['product_id']);

		if ($product_info) {
			$data['product_id'] = $product_info['product_id'];

			$data['heading_title'] = (!empty($setting['title'][$language_id])) ? $setting['title'][$language_id] : $product_info['name'];

			if (isset($setting['description'][$language_id]) && !empty(strip_tags(html_entity_decode($setting['description'][$language_id])))) {
				$data['description'] = html_entity_decode($setting['description'][$language_id]);
			} else {
				$data['description'] = utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..';
			}

			$data['name'] = $product_info['name'];

			if ($product_info['image']) {
				$data['image'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$data['image'] = '';
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['price'] = false;
			}

			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['special'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}

			$data['minimum'] = $product_info['minimum'] > 0 ? $product_info['minimum'] : 1;

			$data['href'] = $this->url->link('product/product', 'product_id=' . $product_info['product_id']);

			$data['attributes'] = array();

			if (!empty($setting['attribute'])) {
				usort($setting['attribute'], function($i1, $i2) {
					return $i1['sort_order'] - $i2['sort_order'];
				});

				foreach ($setting['attribute'] as $attribute) {
					$data['attributes'][] = array(
						'name' => (isset($attribute['attribute_description'][$language_id]['name'])) ? $attribute['attribute_description'][$language_id]['name'] : '',
						'image' => ($attribute['image']) ? 'image/' . $attribute['image'] : ''
					);
				}
			}
		}

		if ($product_info) {
			return $this->load->view('extension/module/boss_product_showing', $data);
		}
	}
}