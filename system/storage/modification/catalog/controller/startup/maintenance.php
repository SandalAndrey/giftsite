<?php
class ControllerStartupMaintenance extends Controller {
	public function index() {

			if (isset($this->request->get['remote_token'])) {
				$data = $this->cache->get('remote.token.' . $this->request->get['remote_token']);
				if (isset($data['remote_url'])) $this->response->addHeader('Access-Control-Allow-Origin: ' . $data['remote_url']);
			}
			
		if ($this->config->get('config_maintenance')) {
			// Route
			if (isset($this->request->get['route']) && $this->request->get['route'] != 'startup/router') {
				$route = $this->request->get['route'];
			} else {
				$route = $this->config->get('action_default');
			}			
			
			$ignore = array(
				'common/language/language',
				'common/currency/currency'
			);
			
			// Show site if logged in as admin
			$this->user = new Cart\User($this->registry);

			if ((substr($route, 0, 17) != 'extension/payment' && substr($route, 0, 3) != 'api') && !in_array($route, $ignore) && !$this->user->isLogged()) {
				return new Action('common/maintenance');
			}
		}
	}
}
