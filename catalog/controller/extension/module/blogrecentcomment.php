<?php
class ControllerExtensionModuleBlogRecentComment extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
		$this->load->model('bossblog/article');
		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/blogrecentcomment');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		static $module = 0;

        if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_blog.css')){
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_blog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_blog.css');
		}

		if ($setting['scrolling']) {
			$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.css');

			if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css');
			} else {
				$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.theme.default.min.css');
			}

			$this->document->addScript('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.js');
		}

		$data['config_teamplate'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_directory');
		$data['scrolling'] = $setting['scrolling'];

		$data['heading_title'] = isset($setting['title'][$this->config->get('config_language_id')]) ? $setting['title'][$this->config->get('config_language_id')] : '';

		$results = $this->model_bossblog_article->getRecentCommentArticles($setting['limit']);

		$data['articles'] = array();

		foreach ($results as $result) {
			$article = $this->model_bossblog_article->getArticle($result['blog_article_id']);	

			$data['articles'][] = array(
				'blog_article_id' => $article['blog_article_id'],
				'name'    	 => $result['name'],
                'author'     => $result['author'],
                'comment'    => utf8_substr(strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')), 0, 50) . '...',
                'date_added' => date($_language->get('date_format_short'), strtotime($result['date_added'])),
				'href'    	 => $this->url->link('bossblog/article', 'blog_article_id=' . $article['blog_article_id']),
			);
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/blogrecentcomment', $data);
	}
}
?>