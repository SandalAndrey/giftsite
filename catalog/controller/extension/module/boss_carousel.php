<?php  
class ControllerExtensionModuleBossCarousel extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
		static $module = 0;

		$language_id = $this->config->get('config_language_id');

		$data['heading_title'] = (!empty($setting['title'][$language_id])) ? $setting['title'][$language_id]:'';

		if(isset($setting['banner_id'])){

			$this->load->model('design/banner');
			$this->load->model('tool/image');

			if (in_array($setting['style'], array('flip', 'vertical'))) {
				$this->document->addScript('catalog/view/javascript/bossthemes/slick/slick.min.js');
				$this->document->addStyle('catalog/view/javascript/bossthemes/slick/slick.css');
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/slick-theme.css');

				$data['js'] = 'slick';
			} else {
				$this->document->addScript('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.js');
				$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.css');

				if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css')) {
					$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css');
				} else {
					$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.theme.default.min.css');
				}

				$data['js'] = 'owl';
			}

			if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_carousel.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_carousel.css');
			} else {
				$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_carousel.css');
			}

			$data['limit'] = isset($setting['limit']) ? $setting['limit'] : 6;

			$data['banners'] = array();

			$results = $this->model_design_banner->getBanner($setting['banner_id']);

			foreach ($results as $result) {
				if (file_exists(DIR_IMAGE . $result['image'])) {
					$data['banners'][] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], isset($setting['image_width']) ? $setting['image_width'] : 80, isset($setting['image_height']) ? $setting['image_height'] : 80)
					);
				}
			}

			$data['img_row'] = $setting['img_row'];
			$data['num_row'] = $setting['num_row'];
			$data['center'] = $setting['center'];
			$data['auto'] = $setting['auto'];
			$data['time'] = $setting['time'];
			$data['navigation'] = $setting['navigation'];
			$data['pagination'] = $setting['pagination'];
			$data['opacity'] = $setting['opacity'];

			$data['style'] = $setting['style'];

			if ($data['style'] == 'flip') {
				$data['center'] = 1;
			} else {
				$data['center'] = 0;
			}

			if ($data['style'] == 'vertical') {
				$data['vertical'] = 1;
			} else {
				$data['vertical'] = 0;
			}

			if ($setting['layout_width'] == 'full-width') {
				$data['full_width'] = 1;
			} else {
				$data['full_width'] = 0;
			}

			$data['module'] = $module++;

			return $this->load->view('extension/module/boss_carousel', $data);
		}
	}
}
