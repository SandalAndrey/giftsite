<?php
class BossthemesTwig extends Twig_Extension {
	public function getName() {
		return 'bt';	
	}
	
	public function getFunctions() {
		return array(
			// Numeric
			new \Twig_SimpleFunction('round', [$this, '_Round']),
			new \Twig_SimpleFunction('ceil', [$this, '_Ceil']),
			new \Twig_SimpleFunction('floor', [$this, '_Floor']),
			new \Twig_SimpleFunction('filter_float', [$this, '_filterFloat']),
			
			// String
			new \Twig_SimpleFunction('urlencode', [$this, '_urlEncode']),
			new \Twig_SimpleFunction('str_replace', [$this, '_strReplace']),
			new \Twig_SimpleFunction('addslashes', [$this, '_addSlashes']),
			new \Twig_SimpleFunction('strtolower', [$this, '_strToLower']),
			new \Twig_SimpleFunction('strtoupper', [$this, '_strToUpper']),
			new \Twig_SimpleFunction('strlen', [$this, '_strLen']),
			new \Twig_SimpleFunction('strpos', [$this, '_strPos']),
			new \Twig_SimpleFunction('substr', [$this, '_subStr']),
			new \Twig_SimpleFunction('sprintf', [$this, '_Sprintf']),
			
			// Array
			new \Twig_SimpleFunction('print_r', [$this, '_printR']),
			new \Twig_SimpleFunction('is_array', [$this, '_isArray']),
			new \Twig_SimpleFunction('in_array', [$this, '_inArray']),
			new \Twig_SimpleFunction('count', [$this, '_Count']),
			new \Twig_SimpleFunction('serialize', [$this, '_Serialize']),
			new \Twig_SimpleFunction('unserialize', [$this, '_unSerialize']),
			new \Twig_SimpleFunction('current', [$this, '_Current']),
			new \Twig_SimpleFunction('end', [$this, '_End']),
			new \Twig_SimpleFunction('explode', [$this, '_Explode']),
			new \Twig_SimpleFunction('implode', [$this, '_Implode']),
			new \Twig_SimpleFunction('array_chunk', [$this, '_arrayChunk']),
			new \Twig_SimpleFunction('array_split', [$this, '_arraySplit']),
			
			// HTML
			new \Twig_SimpleFunction('strip_tags', [$this, '_stripTags']),
			new \Twig_SimpleFunction('html_entity_decode', [$this, '_htmlEntityDecode']),
			
			// JSON
			new \Twig_SimpleFunction('json_encode', [$this, '_jsonEncode']),
			new \Twig_SimpleFunction('json_decode', [$this, '_jsonDecode']),
			
			// File
			new \Twig_SimpleFunction('filesize', [$this, '_fileZize']),
			new \Twig_SimpleFunction('include_once', [$this, '_includeOnce']),
			new \Twig_SimpleFunction('require', [$this, '_Require']),
			new \Twig_SimpleFunction('require_once', [$this, '_requireOnce']),
			new \Twig_SimpleFunction('simplexml_load_file', [$this, '_simpleXmlLoadFile']),
			new \Twig_SimpleFunction('file_get_contents', [$this, '_fileGetContents']),
			new \Twig_SimpleFunction('is_file', [$this, '_isFile']),
			new \Twig_SimpleFunction('file_exists', [$this, '_fileExists']),
			new \Twig_SimpleFunction('dirname', [$this, '_dirName']),
			
			// Orther
			new \Twig_SimpleFunction('version_compare', [$this, '_versionCompare']),
		);
		
	}
	
	// Numeric
	public function _Round($number = 0, $precision = 0, $mode = PHP_ROUND_HALF_UP) {
		return round($number, $precision, $mode);
	}
	
	public function _Ceil($value = 0) {
		return ceil($value);	
	}
	
	public function _Floor($value = 0) {
		return floor($value);
	}
	
