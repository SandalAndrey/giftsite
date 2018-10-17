<?php
class ControllerBossThemesUtilities extends Controller {
	public function optionPrice() {
		$this->load->model('catalog/product');
		$this->load->model('bossthemes/utilities');
		
		$quantity = $this->request->get['quantity'];
		
		$option_data = array();

		if (!empty($this->request->get['option'])) {
			foreach($this->request->get['option'] as $option) {

				if (!empty($option)) {
					if (is_array($option)) {
						foreach($option as $o) {
							$option_data[] = $this->model_bossthemes_utilities->getOptionValue($o);
						}
					} else {
						$option_data[] = $this->model_bossthemes_utilities->getOptionValue($option);
					}
				}
			}
		}

		$product = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		$discount = $this->model_bossthemes_utilities->getDiscount($this->request->get['product_id'], $quantity);

		$price = $discount ? $discount : $product['price'];
		$special = $product['special'];
		$points = $product['points'];
		$weight = $product['weight'];

		if (!empty($option_data)) {
			foreach($option_data as $option) {
				//price
				if ($option['price_prefix'] == '+') {
					if (!empty($special)) {
						$special += $option['price'];
					}

					$price += $option['price'];
				} else {
					if (!empty($special)) {
						$special -= $option['price'];
					}

					$price -= $option['price'];
				}

				//reward
				if ($option['points_prefix'] == '+') {
					$points += $option['points'];
				} else {
					$points -= $option['points'];
				}

				//weight
				if ($option['weight_prefix'] == '+') {
					$weight += $option['weight'];
				} else {
					$weight -= $option['weight'];
				}
			}
		}
		
		$json = array(
			'price' => $this->currency->format($this->tax->calculate($price, $product['tax_class_id'], $this->config->get('config_tax')) * $quantity, $this->session->data['currency']),
			'special' => !empty($special) ? $this->currency->format($this->tax->calculate($special, $product['tax_class_id'], $this->config->get('config_tax')) * $quantity, $this->session->data['currency']) : false,
			'ex_tax' => $this->currency->format((float)$special ? $special * $quantity : $price * $quantity, $this->session->data['currency']),
			'points' => $points * $quantity,
			'weight' => $this->weight->format($weight * $quantity, $product['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point')),
		);

		$this->response->setOutput(json_encode($json));
	}
}
