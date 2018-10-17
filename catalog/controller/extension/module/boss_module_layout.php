<?php
class ControllerExtensionModuleBossModuleLayout extends Controller {
	private $extensions;

	public function index($setting) {
		$content = html_entity_decode($setting['publish']);

		$this->load->model('extension/module/boss_module_layout');
		$this->load->model('setting/module');

		// Get a list of installed modules
		$this->extensions = $this->model_extension_module_boss_module_layout->getInstalled('module');

		$pattern = $this->getRegex();

		while ($this->hasShortCode($content)) {
			$content = preg_replace_callback($pattern, 'ControllerExtensionModuleBossModuleLayout::doShortCode', $content);
		}

		return $content;
	}

	private function doShortCode($matches) {
		$output = '';

		if ($matches[3]) {
			$setting_info = $this->model_setting_module->getModule($matches[3]);

			if ($setting_info && $setting_info['status']) {
				$output .= $this->load->controller('extension/module/' . $matches[1], $setting_info);
			}
		} else if ($this->config->get('module_' . $matches[1] . '_status')) {
			$output .= $this->load->controller('extension/module/' . $matches[1]);
		}

		return $output;
	}

	private function hasShortCode($content = '') {
		$pattern = $this->getRegex();

		preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

		if (empty($matches)) {
			return false;
		}

		foreach ($matches as $extension) {
			if (in_array($extension[1], $this->extensions)) {
				return true;
			}
		}

		return false;
	}

	private function getRegex() {
		$tagregexp = join('|', array_map('preg_quote', $this->extensions));

		$regex = '/\[(' . $tagregexp . ')(\.*)(\d*) .*\]/U';

		return $regex;
	}
}