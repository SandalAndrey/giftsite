<?php  
class ControllerBossthemesBossPopupCart extends Controller {
	public function index() {
		$json = array();
		$data = array();
		$limit = 3;
		
		if (isset($this->request->post['json'])) {
			$data = $this->request->post['json'];
		} else {
			$data = 0;
		}
		//echo'<pre>';print_r($this->request->post);echo'</pre>';die();
		if (isset($this->request->post['type_product'])) {
			$data['type_product'] = $this->request->post['type_product'];
		} else {
			$data['type_product'] = 'popular';
		}
		
		$data['image'] = '';
		$data['name'] = '';
		$this->load->model('tool/image');
		
		if($data['product_id']){
			$this->load->model('catalog/product');

			$product_info = $this->model_catalog_product->getProduct($data['product_id']);
			
			if($product_info){
				if($product_info['image']){
					$data['image'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_height'));
				}
				
				$data['name'] = $product_info['name'];
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}
				$data['price'] = $price;
			}
		}
		
		$this->load->model('catalog/product');
		$this->load->language('bossthemes/boss_popup_cart');
		
		$data['text_product_added'] = $this->language->get('text_product_added');
		$data['text_customer_bought'] = $this->language->get('text_customer_bought');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_item'] = $this->language->get('text_item');
		
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_checkout'] = $this->language->get('button_checkout');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_close'] = $this->language->get('button_close');
		
		$language_id = $this->config->get('config_language_id');
		$text_save_off = $this->config->get('theme_' . $this->config->get('config_theme') . '_text_save_off');
		$data['text_save_off'] = (isset($text_save_off[$language_id])) ? $text_save_off[$language_id] : '';
		
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		
		$data['sum_cart'] = $this->cart->countProducts();
		
		switch($data['type_product']){
			case "popular":
				$results = $this->model_catalog_product->getPopularProducts($limit);
				break;
			case "special":
				$data_sort = array(
					'sort'  => 'pd.name',
					'order' => 'ASC',
					'start' => 0,
					'limit' => $limit
				);
				$results = $this->model_catalog_product->getProductSpecials($data_sort);
				break;
			case "best_seller":
				$results = $this->model_catalog_product->getBestSellerProducts($limit);
				break;
			case "latest":
				$results = $this->model_catalog_product->getLatestProducts($limit);
				break;
		}
		
		$data['products'] = array();
		
		if(!empty($results)){
		
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
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

				$data['products'][] = array(
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
		}
		
		$json['html'] = $this->load->view('bossthemes/boss_popup_cart', $data);
		
		$this->response->addHeader('Content-Type: application/json');		
		$this->response->setOutput(json_encode($json));
	}
}