<?php

class ModelExtensionBossthemesCustomizer extends Model {
	public function saveCustomizer($groups = array(), $store_id = 0) {
		$this->load->model('setting/setting');
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `store_id` = '" . (int)$store_id . "' AND `code` = 'config' AND `key` = 'config_theme'");
		
		if (isset($query->row['value'])) {
			$buffers = array();
			$fonts = array();
			$release = (int)$this->config->get('customizer_release');
			
			$this->model_setting_setting->editSetting('customizer', ['customizer_release' => ($release+1)], $store_id);
			
			$this->saveXML($groups, dirname(DIR_APPLICATION) . '/config_xml/theme_setting_' . (int)$store_id . '.xml');
			
			foreach ($this->getCustomizerItem($store_id) as $index => $group) {
				foreach ($group->item as $item) {
					if (!empty($item->property) && !empty($item->value)) {
						if ($item->property == 'src') {
							if ($item->keyword == 'logo') {
								$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = '" . $this->db->escape($item->value) . "' WHERE `store_id` = '" . (int)$store_id . "' AND `code` = 'config' AND `key` = 'config_logo'");
							}
						} else {
							$index = array_search($item->selector, array_column($buffers, 'selector'));
							
							if ($index !== false) {
								$buffers[$index]['rules'][] = $this->cssBuilder($item->type, $item->property, $item->value);
							} else {
								$buffers[] = array (
									'selector' => (string)$item->selector,
									'rules' => array (
										0 => $this->cssBuilder($item->type, $item->property, $item->value)
									)
								);
							}
							
							if ($item->property == 'font-family') {
								$fonts[(string)$item->value] = (string)$item->value;
							}
						}
					}
				}
			}
			
			$customizerCss = '';
			
			$system_fonts = array (
				'Arial',
				'Verdana',
				'Helvetica',
				'Tahoma',
				'Georgia',
				'Courier',
				'Comic Sans MS',
				'Trebuchet MS',
				'Times New Roman',
				'Lucida Grande'
			);
			
			foreach ($fonts as $font) {
				if (!in_array($font, $system_fonts)) {
					$customizerCss .= "@import url('//fonts.googleapis.com/css?family=" . urlencode($font) . ":100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese');";
				}
			}
			
			foreach ($buffers as $buffer) {
				$customizerCss .= $buffer['selector'] . '{';
				
				foreach ($buffer['rules'] as $rule) {
					$customizerCss .= $rule;
				}
				
				$customizerCss .= '}';
			}
			
			$this->dumpFile(DIR_CATALOG . 'view/theme/' . $this->config->get('theme_' . $query->row['value'] . '_directory') . '/stylesheet/customizer.css', $customizerCss);
		}
	}
	
	private function cssBuilder($type = '', $property = '', $value = '') {
		switch ($type) {
			case 'image': 
				return $property . ':' . "url('../../../../../image/" . $value . "');";
				break;
			default:
				switch ($property) {
					case 'font-family':
						return $property . ':"' . $value . '", sans-serif;';
						break;
					default:
						return $property . ':' . $value . ';';
						break;
				}
				
				break;
		}
	}

	public function resetCustomizer($store_id = 0) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `store_id` = '" . (int)$store_id . "' AND `code` = 'customizer'");
		
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `store_id` = '" . (int)$store_id . "' AND `code` = 'config' AND `key` = 'config_theme'");
		
		if (isset($query->row['value'])) {
			$this->remove(dirname(DIR_APPLICATION) . '/config_xml/theme_setting_' . (int)$store_id . '.xml');
			$this->dumpFile(DIR_CATALOG . 'view/theme/' . $this->config->get('theme_' . $query->row['value'] . '_directory') . '/stylesheet/customizer.css', '');
		}
	}

	public function getCustomizerItem($store_id = 0) {
		$storage = dirname(DIR_APPLICATION) . '/config_xml/theme_setting_' . (int)$store_id . '.xml';
		$default = dirname(DIR_APPLICATION) . '/config_xml/theme_setting_default.xml';
		
		
		if (!file_exists($default) || filesize($default) == 0) {
			$this->saveXML([], $default);
		}
		
		if (!file_exists($storage) || filesize($storage) == 0) {
			$storage = $default;
		}
		
		$objXML = simplexml_load_file($storage);
		
		return $objXML->groups;
	}
	
	public function saveXML($groups, $storage) {
		$xml = new DOMDocument('1.0','UTF-8');

		//create item_setting
		$root = $xml->createElement('items_setting');
		$xml->appendChild($root);
		if(!empty($groups)){
			foreach($groups as $group) {
				//create groups
				$groups_xml = $xml->createElement('groups');
				$root->appendChild($groups_xml);

				//create title
				$title = $xml->createElement('title');
				$groups_xml->appendChild($title);
				//add value
				if (isset($group['title'])) {
					$title->appendChild($xml->createTextNode(html_entity_decode($group['title'])));
				}
				if(isset($group['text'])){
					for($i=0; $i< count($group['text']) ; $i++){
						//create item
						$item = $xml->createElement('item');
						$groups_xml->appendChild($item);

						//create text
						$text = $xml->createElement('text');
						$item->appendChild($text);
						//add value
						$text->appendChild($xml->createTextNode(html_entity_decode($group['text'][$i])));

						//create selector
						$name = $xml->createElement('selector');
						$item->appendChild($name);
						//add value
						$name->appendChild($xml->createTextNode(html_entity_decode($group['selector'][$i])));

						//create property
						$class = $xml->createElement('property');
						$item->appendChild($class);
						//add value
						$class->appendChild($xml->createTextNode(html_entity_decode($group['property'][$i])));

						//create value
						$value = $xml->createElement('value');
						$item->appendChild($value);
						//add value
						$value->appendChild($xml->createTextNode(html_entity_decode($group['value'][$i])));

						//create type
						$style = $xml->createElement('type');
						$item->appendChild($style);
						//add value
						$style->appendChild($xml->createTextNode(html_entity_decode($group['type'][$i])));
						
						//create keyword
						$style = $xml->createElement('keyword');
						$item->appendChild($style);
						//add value
						$style->appendChild($xml->createTextNode(html_entity_decode($group['keyword'][$i])));
						
						//create ref
						$style = $xml->createElement('ref');
						$item->appendChild($style);
						//add value
						$style->appendChild($xml->createTextNode(html_entity_decode($group['ref'][$i])));
					}
				}
			}
		}
		
		//nice output
		$path = '';
		
		$directories = explode('/', dirname($storage));

		foreach ($directories as $index => $directory) {
			$path = ($index == 0) ? $directory :  $path . '/' . $directory;

			if (!is_dir($path)) {
				@mkdir($path, 0777);
			}
		}
		
		$xml->formatOutput = true;
		$xml->save($storage);
	}
	
	public function dumpFile($filename, $content) {
		$path = '';

		$directories = explode('/', dirname($filename));

		foreach ($directories as $index => $directory) {
			$path = ($index == 0) ? $directory :  $path . '/' . $directory;

			if (!is_dir($path)) {
				@mkdir($path, 0777);
			}
		}
		
		file_put_contents($filename, $content);
	}
	
	public function remove($files) {
		if (is_array($files)) {
			foreach ($files as $file) {
				if (file_exists($files) && is_file($files)) {
					unlink($files);
				}
			}
		} else {
			if (file_exists($files) && is_file($files)) {
				unlink($files);
			}
		}
	}
}
