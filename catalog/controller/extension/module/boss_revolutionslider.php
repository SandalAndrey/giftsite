<?php
class ControllerExtensionModuleBossRevolutionSlider extends Controller {
	public function index($setting) {
		static $module = 0;
		//$_language = new Language($this->config->get('config_language'));
		//$_language->load('module/boss_revolutionslider');
		//$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();
		//

		$this->load->model('bossthemes/boss_revolutionslider');
		$this->document->addScript('catalog/view/javascript/bossthemes/plugins.js');
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_revolutionslider/css/settings.css');
		$this->document->addScript('catalog/view/javascript/bossthemes/jquery.tools.min.js');
		$this->document->addScript('catalog/view/javascript/bossthemes/jquery.revolution.min.js');

		$slides = array();

		$slides = $this->model_bossthemes_boss_revolutionslider->getSlides($setting['slider_id']);

		$slider = array();

		$slider = $this->model_bossthemes_boss_revolutionslider->getSlider($setting['slider_id']);

		if(!empty($slider )){
			$data['slidersetting'] = json_decode($slider['setting'], true);
		}else{
			$data['slidersetting'] = array();
		}

		if(!empty($slides)){
			foreach($slides as $slide){
				$data['slides'][] = array(
					'slide_id' => $slide['id'],
					'slider_id' => $slide['slider_id'],
					'status'	=> $slide['status'],
					'sort_order' => $slide['sort_order'],
					'slideset' => json_decode($slide['slideset'], true),
					'captions' => json_decode($slide['caption'], true)
				);
			}
		}
		$data['config_teamplate'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_directory');
		$data['config_language'] = $this->config->get('config_language_id');
		//var_dump($data['config_language']);exit();
		//$data['slideset'] => json_decode($slide['slideset'], true),
		//echo '<pre>';print_r($data['slidersetting']);echo '</pre>';
		$data['module'] = $module++;

		return $this->load->view('extension/module/boss_revolutionslider', $data);
	}
}
?>