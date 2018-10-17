<?php
class ControllerExtensionModuleBossProcate extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/boss_procate');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/module');
        $this->load->model('catalog/category');
		$this->load->model('tool/image');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('boss_procate', $this->request->post);
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->error['category'])) {
            $data['error_category'] = $this->error['category'];
        } else {
            $data['error_category'] = '';
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
		
        if (isset($this->error['num_row'])) {
            $data['error_num_row'] = $this->error['num_row'];
        } else {
            $data['error_num_row'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('extension/module/boss_procate', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => ' :: '
        );

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/boss_procate', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/boss_procate', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['user_token'] = $this->session->data['user_token'];

        $data['heading_title'] = $this->language->get('heading_title');

        // Entry
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_title'] = $this->language->get('entry_title');
		$data['entry_background'] = $this->language->get('entry_background');
        $data['entry_image'] = $this->language->get('entry_image');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_limit'] = $this->language->get('entry_limit');
        $data['entry_scrolling'] = $this->language->get('entry_scrolling');
		$data['entry_num_row'] = $this->language->get('entry_num_row');
        $data['entry_per_row'] = $this->language->get('entry_per_row');
        $data['entry_column'] = $this->language->get('entry_column');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_show_slide'] = $this->language->get('entry_show_slide');
		$data['entry_product_layout'] = $this->language->get('entry_product_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		
		// Help
		$data['help_category'] = $this->language->get('help_category');
		
        // Button
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_add_tab'] = $this->language->get('button_add_tab');
		
        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }
        //echo '<pre>';print_r($module_info);die();echo '</pre>';
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
            $data['title'] = '';
        }
		
		// Categories
		if (isset($this->request->post['category'])) {
			$categories = $this->request->post['category'];
		} elseif (!empty($module_info['category'])) {
			$categories = $module_info['category'];
		} else {
			$categories = array();
		}

		$data['categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}
		
		if (isset($this->request->post['bg_image'])) {
			$data['bg_image'] = $this->request->post['bg_image'];
		} elseif (!empty($module_info['bg_image'])) {
			$data['bg_image'] = $module_info['bg_image'];
		} else {
			$data['bg_image'] = '';
		}
		
		if (isset($this->request->post['bg_image']) && is_file(DIR_IMAGE . $this->request->post['bg_image'])) {
			$data['bg_thumb'] = $this->model_tool_image->resize($this->request->post['bg_image'], 100, 100);
		} else if (!empty($module_info['bg_image']) && is_file(DIR_IMAGE . $module_info['bg_image'])) {
			$data['bg_thumb'] = $this->model_tool_image->resize($module_info['bg_image'], 100, 100);
		} else {
			$data['bg_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['show_slider'])) {
            $data['show_slider'] = $this->request->post['show_slider'];
        } elseif (!empty($module_info)) {
            $data['show_slider'] = $module_info['show_slider'];
        } else {
            $data['show_slider'] = 1;
        }

        if (isset($this->request->post['limit'])) {
            $data['limit'] = $this->request->post['limit'];
        } elseif (!empty($module_info)) {
            $data['limit'] = $module_info['limit'];
        } else {
            $data['limit'] = 5;
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

        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
		
		include_once(DIR_SYSTEM . 'library/btform.php');
		$data['btform'] = new Btform();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/boss_procate', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/boss_procate')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (!isset($this->request->post['category'])) {
            $this->error['category'] = $this->language->get('error_category');
        }

        if (empty($this->request->post['image_width'])) {
            $this->error['width'] = $this->language->get('error_width');
        }

        if (empty($this->request->post['image_height'])) {
            $this->error['height'] = $this->language->get('error_height');
        }
		
        if (empty($this->request->post['num_row'])) {
            $this->error['num_row'] = $this->language->get('error_num_row');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
?>