<?php
class ControllerBossblogSetting extends Controller {
        private $error = array();
        private $_name = 'module_bossblog';
        public function index() { 
    	$this->load->language('bossblog/setting');
        
        $this->load->model('bossblog/bossblog');
 
    	$this->document->setTitle($this->language->get('heading_title'));
        
        //$this->document->addStyle('view/stylesheet/bossthemes/bossblog.css');
        
       	$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		  
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);
            
            if (isset($this->request->post['seo_url'])) {
                
                $this->model_bossblog_bossblog->editSeoUrl('bossblog/bossblog',$this->request->post['seo_url']);
    		}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('bossblog/setting', 'user_token=' . $this->session->data['user_token'], 'SSL'));
		}

    	$data['heading_title'] = $this->language->get('heading_title');
        
        /*  New Boss Blog */
         $data['heading_title'] = $this->language->get('heading_title'); 
         $data['text_boss_category'] = $this->language->get('text_boss_category'); 
         $data['text_boss_articles'] = $this->language->get('text_boss_articles'); 
         $data['text_boss_comments'] = $this->language->get('text_boss_comments');   
         $data['text_boss_settings'] = $this->language->get('text_boss_settings');  
         
         $data['boss_category'] = $this->url->link('bossblog/category', 'user_token=' . $this->session->data['user_token'], 'SSL');
         $data['boss_articles'] = $this->url->link('bossblog/articles', 'user_token=' . $this->session->data['user_token'], 'SSL');
         $data['boss_comments'] = $this->url->link('bossblog/comment', 'user_token=' . $this->session->data['user_token'], 'SSL');
         $data['boss_settings'] = $this->url->link('bossblog/setting', 'user_token=' . $this->session->data['user_token'], 'SSL');
        /* End New Boss Blog */
        
        //text
        $data['text_items'] = $this->language->get('text_items');
        $data['text_article'] = $this->language->get('text_article');
        $data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
        
		//help
		$data['help_seo_url'] = $this->language->get('help_seo_url');
		$data['help_bossblog_limit'] = $this->language->get('help_bossblog_limit');
		$data['help_blog_admin_limit'] = $this->language->get('help_blog_admin_limit');
		$data['help_article_count'] = $this->language->get('help_article_count');
		$data['help_comment'] = $this->language->get('help_comment');
		$data['help_approval'] = $this->language->get('help_approval');
		
        //button
        $data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
        
        //tab
        $data['tab_general'] = $this->language->get('tab_general');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_image'] = $this->language->get('tab_image');
        
        //entry
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_image_category'] = $this->language->get('entry_image_category');
		$data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
		$data['entry_image_article'] = $this->language->get('entry_image_article');
		$data['entry_image_title'] = $this->language->get('entry_image_title');
		$data['entry_image_related'] = $this->language->get('entry_image_related');
        $data['entry_bossblog_limit'] = $this->language->get('entry_bossblog_limit');
		$data['entry_blog_admin_limit'] = $this->language->get('entry_blog_admin_limit');
        $data['entry_comment'] = $this->language->get('entry_comment');
        $data['entry_approval'] = $this->language->get('entry_approval');
        $data['entry_article_count'] = $this->language->get('entry_article_count');
        $data['entry_seo_url'] = $this->language->get('entry_seo_url');

		//$data['text_not_found'] = $this->language->get('text_not_found');
        
        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
 		if (isset($this->error['blog_name'])) {
			$data['error_blog_name'] = $this->error['blog_name'];
		} else {
			$data['error_blog_name'] = '';
		}
        
        if (isset($this->error['blog_image_category'])) {
			$data['error_blog_image_category'] = $this->error['blog_image_category'];
		} else {
			$data['error_blog_image_category'] = '';
		}
				
 		if (isset($this->error['blog_image_article'])) {
			$data['error_blog_image_article'] = $this->error['blog_image_article'];
		} else {
			$data['error_blog_image_article'] = '';
		}
		
 		if (isset($this->error['blog_image_title'])) {
			$data['error_blog_image_title'] = $this->error['blog_image_title'];
		} else {
			$data['error_blog_image_title'] = '';
        }
		
 		if (isset($this->error['blog_image_related'])) {
			$data['error_blog_image_related'] = $this->error['blog_image_related'];
		} else {
			$data['error_blog_image_related'] = '';
        }
        
        if (isset($this->error['bossblog_limit'])) {
			$data['error_bossblog_limit'] = $this->error['bossblog_limit'];
		} else {
			$data['error_bossblog_limit'] = '';
		}
		
		if (isset($this->error['blog_admin_limit'])) {
			$data['error_blog_admin_limit'] = $this->error['blog_admin_limit'];
		} else {
			$data['error_blog_admin_limit'] = '';
		}
		
		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('extension/module/bossblog', 'user_token=' . $this->session->data['user_token'], 'SSL'),
			'text'      => $this->language->get('heading_bossblog'),
			'separator' => ' :: '
		);
        
        $data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/setting', 'user_token=' . $this->session->data['user_token'], 'SSL'),
      		'separator' => ' :: '
   		);
        
        if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
        
        $data['action'] = $this->url->link('bossblog/setting', 'user_token=' . $this->session->data['user_token'], 'SSL');
		
		$data['cancel'] = $this->url->link('bossblog/setting', 'user_token=' . $this->session->data['user_token'], 'SSL');
		
	//	$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['module_bossblog_name'])) {
			$data['module_bossblog_name'] = $this->request->post['module_bossblog_name'];
		} else {
			$data['module_bossblog_name'] = $this->config->get('module_bossblog_name');
		}
        
        if (isset($this->request->post['module_bossblog_limit'])) {
			$data['module_bossblog_limit'] = $this->request->post['module_bossblog_limit'];
		} else {
			$data['module_bossblog_limit'] = $this->config->get('module_bossblog_limit');
		}	
						
		if (isset($this->request->post['module_bossblog_admin_limit'])) {
			$data['module_bossblog_admin_limit'] = $this->request->post['module_bossblog_admin_limit'];
		} else {
			$data['module_bossblog_admin_limit'] = $this->config->get('module_bossblog_admin_limit');
		}
        	
		if (isset($this->request->post['module_bossblog_comment_status'])) {
			$data['module_bossblog_comment_status'] = $this->request->post['module_bossblog_comment_status'];
		} else {
			$data['module_bossblog_comment_status'] = $this->config->get('module_bossblog_comment_status');
		}
        
        if (isset($this->request->post['module_bossblog_approval_status'])) {
			$data['module_bossblog_approval_status'] = $this->request->post['module_bossblog_approval_status'];
		} else {
			$data['module_bossblog_approval_status'] = $this->config->get('module_bossblog_approval_status');
		}
        
        $seo_url = $this->model_bossblog_bossblog->getSeoUrl('bossblog/bossblog');
        
        if (isset($this->request->post['seo_url'])) { 
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($seo_url)) { 
			$data['seo_url'] = $seo_url;
		} else {
			$data['seo_url'] = array();
		}

        $this->load->model('tool/image');
        
        $data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['module_bossblog_image_category_width'])) {
			$data['module_bossblog_image_category_width'] = $this->request->post['module_bossblog_image_category_width'];
		} else {
			$data['module_bossblog_image_category_width'] = $this->config->get('module_bossblog_image_category_width');
		}
		
		if (isset($this->request->post['module_bossblog_image_category_height'])) {
			$data['module_bossblog_image_category_height'] = $this->request->post['module_bossblog_image_category_height'];
		} else {
			$data['module_bossblog_image_category_height'] = $this->config->get('module_bossblog_image_category_height');
		}
        		
		if (isset($this->request->post['module_bossblog_image_article_width'])) {
			$data['module_bossblog_image_article_width'] = $this->request->post['module_bossblog_image_article_width'];
		} else {
			$data['module_bossblog_image_article_width'] = $this->config->get('module_bossblog_image_article_width');
		}
		
		if (isset($this->request->post['module_bossblog_image_article_height'])) {
			$data['module_bossblog_image_article_height'] = $this->request->post['module_bossblog_image_article_height'];
		} else {
			$data['module_bossblog_image_article_height'] = $this->config->get('module_bossblog_image_article_height');
		}
		
		if (isset($this->request->post['module_bossblog_image_title_width'])) {
			$data['module_bossblog_image_title_width'] = $this->request->post['module_bossblog_image_title_width'];
		} else {
			$data['module_bossblog_image_title_width'] = $this->config->get('module_bossblog_image_title_width');
		}
		
		if (isset($this->request->post['module_bossblog_image_title_height'])) {
			$data['module_bossblog_image_title_height'] = $this->request->post['module_bossblog_image_title_height'];
		} else {
			$data['module_bossblog_image_title_height'] = $this->config->get('module_bossblog_image_title_height');
		}
		
		if (isset($this->request->post['module_bossblog_image_related_width'])) {
			$data['module_bossblog_image_related_width'] = $this->request->post['module_bossblog_image_related_width'];
		} else {
			$data['module_bossblog_image_related_width'] = $this->config->get('module_bossblog_image_related_width');
		}
		
		if (isset($this->request->post['module_bossblog_image_related_height'])) {
			$data['module_bossblog_image_related_height'] = $this->request->post['module_bossblog_image_related_height'];
		} else {
			$data['module_bossblog_image_related_height'] = $this->config->get('module_bossblog_image_related_height');
		}
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('bossblog/setting', $data));
  	}
          
    private function validate() {
		if (!$this->request->post['module_bossblog_name']) {
			$this->error['blog_name'] = $this->language->get('error_blog_name');
		}	
	
		if (!$this->request->post['module_bossblog_image_category_height'] || !$this->request->post['module_bossblog_image_category_width']) {
			$this->error['blog_image_category'] = $this->language->get('error_blog_image_category');
		}	
		
		if (!$this->request->post['module_bossblog_image_article_height'] || !$this->request->post['module_bossblog_image_article_width']) {
			$this->error['blog_image_article'] = $this->language->get('error_blog_image_article');
		}			
		
		if (!$this->request->post['module_bossblog_image_title_height'] || !$this->request->post['module_bossblog_image_title_width']) {
			$this->error['blog_image_title'] = $this->language->get('error_blog_image_title');
		}
		
		if (!$this->request->post['module_bossblog_image_related_height'] || !$this->request->post['module_bossblog_image_related_width']) {
			$this->error['blog_image_related'] = $this->language->get('error_blog_image_related');
		}
		
		
		if (!$this->request->post['module_bossblog_admin_limit']) {
			$this->error['blog_admin_limit'] = $this->language->get('error_limit');
		}
		
		if (!$this->request->post['module_bossblog_limit']) {
			$this->error['bossblog_limit'] = $this->language->get('error_limit');
		}
		
		if ($this->request->post['seo_url']) {
			$this->load->model('design/seo_url');
			
			foreach ($this->request->post['seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (trim($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}						
						
						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
						
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['blog_category_id']) || (($seo_url['query'] != 'blog_category_id=' . $this->request->get['blog_category_id'])))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
								
								break;
							}
						}
					}
				}
			}
		}		
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
    
}
?>