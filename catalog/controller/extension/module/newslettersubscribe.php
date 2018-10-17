<?php
class ControllerExtensionModuleNewslettersubscribe extends Controller {
	private $error = array();

	public function index($setting){
		if(empty($setting)) return;

		static $module = 0;

		if  (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_newsletter.css'))  {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_newsletter.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_newsletter.css');
		}

		$language_id = $this->config->get('config_language_id');

		$data['title'] = (isset($setting['newsletter']['title'][$language_id])) ? $setting['newsletter']['title'][$language_id] : '';
		$data['sub_title'] = (isset($setting['newsletter']['sub_title'][$language_id])) ? $setting['newsletter']['sub_title'][$language_id] : '';
		$data['bg_image'] = (!empty($setting['bg_image'])) ? 'image/'.$setting['bg_image'] : '';
		$data['unsubscribe'] = (boolean)$setting['unsubscribe'];
		$data['module_id'] = (isset($setting['module_id'])) ? $setting['module_id'] : '';

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		}else{
			$route = '';
		}

		if ((boolean)$setting['show_popup'] && (!isset($this->request->cookie['b_newsletter_popup']) || $this->request->cookie['b_newsletter_popup'] != 'disable') && ($route == 'common/home' || $route == '')) {
			$data['show_popup'] = true;
		} else {
			$data['show_popup'] = false;
		}

		if ($setting['position'] == 'sidebar') {
			$data['sidebar'] = 1;
		} else {
			$data['sidebar'] = 0;
		}

		$data['popup']['title'] = (isset($setting['popup']['title'][$language_id])) ? $setting['popup']['title'][$language_id] : '';
		$data['popup']['sub_title'] = (isset($setting['popup']['sub_title'][$language_id])) ? $setting['popup']['sub_title'][$language_id] : '';
		$data['popup']['background'] = (!empty($setting['popup']['background'])) ? 'image/' . $setting['popup']['background'] : '';

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/newslettersubscribe');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		$data['module'] = $module++;

		return $this->load->view('extension/module/newslettersubscribe', $data);
	}

	public function subscribe(){
		if(!isset($this->request->post['module_id']) || !$this->request->post['module_id'])
			return;
		$this->load->model('setting/module');

		$setting_info = $this->model_setting_module->getModule($this->request->post['module_id']);

		$json = array();

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/newslettersubscribe');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		$this->load->model('account/newslettersubscribe');

		if (isset($this->request->post['subscribe_email']) && filter_var($this->request->post['subscribe_email'],FILTER_VALIDATE_EMAIL)) {

			if ((boolean)$setting_info['registered'] && $this->model_account_newslettersubscribe->checkRegisteredUser($this->request->post)) {
				$this->model_account_newslettersubscribe->UpdateRegisterUsers($this->request->post,1);
				$json['success'] = $_language->get('success_subscribe');
			} else if (!$this->model_account_newslettersubscribe->checkmailid($this->request->post))  {
				$this->model_account_newslettersubscribe->subscribe($this->request->post);
				$json['success'] = $_language->get('success_subscribe');
			} else {
				$json['error'] = $_language->get('error_alreadyexist');
			}

			if (isset($json['success']) && (boolean)$setting_info['mail_status']) {
				$language_id = (int)$this->config->get('config_language_id');

				$subject = (!empty($setting_info['mail']['subscribe'][$language_id]['subject'])) ? $setting_info['mail']['subscribe'][$language_id]['subject'] : $_language->get('mail_subscribe_subject');

				$message = str_replace(' ', '', strip_tags(html_entity_decode($setting_info['mail']['subscribe'][$language_id]['message'])));
				$message = (!empty($message)) ? html_entity_decode($setting_info['mail']['subscribe'][$language_id]['message']) : $_language->get('mail_subscribe_message');

				$message = preg_replace('/{.*email.*}/i', $this->request->post['subscribe_email'], $message);

				$json['message'] = $message;

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($this->request->post['subscribe_email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject($subject);
				$mail->setHtml($message);
				$mail->send();
			}

		} else {
			$json['error'] = $_language->get('error_invalid');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function unsubscribe(){
		if(!isset($this->request->post['module_id']) || !$this->request->post['module_id'])
			return;

		$this->load->model('setting/module');

		$setting_info = $this->model_setting_module->getModule($this->request->post['module_id']);

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/newslettersubscribe');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		$this->load->model('account/newslettersubscribe');

		$json = array();

		if (isset($this->request->post['subscribe_email']) && filter_var($this->request->post['subscribe_email'],FILTER_VALIDATE_EMAIL)) {
			if ((boolean)$setting_info['registered'] && $this->model_account_newslettersubscribe->checkRegisteredUser($this->request->post)) {
				$this->model_account_newslettersubscribe->UpdateRegisterUsers($this->request->post,0);
				$json['success'] = $_language->get('success_unsubscribe');
			} else if (!$this->model_account_newslettersubscribe->checkmailid($this->request->post))  {
				$json['error'] = $_language->get('error_notexist');

			} else {
				if ((boolean)$setting_info['unsubscribe']) {
					$this->model_account_newslettersubscribe->unsubscribe($this->request->post);
					$json['success'] = $_language->get('success_unsubscribe');
				}
			}

			if (isset($json['success']) && (boolean)$setting_info['mail_status']) {
				$language_id = (int)$this->config->get('config_language_id');

				$subject = (!empty($setting_info['mail']['unsubscribe'][$language_id]['subject'])) ? $setting_info['mail']['unsubscribe'][$language_id]['subject'] : $_language->get('mail_unsubscribe_subject');

				$message = str_replace(' ', '', strip_tags(html_entity_decode($setting_info['mail']['unsubscribe'][$language_id]['message'])));
				$message = (!empty($message)) ? html_entity_decode($setting_info['mail']['unsubscribe'][$language_id]['message']) : $_language->get('mail_unsubscribe_message');

				$message = preg_replace('/{.*email.*}/i', $this->request->post['subscribe_email'], $message);

				$json['message'] = $message;

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($this->request->post['subscribe_email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject($subject);
				$mail->setHtml($message);
				$mail->send();
			}
		} else {
			$json['error'] = $_language->get('error_invalid');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}