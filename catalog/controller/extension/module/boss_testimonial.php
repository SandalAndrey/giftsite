<?php  
class ControllerExtensionModuleBossTestimonial extends Controller {
	public function index($setting) {
		static $module = 0;
		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/boss_testimonial');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_testimonial.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_testimonial.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_testimonial.css');
		}

		if ($setting['boss_testimonial_module']['auto_scroll']) {
			$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.css');

			if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css');
			} else {
				$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.theme.default.min.css');
			}

			$this->document->addScript('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.js');
		}

		//Phu
		$data['config_teamplate'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_directory');
		$data['config_manager'] = $this->config->get('boss_manager');

		$data['testimonial_title'] = html_entity_decode(isset($setting['boss_testimonial_module']['title'][$this->config->get('config_language_id')])?$setting['boss_testimonial_module']['title'][$this->config->get('config_language_id')]:'', ENT_QUOTES, 'UTF-8');

      	$data['show_name'] = isset($setting['boss_testimonial_module']['show_name'])?$setting['boss_testimonial_module']['show_name']:1;
      	$data['show_subject'] = isset($setting['boss_testimonial_module']['show_subject'])?$setting['boss_testimonial_module']['show_subject']:1;
      	$data['show_message'] = isset($setting['boss_testimonial_module']['show_message'])?$setting['boss_testimonial_module']['show_message']:1;
      	$data['show_city'] = isset($setting['boss_testimonial_module']['show_city'])?$setting['boss_testimonial_module']['show_city']:1;
      	$data['show_rating'] = isset($setting['boss_testimonial_module']['show_rating'])?$setting['boss_testimonial_module']['show_rating']:1;
		$data['show_image'] = isset($setting['boss_testimonial_module']['show_image'])?$setting['boss_testimonial_module']['show_image']:1;
		$data['show_date'] = isset($setting['boss_testimonial_module']['show_date'])?$setting['boss_testimonial_module']['show_date']:1;
      	$data['show_all_link'] = isset($setting['boss_testimonial_module']['show_all'])?$setting['boss_testimonial_module']['show_all']:1;
      	$data['show_write'] = isset($setting['boss_testimonial_module']['show_write'])?$setting['boss_testimonial_module']['show_write']:1;
      	$data['auto_scroll'] = isset($setting['boss_testimonial_module']['auto_scroll'])?$setting['boss_testimonial_module']['auto_scroll']:1;

      	$data['per_row'] = isset($setting['boss_testimonial_module']['per_row'])?$setting['boss_testimonial_module']['per_row']:1;
      	$data['row'] = isset($setting['boss_testimonial_module']['row'])?$setting['boss_testimonial_module']['row']:1;

		$data['showall_url'] = $this->url->link('bossthemes/boss_testimonial', '', 'SSL'); 
		$data['more'] = $this->url->link('bossthemes/boss_testimonial', 'testimonial_id=' , 'SSL'); 
		$data['isitesti'] = $this->url->link('bossthemes/isitestimonial', '', 'SSL');

		$this->load->model('bossthemes/boss_testimonial');

		$data['testimonials'] = array();

		$data['total'] = $this->model_bossthemes_boss_testimonial->getTotalTestimonials();
		$results = $this->model_bossthemes_boss_testimonial->getTestimonials(0, $setting['boss_testimonial_module']['limit'], (isset($setting['boss_testimonial_module']['random']))?true:false);

		foreach ($results as $result) {
			$result['description'] = trim($result['description']);
			//$result['description'] = str_replace('«<p>', '«', $result['description']);
			//$result['description'] = str_replace('</p>»', '»', $result['description']);

			$this->load->model('tool/image');

			if ($result['avatar']) {
				$avatar = $this->model_tool_image->resize($result['avatar'], isset($setting['boss_testimonial_module']['width'])?$setting['boss_testimonial_module']['width']:100, isset($setting['boss_testimonial_module']['height'])?$setting['boss_testimonial_module']['height']:100);
			} else {
				$avatar = $this->model_tool_image->resize('no_image.png', isset($setting['boss_testimonial_module']['width'])?$setting['boss_testimonial_module']['width']:100, isset($setting['boss_testimonial_module']['height'])?$setting['boss_testimonial_module']['height']:100);
			}

			if (!isset($setting['boss_testimonial_module']['limit']))
				$setting['boss_testimonial_module']['limit'] = 0;

			if ($setting['boss_testimonial_module']['limit']>0){
				$lim = $setting['boss_testimonial_module']['limit_character'];
				$url = $this->url->link('bossthemes/boss_testimonial', 'testimonial_id=' . $result['testimonial_id'] , 'SSL'); 
				if (mb_strlen($result['description'], 'UTF-8')>$lim)
					$result['description'] = mb_substr(strip_tags($result['description']), 0, $setting['boss_testimonial_module']['limit'], 'UTF-8'). ' ' .'<a href="' . $url .'" title="'.$data['text_more2'].'">'. $data['text_more'] . '</a>';
			}

			$data['testimonials'][] = array(
				'id'			=> $result['testimonial_id'],
				'title'		    => $result['title'],
				'description'	=> $result['description'],
				'rating'		=> $result['rating'],
				'name'		    => $result['name'],
				'avatar'		=> $avatar,
				'city'		    => $result['city'],
				'date_added'	=> date($_language->get('date_format_short'), strtotime($result['date_added'])),

			);

			//var_dump($data['testimonials']);exit();
		}

		$this->id = 'testimonial';
		$data['module'] = $module++;

		return $this->load->view('extension/module/boss_testimonial', $data);
	}
}
?>