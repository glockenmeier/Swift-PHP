<?php
/**
 * SwiftHtml.php
 *
 * This file contains the SwiftHtml class.
 *
 * @author Derek Skeba
 * @copyright 2010 - 2013 Media Vim LLC
 * @link http://swiftphp.org
 * @license http://swiftphp.org/license
 * @version 1.3.5
 * @package Swift
 *
 * MIT LICENSE
 *
 * Copyright (c) 2010 - 2013 Media Vim LLC (http://mediavim.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining 
 * a copy of this software and associated documentation files (the "Software"), 
 * to deal in the Software without restriction, including without limitation 
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the 
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS 
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE 
 * SOFTWARE.
 */

/**
 * Utility for creating and outputing HTML tags.
 * @package Swift
 */
class SwiftHtml {
	
	/**
	 * Creates a new SwiftHtml object.
	 * @return SwiftHtml The new SwiftHtml object.
	 */
	public function __construct() {}
	
	/**
	 * Returns a string containing a snippet of HTML/JS code that can be inserted on any web page
	 * to ensure HTML5 compatability for MSIE.
	 * @return string A string of HTML/JS code.
	 */
	public function getHTML5JavaScriptForIE() {
		$s = Swift::getInstance();
		return "<!-- Internet Explorer HTML5 enabling script: -->
		<!--[if IE]>
			<script src=\"". $s->config('app_url') . "/Swift/includes/js/html5shiv/html5shiv.js\"></script>
			<style type=\"text/css\">
				.clear {
					zoom: 1;
					display: block;
				}
			</style>
		<![endif]-->\n";
	}
	
	/**
	 * Returns a HTML script tag which includes the jquery.js engine into the web page.
	 * to ensure HTML5 compatability for MSIE.
	 * @return string An HTML script tag.
	 */
	public function getJQuery() {
		$s = Swift::getInstance();
		return $this->createJavaScriptTag($s->config('app_url') . "/Swift/includes/js/jquery/jquery-1.10.2.min.js");
	}
	
	/**
	 * Creates and returns an HTML script tag which links the web page to a specificed JavaScript file.
	 * @param string $src The JavaScript file to link/include.
	 * @return string A HTML compatible script tag.
	 */
	public function createJavaScriptTag($src) {
		return $this->createScriptTag("text/javascript", $src);
	}
	
	/**
	 * Creates and returns an HTML link tag to the provided stylesheet.
	 * @param string $url The URL of the stylesheet.
	 * @param string $media The media type attribute for the HTML link tag.
	 * @return string A HTML compatible link tag.
	 */
	public function createStyleSheetTag($url, $media = null) {
		return $this->createLinkTag("stylesheet", $url, "text/css", null, $media);
	}
	
	/**
	 * Creates and returns an HTML link tag for a shortcut icon.
	 * @param string $url The URL of the shortcut icon.
	 * @return string A HTML compatible link tag.
	 */
	public function createShortcutIconTag($url) {
		return $this->createLinkTag("shortcut icon", $url, "image/x-icon");
	}
	
	/**
	 * Creates and returns an HTML link tag for an ATOM feed.
	 * @param string $url The URL of the ATOM feed.
	 * @param string $title The name or title of the ATOM feed.
	 * @return string A HTML compatible link tag.
	 */
	public function createAtomFeedTag($url, $title = null) {
		return $this->createLinkTag("alternate", $url, "application/atom+xml", $title);
	}
	
	/**
	 * Creates and returns an HTML link tag for an RSS feed.
	 * @param string $url The URL of the RSS feed.
	 * @param string $title The name or title of the RSS feed.
	 * @return string A HTML compatible link tag.
	 */
	public function createRSSFeedTag($url, $title = null) {
		return $this->createLinkTag("alternate", $url, "application/rss+xml", $title);
	}
	
	/**
	 * Creates and returns an HTML link tag for the canonical URL of the web page.
	 * @param string $url The canonical url.
	 * @return string A HTML compatible link tag.
	 */
	public function createCanonicalTag($url) {
		return $this->createLinkTag("canonical", $url);
	}
	
	/**
	 * Creates and returns an HTML description meta tag with the provided description as it's value.
	 * @param string $description The description content.
	 * @return string A HTML compatible meta tag.
	 */
	public function createDescriptionTag($description) {
		$short_desc = substr($description, 0, 150);
		return $this->createMetaTag("description", $short_desc);
	}
	
