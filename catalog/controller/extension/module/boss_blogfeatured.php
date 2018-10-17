<?php
class ControllerExtensionModuleBossBlogfeatured extends Controller {
	public function index($setting) {
		$this->load->model('bossblog/article');
		if(!$this->model_bossblog_article->checkModule('bossblog')){
			return;
		}

        if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_blog.css')){
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/boss_blog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_blog.css');
		}

		if ($setting['show_slider']) {
			$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.css');

			if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/bossthemes/owl.carousel.css');
			} else {
				$this->document->addStyle('catalog/view/javascript/bossthemes/owl-carousel/owl.theme.default.min.css');
			}

			$this->document->addScript('catalog/view/javascript/bossthemes/owl-carousel/owl.carousel.min.js');
		}

		$_language = new Language($this->config->get('config_language'));
		$_language->load('extension/module/boss_blogfeatured');
		$data = (isset($data)) ? array_merge($data, $_language->all()) : $_language->all();

		static $module = 0;

		$language_id = $this->config->get('config_language_id');

		$data['heading_title'] = (isset($setting['title'][$language_id])) ? $setting['title'][$language_id] : '';

		$this->load->model('tool/image');

		$limit = (!empty($setting['limit'])) ? $setting['limit'] : 8;

		$data['num_row'] = (!empty($setting['num_row'])) ? $setting['num_row'] : 1;
		$data['per_row'] = (!empty($setting['per_row'])) ? $setting['per_row'] : 3;
		$data['show_slider'] = (!empty($setting['show_slider'])) ? $setting['show_slider'] : 0;
		$data['column'] = (!empty($setting['column'])) ? $setting['column'] : 4;
		$data['article_layout'] = (!empty($setting['article_layout'])) ? $setting['article_layout'] : 'article-grid';

		$image_width  = (!empty($setting['image_width'])) ? $setting['image_width'] : 200;
		$image_height = (!empty($setting['image_height'])) ? $setting['image_height'] : 200;
		$limit_article = (!empty($setting['limit_article'])) ? $setting['limit_article'] : 108;
		$limit_des = (!empty($setting['limit_des'])) ? $setting['limit_des'] : 108;

        if (!empty($setting['position']) && $setting['position'] == 'sidebar') {
            $data['sidebar'] = 1;
        } else {
            $data['sidebar'] = 0;
        }

		if ($setting['layout_width'] == 'full-width') {
			$data['full_width'] = 1;
		} else {
			$data['full_width'] = 0;
		}

		$data['articles'] = array();

		$filter_blog = (!empty($setting['filter_blog'])) ? $setting['filter_blog'] : 'latest';

		$results = array();

		switch ($filter_blog) {
			case "popular":
				$results = $this->model_bossblog_article->getArticlesPopular($limit);
				break;

			case "latest":
				$data_sort = array(
					'sort'  => 'p.date_added',
					'order' => 'DESC',
					'start' => 0,
					'limit' => $limit
				);
				$results = $this->model_bossblog_article->getArticles($data_sort);
				break;
			case "category":
				if(!empty($setting['filter_type_category'])){
					$data_sort = array(
						'filter_category_id' => $setting['filter_type_category'],
						'sort'  => 'pd.name',
						'order' => 'ASC',
						'start' => 0,
						'limit' => $limit
					);
					$results = $this->model_bossblog_article->getArticles($data_sort);
				}
				break;
			case "article":
				$articles = $setting['article'];
				foreach ($articles as $k => $article) {
					if ($k == $limit){break;}
					if(isset($article) && $article != ''){
						$results[] = $this->model_bossblog_article->getArticle($article);
					}
				}
				break;
		}

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
			} else {
				$image = false;
			}
			$this->load->model('bossblog/comment');

			$data['articles'][] = array(
				'blog_article_id'  => $result['blog_article_id'],
				'thumb'			   => $image,
				'name'			   => utf8_substr($result['name'], 0, $limit_article),
				'comment'		   => $this->model_bossblog_comment->getTotalCommentsByArticleId($result['blog_article_id']),
				'date_modified'	   => date($_language->get('date_format_short'), strtotime($result['date_modified'])),
				'day'              => date('d', strtotime($result['date_modified'])),
				'month'            => date('M', strtotime($result['date_modified'])),
				'year'             => date('Y', strtotime($result['date_modified'])),
				'title'			   => utf8_substr(strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')), 0, $limit_des) . '..',
				'author'		   => $result['author'],
				'href'			   => $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id'])
			);
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/boss_blogfeatured', $data);
	}
}