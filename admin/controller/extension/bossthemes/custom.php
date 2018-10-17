<?php
class ControllerExtensionBossthemesCustom extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('extension/bossthemes/custom');
		$this->load->model('setting/setting');
		
		$data = (isset($data)) ? array_merge($data, $this->language->all()) : $this->language->all();
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->htmlDecode();
			
			$this->model_setting_setting->editSetting('boss_custom', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/bossthemes/custom', 'user_token=' . $this->session->data['user_token'], 'SSL'));
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=bossthemes', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/bossthemes/custom', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['action'] = $this->url->link('extension/bossthemes/custom', 'user_token=' . $this->session->data['user_token'], 'SSL');
		
		if (isset($this->request->post['boss_custom'])) {
			$data['boss_custom'] = $this->request->post['boss_custom'];
		} else {
			$data['boss_custom'] = $this->config->get('boss_custom');
		}
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->config->set('template_engine', 'template');
		$data['topbar'] = $this->load->controller('extension/bossthemes/topbar');
		$data['sidebar'] = $this->load->controller('extension/bossthemes/sidebar');
		
		$this->config->set('template_engine', 'twig');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->config->set('template_engine', 'template');

		$this->response->setOutput($this->load->view('extension/bossthemes/custom', $data));
	}
	
	public function htmlDecode() {
		if (isset($this->request->post['boss_custom']['css'])) {
			$this->request->post['boss_custom']['css'] = html_entity_decode($this->request->post['boss_custom']['css']);
		}
		
		if (isset($this->request->post['boss_custom']['javascript'])) {
			$this->request->post['boss_custom']['javascript'] = html_entity_decode($this->request->post['boss_custom']['javascript']);
		}
		
		if (isset($this->request->post['boss_custom']['welcome']['content'])) {
			foreach ($this->request->post['boss_custom']['welcome']['content'] as $language_id => $value) {
				$this->request->post['boss_custom']['welcome']['content'][$language_id] = html_entity_decode($value);
			}
		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/bossthemes/custom')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