	/**
	 * Creates and returns an HTML keywords meta tag with the provided keywords as it's value.
	 * @param string $keywords The keywords (coma seperated) to use.
	 * @return string A HTML compatible meta tag.
	 */
	public function createKeywordsTag($keywords) {
		return $this->createMetaTag("keywords", $keywords);
	}
	
	/**
	 * Creates and returns an HTML content type meta tag to describe the document.
	 * @param string $charset The charset to use. The default charset UTF-8 will be used otherwise.
	 * @return string A HTML compatible meta tag.
	 */
	public function createContentTypeTag($charset = null) {
		if (!$charset) {
			$charset = "text/html; charset=UTF-8";
		}
		return $this->createMetaTag(null, $charset, "Content-Type");
	}
	
	/**
	 * Creates and returns an HTML title tag with provided title.
	 * @param string $title The title of the web page.
	 * @return string A HTML compatible title tag.
	 */
	public function createTitleTag($title) {
		return "<title>" . $title . "</title>\n";
	}
	
	/**
	 * Creates and returns an HTML link tag with the specified tag attributes.
	 * @param string $rel The rel attribute. (Optional)
	 * @param string $href The href attribute. (Optional)
	 * @param string $type The type attribute. (Optional)
	 * @param string $title The title attribute. (Optional)
	 * @param string $media The media attribute. (Optional)
	 * @param string $target The target attribute. (Optional)
	 * @return string A HTML compatible link tag.
	 */
	public function createLinkTag($rel = null, $href = null, $type = null, $title = null, $media = null, $target = null) {
		$link_tag = "<link";
		if ($rel) {
			$link_tag .= " rel=\"" . $rel . "\"";
		}
		if ($href) {
			$link_tag .= " href=\"" . $href . "\"";
		}
		if ($type) {
			$link_tag .= " type=\"" . $type . "\"";
		}
		if ($title) {
			$link_tag .= " title=\"" . $title . "\"";
		}
		if ($media) {
			$link_tag .= " media=\"" . $media . "\"";
		}
		if ($target) {
			$link_tag .= " target=\"" . $target . "\"";
		}
		$link_tag .= " />\n";
		return $link_tag;
	}
	
	/**
	 * Creates and returns an HTML meta tag with the provided attributes.
	 * @param string $name The name attribute. (Optional)
	 * @param string $content The content attribute. (Optional)
	 * @param string $http_equiv The http_equiv attribute. (Optional)
	 * @param string $scheme The scheme attribute. (Optional)
	 * @param string $dir The dir attribute. (Optional)
	 * @param string $lang The lang attribute. (Optional)
	 * @param string $xml_lang The xml_lang attribute. (Optional)
	 * @return string A HTML compatible meta tag.
	 */
	public function createMetaTag($name = null, $content = null, $http_equiv = null, $scheme = null, $dir = null, $lang = null, $xml_lang = null) {
		$meta_tag = "<meta";
		if ($name) {
			$meta_tag .= " name=\"" . $name . "\"";
		}
		if ($http_equiv) {
			$meta_tag .= " http-equiv=\"" . $http_equiv . "\"";
		}
		if ($content) {
			$meta_tag .= " content=\"" . $content . "\"";
		}
		if ($scheme) {
			$meta_tag .= " scheme=\"" . $scheme . "\"";
		}
		if ($dir) {
			$meta_tag .= " dir=\"" . $dir . "\"";
		}
		if ($lang) {
			$meta_tag .= " lang=\"" . $lang . "\"";
		}
		if ($xml_lang) {
			$meta_tag .= " xml_lang=\"" . $xml_lang . "\"";
		}
		$meta_tag .= " />\n";
		return $meta_tag;
	}
	