	public function _filterFloat($string = '') {
		return (float)filter_var($string, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	}
	
	// String
	public function _urlEncode($string = '') {
		return urlencode($string);
	}
	
	public function _strReplace($search = NULL , $replace = NULL, $subject = NULL, &$count = NULL) {
		return str_replace($search, $replace, $subject, $count);
	}
	
	public function _addSlashes($string = '') {
		return addslashes($string);
	}
	
	public function _strToLower($string = '') {
		if (extension_loaded('mbstring')) {
			mb_internal_encoding('UTF-8');
			return mb_strtolower($string);
		} else {
			return strtolower($string);
		}
	}
	
	public function _strToUpper($string = '') {
		if (extension_loaded('mbstring')) {
			mb_internal_encoding('UTF-8');
			mb_strtoupper($string);
		} else {
			return strtoupper($string);
		}
	}
	
	public function _strLen($string = '') {
		if (extension_loaded('mbstring')) {
			mb_internal_encoding('UTF-8');
			return mb_strlen($string);
		} else {
			return strlen($string);
		}
	}
	
	public function _strPos($haystack = '', $needle = '', $offset = 0) {
		if (extension_loaded('mbstring')) {
			mb_internal_encoding('UTF-8');
			return mb_strpos($haystack, $needle, $offset);
		} else {
			return strpos($haystack, $needle, $offset);
		}
	}
	
	public function _subStr($string = '', $start = '', $length = NULL) {
		if (extension_loaded('mbstring')) {
			mb_internal_encoding('UTF-8');
			return ($length === NULL) ? mb_substr($string, $start, $this->_strLen($string)) : mb_substr($string, $start, $length);
		} else {
			return ($length === NULL) ? substr($string, $start, $this->_strLen($string)) : substr($string, $start, $length);
		}
	}
	
	public function _Sprintf() {
		return call_user_func_array('sprintf', func_get_args());
	}
	
	// Array
	public function _printR($expression = NULL, $return = false) {
		return print_r($expression, $return);
	}
	
	public function _isArray($array = array()) {
		 return is_array($array);	
	}
	
	public function _inArray($string = '', $array = array()) {
		return in_array($string, $array);
	}
	
	public function _Count($array = array()) {
		return count($array);
	}
	
	public function _jsonEncode($value = '', $options = 0, $depth = 512) {
		return json_encode($value, $options, $depth);
	}
	
	public function _jsonDecode($json = '', $assoc = false, $depth = 512, $options = 0) {
		return json_decode($json, $assoc, $depth, $options);
	}
	
	public function _Serialize($value = NULL) {
		return serialize($value);
	}
	
	public function _unSerialize($string = '', $options = array()) {
		return ($options) ? unserialize($string, $options) : unserialize($string);
	}
	
	public function _Current(&$array = array()) {
		return current($array);
	}
	
	public function _End(&$array = array()) {
		return end($array);
	}
	
	public function _Explode($delimiter = '', $string = '', $limit  = PHP_INT_MAX) {
		return explode($delimiter, $string, $limit);
	}
	
	public function _Implode($glue = '', $pieces = array()) {
		return implode($glue, $pieces);
	}
	
	public function _arrayChunk($array = array(), $size = 0, $preserve_keys = false) {
		return array_chunk($array, $size, $preserve_keys);
	}
	
	public function _arraySplit($array = array(), $row = 0, $column = 0) {
		$array_data = array();
		
		foreach (array_chunk($array, ($row * $column)) as $arrays) {
			$buffers = array();
			
			foreach (array_chunk($arrays, $column) as $array_rows) {
				foreach ($array_rows as $index => $array_row) {
					$buffers[$index][] = $array_row;
				}
			}
			
			foreach ($buffers as $buffer) {
				$array_data[] = $buffer;
			}
		}
		
		return $array_data;
	}
	
	// HTML
	public function _stripTags($string = '', $allowable_tags = NULL) {
		return strip_tags($string, $allowable_tags);
	}
	
	public function _htmlEntityDecode($string = '') {
		return html_entity_decode($string);
	}
	
	// File
	public function _fileZize($string = '') {
		return filesize($string);
	}
	
	public function _includeOnce($string = '') {
		return include_once($string);
	}
	
	public function _Require($string = '') {
		return require($string);
	}
	
	public function _requireOnce($string = '') {
		return require_once($string);
	}
	
	public function _simpleXmlLoadFile($filename = '', $class_name = 'SimpleXMLElement', $options = 0, $ns = '', $is_prefix = false) {
		return simplexml_load_file($filename, $class_name, $options, $ns, $is_prefix);
	}
	
	public function _fileGetContents($filename = '', $use_include_path = false, $context = NULL, $offset = 0, $maxlen = NULL) {
		return file_get_contents($filename, $use_include_path, $context, $offset, $maxlen);
	}
	
	public function _isFile($filename = '') {
		return is_file($filename);
	}
	
	public function _fileExists($filename = '') {
		return file_exists($filename);
	}
	
	public function _dirName($path = '') {
		return dirname($path);
	}
	
	// Orther
	public function _versionCompare($version1 = '', $version2 = '', $operator = '') {
		return ($operator) ? version_compare($version1, $version2, $operator) : version_compare($version1, $version2);
	}
}