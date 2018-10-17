<?php
class ControllerExtensionBossthemesCustomizer extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/bossthemes/customizer');

		$this->load->model('extension/bossthemes/customizer');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['store_id'])) {
			$store_id = (int)$this->request->get['store_id'];
		} else {
			$store_id = 0;
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && isset($this->request->post['xml'])) {
			$this->model_extension_bossthemes_customizer->saveCustomizer($this->request->post['xml'], $store_id);

			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$url = '';
		
		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . (int)$this->request->get['store_id'];
		}

		$data['title'] = $this->document->getTitle();

		#Get All Language Text
		$data = (isset($data)) ? array_merge($data, $this->language->all()) : $this->language->all();

		$data['base'] = ($this->request->server['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER;

		$this->installStylesheet();
		$this->installJavascript();
		
		$this->load->model('setting/store');

		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default'),
			'url'      => $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG,
			'edit'     => str_replace('&amp;', '&', $this->url->link('extension/bossthemes/customizer', 'user_token=' . $this->session->data['user_token'], true))
		);
		
		$base_url = $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG;

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name'],
				'url'      => $result['url'],
				'edit'     => str_replace('&amp;', '&', $this->url->link('extension/bossthemes/customizer', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $result['store_id'], true))
			);
			
			if ($store['store_id'] == $store_id) {
				$base_url = $result['url'];
			}
		}

		$data['sections'] = $this->model_extension_bossthemes_customizer->getCustomizerItem($store_id);

		$data['fonts'] = $this->getFonts();

		$this->load->model('tool/image');

		$data['image_fullpath'] = HTTP_CATALOG . 'image/';
		$data['no_image']       = $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $base_url . 'image/' . $this->config->get('config_icon');
		} else {
			$data['icon'] = '';
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$data['action']      = $this->url->link('extension/bossthemes/customizer', 'user_token=' . $this->session->data['user_token'] . $url, 'SSL');
		$data['reset']       = $this->url->link('extension/bossthemes/customizer/reset', 'user_token=' . $this->session->data['user_token'] . $url, 'SSL');

		$data['backend']  = ($this->request->server['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER;
		$data['frontend'] = $base_url . '?remote_token=' . $this->session->data['user_token'];
		
		$backend = parse_url($data['backend']);
		$this->cache->set('remote.token.' . $this->session->data['user_token'], ['remote_url' => $backend['scheme'] . '://' . $backend['host']]);

		$data['description'] = $this->document->getDescription();
		$data['keywords']    = $this->document->getKeywords();
		$data['styles']      = $this->document->getStyles();
		$data['scripts']     = $this->document->getScripts();

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['data'])) {
			$data['error_data'] = $this->error['data'];
		} else {
			$data['error_data'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		$data['button_back'] = $this->url->link('extension/bossthemes/manager', 'user_token=' . $this->session->data['user_token'], 'SSL');

		$data['user_token'] = $this->session->data['user_token'];
		$data['store_id'] = $store_id;
		
		$this->load->model('tool/image');
		$data['_image'] = $this->model_tool_image;
		
		$this->config->set('template_engine', 'template');
		
		$this->response->setOutput($this->load->view('extension/bossthemes/customizer', $data));
	}

	public function reset() {
		$this->load->model('extension/bossthemes/customizer');
		$this->load->language('extension/bossthemes/customizer');

		if ($this->validateReset()) {
			$this->model_extension_bossthemes_customizer->resetCustomizer((int)$this->request->post['store_id']);
		}

		$json['succes'] = true;

		$this->session->data['success'] = $this->language->get('text_remove');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function installStylesheet() {
		$this->document->addStyle('view/stylesheet/bootstrap.css');
		$this->document->addStyle('view/javascript/font-awesome/css/font-awesome.min.css');
		$this->document->addStyle('view/stylesheet/stylesheet.css');
		$this->document->addStyle('view/javascript/jquery/jquery-ui/jquery-ui.min.css');
		$this->document->addStyle('view/javascript/bossthemes/colorpicker/color-picker.css');
		$this->document->addStyle('view/stylesheet/bossthemes/theme-manager/customizer.css');
	}

	public function installJavascript() {
		$this->document->addScript('view/javascript/jquery/jquery-2.1.1.min.js');
		$this->document->addScript('view/javascript/bootstrap/js/bootstrap.min.js');
		$this->document->addScript('view/javascript/jquery/jquery-ui/jquery-ui.min.js');
		$this->document->addScript('view/javascript/bossthemes/colorpicker/color-picker.js');
		$this->document->addScript('view/javascript/bossthemes/colorpicker/iris.min.js');
	}
	
    public function getFonts() {
        $json =  file_get_contents(DIR_APPLICATION . 'view/font/webfonts.json');
        
        $webfonts = json_decode($json, true);
        
        $fonts['system'] = array(
            array(
                'family'   => 'Arial',
				'category' => 'sans-serif'
            ),
            array(
                'family'   => 'Verdana',
				'category' => 'sans-serif'
            ),
            array(
                'family'   => 'Helvetica',
				'category' => 'sans-serif'
            ),
            array(
                'family'   => 'Tahoma',
				'category' => 'sans-serif'
            ),
            array(
                'family'   => 'Georgia',
				'category' => 'serif'
            ),
            array(
                'family'   => 'Courier',
				'category' => 'serif'
            ),
            array(
                'family'   => 'Comic Sans MS',
				'category' => 'sans-serif'
            ),
            array(
                'family'   => 'Trebuchet MS',
				'category' => 'sans-serif'
            ),
            array(
                'family'   => 'Times New Roman',
				'category' => 'serif'
            ),
            array(
                'family'   => 'Lucida Grande',
				'category' => 'sans-serif'
            )
        );

        foreach ($webfonts as $font_item) {
            $fonts['google'][] = array(
                'family'   => $font_item['family'],
				'category' => $font_item['category'],
            );
        }
        
        return $fonts;
    }

	protected function validate() {
		$this->load->language('extension/bossthemes/customizer');
		
		if (!$this->user->hasPermission('modify', 'extension/bossthemes/customizer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!isset($this->request->post['xml'])) {
			$this->error['data'] = $this->language->get('error_data');
		}
		
		return !$this->error;
	}
	
	protected function validateReset() {
		$this->load->language('extension/bossthemes/customizer');
		
		if (!$this->user->hasPermission('modify', 'extension/bossthemes/customizer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!isset($this->request->post['store_id'])) {
			$this->error['data'] = $this->language->get('error_data');
		}
		
		return !$this->error;
	}
}