	/**
	 * Creates and returns an HTML input tag with the provided attributes.
	 * @param string $type The HTML input type. (Default: text)
	 * @param string $name The name attribute. (Optional)
	 * @param string $id The ID attribute. (Optional)
	 * @param string $value The value attribute. (Optional)
	 * @param array $attribute_array An array of attributes for the HTML input tag, where the key is the name and the value is the value. (Optional)
	 * @return string A HTML compatible input tag.
	 */
	public function createInputTag($type = 'text', $name = null, $id = null, $value = null, $attribute_array = null) {
		$input_tag = "<input type=\"" . $type . "\"";
		if ($name) {
			$input_tag .= " name=\"" . $name . "\"";
		}
		if ($id) {
			$input_tag .= " id=\"" . $id . "\"";
		}
		if ($value) {
			$input_tag .= " value=\"" . $value . "\"";
		}
		if ($min) {
			$input_tag .= " min=\"" . $min . "\"";
		}
		if ($max) {
			$input_tag .= " max=\"" . $max . "\"";
		}
		if ($checked) {
			$input_tag .= " checked=\"checked\"";
		}
		if (is_array($attribute_array)) {
			foreach ($attribute_array as $attr => $val) {
				$input_tag .= " " . $attr . "=\"" . $val . "\"";
			}
		}
		$input_tag .= " />\n";
		return $input_tag;
	}
	
	/**
	 * Creates and returns an HTML textarea tag with the provided attributes.
	 * @param string $name The name attribute. (Optional)
	 * @param string $id The ID attribute. (Optional)
	 * @param string $value The value of the textarea. (Optional)
	 * @return string A HTML compatible textarea tag.
	 */
	public function createTextAreaTag($name = null, $id = null, $value = null) {
		$textarea_tag = "<textarea ";
		if ($name) {
			$textarea_tag .= " name=\"" . $name . "\"";
		}
		if ($id) {
			$textarea_tag .= " id=\"" . $id . "\"";
		}
		$textarea_tag .= ">";
		if ($value) {
			$textarea_tag .= $value;
		}
		$textarea_tag .= "</textarea>\n";
		return $textarea_tag;
	}
	
	/**
	 * Creates and returns an HTML select tag with the provided options and attributes.
	 * @param array $option_array An array, where array key is the option value and array value is the option label.
	 * @param string $name The name attribute. (Optional)
	 * @param string $id The ID attribute. (Optional)
	 * @param integer $selected_option The index of the $option_array to preset as selected. (Optional)
	 * @return string A HTML compatible select tag.
	 */
	public function createSelectTag($option_array = null, $name = null, $id = null, $selected_option = -1) {
		if (!is_array($option_array)) {
			return false;
		}
		$select_tag = "<select ";
		if ($name) {
			$select_tag .= " name=\"" . $name . "\"";
		}
		if ($id) {
			$select_tag .= " id=\"" . $id . "\"";
		}
		$select_tag .= ">\n";
		foreach ($option_array as $key => $value) {
			if ($selected_option == $i++) {
				$select_tag .= $this->createOptionTag(null, null, $value, $key, true);
				$first_option = false;
			} else {
				$select_tag .= $this->createOptionTag(null, null, $value, $key, false);
			}
		}
		$select_tag .= "</select>\n";
		return $select_tag;
	}
	
	/**
	 * Creates and returns an HTML option tag with the provided attributes.
	 * @param string $name The name attribute. (Optional)
	 * @param string $id The ID attribute. (Optional)
	 * @param string $value The value of the option. (Optional)
	 * @param string $label The label of the option. (Optional)
	 * @param boolean $selected Whether this value should be selected. Default = false (Optional)
	 * @return string A HTML compatible option tag.
	 */
	public function createOptionTag($name = null, $id = null, $value = null, $label = null, $selected = false) {
		$option_tag = "<option ";
		if ($name) {
			$option_tag .= " name=\"" . $name . "\"";
		}
		if ($id) {
			$option_tag .= " id=\"" . $id . "\"";
		}
		if ($selected) {
			$option_tag .= " selected=\"selected\"";
		}
		if ($value) {
			$option_tag .= " value=\"" . $value . "\"";
		}
		$option_tag .= ">";
		if ($label) {
			$option_tag .= $label;
		}
		$option_tag .= "</option>\n";
		return $option_tag;
	}
	
	/**
	 * Creates and returns an HTML script tag of the specified $type and $src.
	 * @param string $type The type of script (e.g. JavaScript).
	 * @param string $src The source or URL of an external script document.
	 * @return string A HTML compatible script tag.
	 */
	public function createScriptTag($type, $src) {
		$script_tag = "<script";
		if ($type) {
			$script_tag .= " type=\"" . $type . "\"";
		}
		if ($src) {
			$script_tag .= " src=\"" . $src . "\"";
		}
		$script_tag .= "></script>\n";
		return $script_tag;
	}
	
}
?>