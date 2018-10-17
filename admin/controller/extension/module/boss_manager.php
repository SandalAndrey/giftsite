<?php
class ControllerExtensionModuleBossManager extends Controller {
	private $error = array();

	public function index() {
		if (!$this->user->hasPermission('access', 'extension/bossthemes')) $this->load->controller('extension/bossthemes/xml/refresh', array('silent' => true));
		$this->response->redirect($this->url->link('extension/bossthemes/manager', 'user_token=' . $this->session->data['user_token'], true));
	}
	
	public function install() {
		$this->load->model('setting/setting');
		$this->load->model('user/user_group');
		
		if (file_exists(DIR_SYSTEM . 'bossthemes/sample_data/default/setting_boss_manager.dat')) {
			$datas = json_decode(file_get_contents(DIR_SYSTEM . 'bossthemes/sample_data/default/setting_boss_manager.dat'), true);
			
			foreach ($datas as $data) {
				$this->model_setting_setting->editSetting($data['code'], $data['setting']);
			}
		}
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/manager');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/manager');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/header');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/header');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/footer');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/footer');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/social');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/social');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/payment');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/payment');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/custom');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/custom');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/customizer');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/customizer');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/sample_data');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/sample_data');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/xml');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/xml');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/bossthemes/module');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/bossthemes/module');
	}
}