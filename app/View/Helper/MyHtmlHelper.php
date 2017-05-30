<?php

App::uses('HtmlHelper', 'View/Helper');

class MyHtmlHelper extends HtmlHelper{


public function script($url, $options = array()) {
		if (is_bool($options)) {
			list($inline, $options) = array($options, array());
			$options['inline'] = $inline;
		}
		$options = array_merge(array('block' => null, 'inline' => true, 'once' => true), $options);
		if (!$options['inline'] && empty($options['block'])) {
			$options['block'] = __FUNCTION__;
		}
		unset($options['inline']);

		if (is_array($url)) {
			$out = '';
			foreach ($url as $i) {
				$out .= "\n\t" . $this->script($i, $options);
			}
			if (empty($options['block'])) {
				return $out . "\n";
			}
			return null;
		}
		if ($options['once'] && isset($this->_includedScripts[$url])) {
			return null;
		}
		$this->_includedScripts[$url] = true;

		if (strpos($url, '//') === false) {
			if( defined('STATIC_CONTENT') ){
				$url = STATIC_CONTENT.'/js/'.$url.'.js';
			}else{
				$url = $this->assetUrl($url, $options + array('pathPrefix' => JS_URL, 'ext' => '.js'));

				if (Configure::read('Asset.filter.js')) {
					$url = str_replace(JS_URL, 'cjs/', $url);
				}
			}
		}

		$attributes = $this->_parseAttributes($options, array('block', 'once'), ' ');
		$out = sprintf($this->_tags['javascriptlink'], $url, $attributes);

		if (empty($options['block'])) {
			return $out;
		} else {
			$this->_View->append($options['block'], $out);
		}
	}


	public function css($path, $rel = null, $options = array()) {
		$options += array('block' => null, 'inline' => true);
		if (!$options['inline'] && empty($options['block'])) {
			$options['block'] = __FUNCTION__;
		}
		unset($options['inline']);

		if (is_array($path)) {
			$out = '';
			foreach ($path as $i) {
				$out .= "\n\t" . $this->css($i, $rel, $options);
			}
			if (empty($options['block'])) {
				return $out . "\n";
			}
			return;
		}

		if (strpos($path, '//') !== false) {
			$url = $path;
		} else {
			if( defined('STATIC_CONTENT') ){
				$url = STATIC_CONTENT.'/css/'.$path.'.css';
			}else{
				$url = $this->assetUrl($path, $options + array('pathPrefix' => CSS_URL, 'ext' => '.css'));

				if (Configure::read('Asset.filter.css')) {
					$pos = strpos($url, CSS_URL);
					if ($pos !== false) {
						$url = substr($url, 0, $pos) . 'ccss/' . substr($url, $pos + strlen(CSS_URL));
					}
				}
			}
		}

		if ($rel == 'import') {
			$out = sprintf($this->_tags['style'], $this->_parseAttributes($options, array('inline', 'block'), '', ' '), '@import url(' . $url . ');');
		} else {
			if (!$rel) {
				$rel = 'stylesheet';
			}
			$out = sprintf($this->_tags['css'], $rel, $url, $this->_parseAttributes($options, array('inline', 'block'), '', ' '));
		}

		if (empty($options['block'])) {
			return $out;
		} else {
			$this->_View->append($options['block'], $out);
		}
	}


}