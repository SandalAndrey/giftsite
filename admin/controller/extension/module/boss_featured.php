<?php
class ControllerExtensionModuleBossFeatured extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('extension/module/boss_featured');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('boss_featured', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL'));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = array();
		}
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = array();
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_featured', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_featured', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/boss_featured', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/boss_featured', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data['user_token'] = $this->session->data['user_token'];

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_get_product'] = $this->language->get('text_get_product');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');

		// Entry 
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_img_large'] = $this->language->get('entry_img_large');
		$data['entry_add_img_large'] = $this->language->get('entry_add_img_large');
		$data['entry_row'] = $this->language->get('entry_row');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_scroll'] = $this->language->get('entry_scroll');
		$data['entry_properrow'] = $this->language->get('entry_properrow');
		$data['entry_get_prolarge'] = $this->language->get('entry_get_prolarge');
		$data['entry_prolarge'] = $this->language->get('entry_prolarge');
		$data['entry_show_prolarge'] = $this->language->get('entry_show_prolarge');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_column'] = $this->language->get('entry_column');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_pagination'] = $this->language->get('entry_pagination');
		$data['entry_center'] = $this->language->get('entry_center');
		$data['entry_product_layout'] = $this->language->get('entry_product_layout');
		
		// Button
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		// Banner
		$data['text_banner_left'] = $this->language->get('text_banner_left');
		
		$data['entry_banner_left'] = $this->language->get('entry_banner_left');
		$data['entry_banner_left_link'] = $this->language->get('entry_banner_left_link');
		
		$data['text_banner_right'] = $this->language->get('text_banner_right');
		
		$data['entry_banner_right'] = $this->language->get('entry_banner_right');
		$data['entry_banner_right_link'] = $this->language->get('entry_banner_right_link');

		$data['filter_types'] = array(
			"popular" =>$this->language->get('text_popular_products'),
			"special" =>$this->language->get('text_special_products'),
			"best_seller" =>$this->language->get('text_best_seller_products'),
			"latest" =>$this->language->get('text_latest_products'),
			"featured" =>$this->language->get('text_featured_products'),
			"related" =>$this->language->get('text_related_products'),
			"category" =>$this->language->get('text_choose_a_category')
		);
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($module_info)) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = array();
		}
		
		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		}else if (!empty($module_info)) {
			$data['description'] = $module_info['description'];
		} else {
			$data['description'] = array();
		}

		if (isset($this->request->post['type_product'])) {
			$data['type_product'] = $this->request->post['type_product'];
		} elseif (!empty($module_info)) {
			$data['type_product'] = $module_info['type_product'];
		} else {
			$data['type_product'] = '';
		}

		$type_product = $data['type_product'];

		$data['product_larges'] = array();

		$this->load->model('catalog/product');

		$data['products'] = array();

		if (isset($this->request->post['product_featured'])) {
			$products = $this->request->post['product_featured'];
		} elseif (!empty($module_info['product_featured'])) {
			$products = $module_info['product_featured'];
		} else {
			$products = array();
		}

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}
		
		if (isset($this->request->post['category'])) {
			$data['category_name'] = $this->request->post['category'];
		} elseif (isset($module_info['category'])) {
			$data['category_name'] = $module_info['category'];
		} else {
			$data['category_name'] = '';
		}

		if (isset($this->request->post['category_id'])) {
			$data['category_id'] = $this->request->post['category_id'];
		} elseif (isset($module_info['category_id'])) {
			$data['category_id'] = $module_info['category_id'];
		} else {
			$data['category_id'] = '';
		}

		if (isset($this->request->post['product_name'])) {
			$data['product_name'] = $this->request->post['product_name'];
		} elseif (isset($module_info['product_name'])) {
			$data['product_name'] = $module_info['product_name'];
		} else {
			$data['product_name'] = '';
		}

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (isset($module_info['product_id'])) {
			$data['product_id'] = $module_info['product_id'];
		} else {
			$data['product_id'] = '';
		}

		if (isset($this->request->post['image_width'])) {
			$data['image_width'] = $this->request->post['image_width'];
		} elseif (!empty($module_info)) {
			$data['image_width'] = $module_info['image_width'];
		} else {
			$data['image_width'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width');
		}

		if (isset($this->request->post['image_height'])) {
			$data['image_height'] = $this->request->post['image_height'];
		} elseif (!empty($module_info)) {
			$data['image_height'] = $module_info['image_height'];
		} else {
			$data['image_height'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height');
		}

		if (isset($this->request->post['img_width'])) {
			$data['img_width'] = $this->request->post['img_width'];
		} elseif (!empty($module_info)) {
			$data['img_width'] = $module_info['img_width'];
		} else {
			$data['img_width'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width');
		}

		if (isset($this->request->post['img_height'])) {
			$data['img_height'] = $this->request->post['img_height'];
		} elseif (!empty($module_info)) {
			$data['img_height'] = $module_info['img_height'];
		} else {
			$data['img_height'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height');
		}

		if (isset($this->request->post['add_img_width'])) {
			$data['add_img_width'] = $this->request->post['add_img_width'];
		} elseif (!empty($module_info)) {
			$data['add_img_width'] = $module_info['add_img_width'];
		} else {
			$data['add_img_width'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width');
		}

		if (isset($this->request->post['add_img_height'])) {
			$data['add_img_height'] = $this->request->post['add_img_height'];
		} elseif (!empty($module_info)) {
			$data['add_img_height'] = $module_info['add_img_height'];
		} else {
			$data['add_img_height'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height');
		}

		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 4;
		}
		
		$data['column_values'] = array(
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			6 => 6,
			12 => 12
		);

        if (isset($this->request->post['column'])) {
            $data['column'] = $this->request->post['column'];
        } elseif (!empty($module_info)) {
            $data['column'] = $module_info['column'];
        } else {
            $data['column'] = 4;
        }

		if (isset($this->request->post['show_slider'])) {
			$data['show_slider'] = $this->request->post['show_slider'];
		} elseif (!empty($module_info)) {
			$data['show_slider'] = $module_info['show_slider'];
		} else {
			$data['show_slider'] = 0;
		}

		if (isset($this->request->post['num_row'])) {
			$data['num_row'] = $this->request->post['num_row'];
		} elseif (!empty($module_info)) {
			$data['num_row'] = $module_info['num_row'];
		} else {
			$data['num_row'] = 1;
		}

		if (isset($this->request->post['per_row'])) {
			$data['per_row'] = $this->request->post['per_row'];
		} elseif (!empty($module_info)) {
			$data['per_row'] = $module_info['per_row'];
		} else {
			$data['per_row'] = 4;
		}

		if (isset($this->request->post['pagination'])) {
			$data['pagination'] = $this->request->post['pagination'];
		} elseif (!empty($module_info)) {
			$data['pagination'] = $module_info['pagination'];
		} else {
			$data['pagination'] = 0;
		}
		
		if (isset($this->request->post['center'])) {
			$data['center'] = $this->request->post['center'];
		} elseif (!empty($module_info)) {
			$data['center'] = $module_info['center'];
		} else {
			$data['center'] = 0;
		}

		$data['product_layout_values'] = array(
			'product-grid' => $this->language->get('text_grid'),
			'product-list' => $this->language->get('text_list')
		);
		
        if (isset($this->request->post['product_layout'])) {
            $data['product_layout'] = $this->request->post['product_layout'];
        } elseif (!empty($module_info)) {
            $data['product_layout'] = $module_info['product_layout'];
        } else {
            $data['product_layout'] = '';
        }

		if (isset($this->request->post['show_pro_large'])) {
			$data['show_pro_large'] = $this->request->post['show_pro_large'];
		} elseif (!empty($module_info)) {
			$data['show_pro_large'] = $module_info['show_pro_large'];
		} else {
			$data['show_pro_large'] = '';
		}
		
		$data['position_values'] = array(
			'content' => $this->language->get('text_content'),
			'sidebar' => $this->language->get('text_sidebar')
		);
		
        if (isset($this->request->post['position'])) {
            $data['position'] = $this->request->post['position'];
        } elseif (!empty($module_info)) {
            $data['position'] = $module_info['position'];
        } else {
            $data['position'] = '';
        }

        $data['status_values'] = array(
            "0" => $this->language->get('text_disabled'),
            "1" => $this->language->get('text_enabled')
        );

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = 0;
        }
		
		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['banner_left'])) {
			$data['banner_left'] = $this->request->post['banner_left'];
		} elseif (!empty($module_info)) {
			$data['banner_left'] = $module_info['banner_left'];
		} else {
			$data['banner_left'] = array();
		}
		
		if (!isset($data['banner_left']['image'])) {
			$data['banner_left']['image'] = '';
		}
		
		if (!empty($data['banner_left']['image'])) {
			$data['banner_left']['thumb'] = $this->model_tool_image->resize($data['banner_left']['image'], 100, 100);;
		} else {
			$data['banner_left']['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		
		if (!isset($data['banner_left']['link'])) {
			$data['banner_left']['link'] = '';
		}
		
		if (isset($this->request->post['banner_right'])) {
			$data['banner_right'] = $this->request->post['banner_right'];
		} elseif (!empty($module_info)) {
			$data['banner_right'] = $module_info['banner_right'];
		} else {
			$data['banner_right'] = array();
		}
		
		if (!isset($data['banner_right']['image'])) {
			$data['banner_right']['image'] = '';
		}
		
		if (!empty($data['banner_right']['image'])) {
			$data['banner_right']['thumb'] = $this->model_tool_image->resize($data['banner_right']['image'], 100, 100);;
		} else {
			$data['banner_right']['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		
		if (!isset($data['banner_right']['link'])) {
			$data['banner_right']['link'] = '';
		}
		
		//load languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		include_once(DIR_SYSTEM . 'library/btform.php');
		$data['btform'] = new Btform();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/boss_featured', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/boss_featured')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['image_width']) {
			$this->error['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['image_height']) {
			$this->error['height'] = $this->language->get('error_height');
		}

		return !$this->error;

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

}
?>