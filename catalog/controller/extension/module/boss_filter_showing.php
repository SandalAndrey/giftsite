<?php
class ControllerExtensionModuleBossFilterShowing extends Controller {
	public function index($setting) {
		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_filter_showing.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_filter_showing.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_filter_showing.css');
		}

		$language_id = (int)$this->config->get('config_language_id');

		$data['heading_title'] = (isset($setting['title'][$language_id])) ? $setting['title'][$language_id] : '';

		if (isset($setting['description'][$language_id]) && !empty(strip_tags(html_entity_decode($setting['description'][$language_id])))) {
			$data['description'] = html_entity_decode($setting['description'][$language_id]);
		} else {
			$data['description'] = '';
		}

		$data['column'] = (int)$setting['column'];

		$data['filters'] = array();

		if (!empty($setting['filter'])) {
			$this->load->model('bossthemes/filter');

			usort($setting['filter'], function($i1, $i2) {
				return $i1['sort_order'] - $i2['sort_order'];
			});

			foreach ($setting['filter'] as $filter) {
				$filter_info = $this->model_bossthemes_filter->getFilter($filter['filter_id']);

				if ($filter_info) {
					$data['filters'][] = array(
						'filter_id' => $filter_info['filter_id'],
						'name'      => $filter_info['name'],
						'title'     => (isset($filter['filter_description'][$language_id]['name'])) ? $filter['filter_description'][$language_id]['name'] : '',
						'image'     => ($filter['image']) ? 'image/' . $filter['image'] : '',
						'href'      => $this->url->link('bossthemes/filter', 'filter=' . $filter_info['filter_id'])
					);
				}
			}
		}

		return $this->load->view('extension/module/boss_filter_showing', $data);
	}
}