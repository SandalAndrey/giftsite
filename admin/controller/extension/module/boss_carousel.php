<?php
class ControllerExtensionModuleBossCarousel extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('extension/module/boss_carousel');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/module');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('boss_carousel', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}		
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_normal'] = $this->language->get('text_normal');
		$data['text_flip'] = $this->language->get('text_flip');
		$data['text_vertical'] = $this->language->get('text_vertical');
		$data['text_full_width'] = $this->language->get('text_full_width');
		$data['text_fix_1170'] = $this->language->get('text_fix_1170');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_name'] = $this->language->get('entry_name');	
		$data['entry_title'] = $this->language->get('entry_title');	
		$data['entry_banner'] = $this->language->get('entry_banner');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_num_row'] = $this->language->get('entry_num_row');
		$data['entry_img_row'] = $this->language->get('entry_img_row');
		$data['entry_scroll'] = $this->language->get('entry_scroll');
		$data['entry_image_width'] = $this->language->get('entry_image_width');
		$data['entry_image_height'] = $this->language->get('entry_image_height');
		$data['entry_center'] = $this->language->get('entry_center');
		$data['entry_auto'] = $this->language->get('entry_auto');
		$data['entry_time'] = $this->language->get('entry_time');
		$data['entry_style'] = $this->language->get('entry_style');
		$data['entry_navigation'] = $this->language->get('entry_navigation');
		$data['entry_pagination'] = $this->language->get('entry_pagination');
		$data['entry_layout_width'] = $this->language->get('entry_layout_width');
		$data['entry_opacity'] = $this->language->get('entry_opacity');
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
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
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL'),
      		'separator' => ' :: '
   		);
		
   		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner', 'user_token=' . $this->session->data['user_token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/boss_carousel', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/boss_carousel', 'user_token=' . $this->session->data['user_token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/module/boss_carousel', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
   		
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL');
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
			$data['title'] = '';
		}
		
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}
		
		if (isset($this->request->post['num_row'])) {
			$data['num_row'] = $this->request->post['num_row'];
		} elseif (!empty($module_info)) {
			$data['num_row'] = $module_info['num_row'];
		} else {
			$data['num_row'] = 1;
		}
		
		if (isset($this->request->post['img_row'])) {
			$data['img_row'] = $this->request->post['img_row'];
		} elseif (!empty($module_info)) {
			$data['img_row'] = $module_info['img_row'];
		} else {
			$data['img_row'] = 4;
		}
		
		if (isset($this->request->post['image_width'])) {
			$data['image_width'] = $this->request->post['image_width'];
		} elseif (!empty($module_info)) {
			$data['image_width'] = $module_info['image_width'];
		} else {
			$data['image_width'] = 80;
		}
		
		if (isset($this->request->post['image_height'])) {
			$data['image_height'] = $this->request->post['image_height'];
		} elseif (!empty($module_info)) {
			$data['image_height'] = $module_info['image_height'];
		} else {
			$data['image_height'] = 80;
		}
		
		if (isset($this->request->post['banner_id'])) {
			$data['banner_id'] = $this->request->post['banner_id'];
		} elseif (!empty($module_info)) {
			$data['banner_id'] = $module_info['banner_id'];
		} else {
			$data['banner_id'] = '';
		}
		
		if (isset($this->request->post['center'])) {
			$data['center'] = $this->request->post['center'];
		} elseif (!empty($module_info)) {
			$data['center'] = $module_info['center'];
		} else {
			$data['center'] = 0;
		}
		
		if (isset($this->request->post['auto'])) {
			$data['auto'] = $this->request->post['auto'];
		} elseif (!empty($module_info)) {
			$data['auto'] = $module_info['auto'];
		} else {
			$data['auto'] = 0;
		}
		
		if (isset($this->request->post['time'])) {
			$data['time'] = $this->request->post['time'];
		} elseif (!empty($module_info)) {
			$data['time'] = $module_info['time'];
		} else {
			$data['time'] = 5;
		}
		
		if (isset($this->request->post['style'])) {
			$data['style'] = $this->request->post['style'];
		} elseif (!empty($module_info)) {
			$data['style'] = $module_info['style'];
		} else {
			$data['style'] = '';
		}
		
		if (isset($this->request->post['layout_width'])) {
			$data['layout_width'] = $this->request->post['layout_width'];
		} elseif (!empty($module_info)) {
			$data['layout_width'] = $module_info['layout_width'];
		} else {
			$data['layout_width'] = '';
		}
		
		if (isset($this->request->post['navigation'])) {
			$data['navigation'] = $this->request->post['navigation'];
		} elseif (!empty($module_info)) {
			$data['navigation'] = $module_info['navigation'];
		} else {
			$data['navigation'] = '';
		}
		
		if (isset($this->request->post['pagination'])) {
			$data['pagination'] = $this->request->post['pagination'];
		} elseif (!empty($module_info)) {
			$data['pagination'] = $module_info['pagination'];
		} else {
			$data['pagination'] = '';
		}
		
		if (isset($this->request->post['opacity'])) {
			$data['opacity'] = $this->request->post['opacity'];
		} elseif (!empty($module_info)) {
			$data['opacity'] = $module_info['opacity'];
		} else {
			$data['opacity'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$this->load->model('design/banner');
		$data['banners'] = $this->model_design_banner->getBanners();
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/boss_carousel', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/boss_carousel')) {
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
	}
	
	
}
?>