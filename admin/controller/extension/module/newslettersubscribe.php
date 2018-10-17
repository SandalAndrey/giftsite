<?php
class ControllerExtensionModuleNewslettersubscribe extends Controller {
	private $error = array(); 
	
	public function index() {   
	
		$this->load->language('extension/module/newslettersubscribe');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('tool/image');
		$this->load->model('setting/module');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
				
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('newslettersubscribe', $this->request->post);
				
				$module_id = $this->db->getLastId();
				$data_module = $this->request->post;
				$data_module['module_id'] = $module_id;
				$this->model_setting_module->editModule($module_id, $data_module);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}		 
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_background'] = $this->language->get('entry_background');
		$data['entry_unsubscribe'] = $this->language->get('entry_unsubscribe');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_sub_title'] = $this->language->get('entry_sub_title');
		$data['entry_subject'] = $this->language->get('entry_subject');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_registered'] = $this->language->get('entry_registered');	
		$data['entry_mail'] = $this->language->get('entry_mail');
		$data['entry_options'] = $this->language->get('entry_options');
		$data['entry_popup'] = $this->language->get('entry_popup');
		$data['entry_mail_subscribe'] = $this->language->get('entry_mail_subscribe');
		$data['entry_mail_unsubscribe'] = $this->language->get('entry_mail_unsubscribe');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['tab_newsletter'] = $this->language->get('tab_newsletter');
		$data['tab_popup'] = $this->language->get('tab_popup');
		$data['tab_mail'] = $this->language->get('tab_mail');
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
 		
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
		
   		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/newslettersubscribe', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/newslettersubscribe', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/newslettersubscribe', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
   		
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
			$data['module_id'] = $this->request->get['module_id'];
		}	
			
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		$data['positions'] = array(
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
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
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
		
		if (isset($this->request->post['unsubscribe'])) {
			$data['unsubscribe'] = $this->request->post['unsubscribe'];
		} elseif (!empty($module_info)) {
			$data['unsubscribe'] = $module_info['unsubscribe'];
		} else {
			$data['unsubscribe'] = '';
		}
		
		if (isset($this->request->post['registered'])) {
			$data['registered'] = $this->request->post['registered'];
		} elseif (!empty($module_info)) {
			$data['registered'] = $module_info['registered'];
		} else {
			$data['registered'] = '';
		}
		
		if (isset($this->request->post['newsletter'])) {
			$data['newsletter'] = $this->request->post['newsletter'];
		} elseif (!empty($module_info)) {
			$data['newsletter'] = $module_info['newsletter'];
		} else {
			$data['newsletter'] = array();
		}
		
		if (isset($this->request->post['show_popup'])) {
			$data['show_popup'] = $this->request->post['show_popup'];
		} elseif (!empty($module_info['show_popup'])) {
			$data['show_popup'] = $module_info['show_popup'];
		} else {
			$data['show_popup'] = '';
		}
		
		if (isset($this->request->post['popup'])) {
			$data['popup'] = $this->request->post['popup'];
		} elseif (!empty($module_info)) {
			$data['popup'] = $module_info['popup'];
		} else {
			$data['popup'] = array();
		}
		
		if (!empty($data['popup']['background'])  && is_file(DIR_IMAGE . $data['popup']['background'])) {
			$data['bg_thumb_popup'] = $this->model_tool_image->resize($data['popup']['background'], 100, 100);
		} else {
			$data['bg_thumb_popup'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['mail_status'])) {
			$data['mail_status'] = $this->request->post['mail_status'];
		} elseif (!empty($module_info)) {
			$data['mail_status'] = $module_info['mail_status'];
		} else {
			$data['mail_status'] = '';
		}
		
		if (isset($this->request->post['mail'])) {
			$data['mail'] = $this->request->post['mail'];
		} elseif (!empty($module_info)) {
			$data['mail'] = $module_info['mail'];
		} else {
			$data['mail'] = array();
		}
		
		//load languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/newslettersubscribe', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/newslettersubscribe')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;	
	}
	
	public function install() {
		 $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "subscribe (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `email_id` varchar(225) NOT NULL,
		  `name` varchar(225) NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `Index_2` (`email_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;");
	}
}