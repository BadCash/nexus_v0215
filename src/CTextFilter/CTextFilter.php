<?php use \Michelf\MarkdownExtra;

	/**
 * A class for handling all kinds of text filtering
 * 
 * @package NexusCore
 */
class CTextFilter {
	   
	  /**
	   * Apply filters to a text 
	   *
	   * @param $text string The text to filter
	   * @param $filters array Array containing strings for what filters to use [clickable, markdown, purify, bbcode]
	   * @returns string The filtered text
	   */
	   public static function Filter($text, $filters) {   
			$result = $text;
			
			if( in_array('purify', $filters) ){ 	$result = CHTMLPurifier::Purify($result); 	};
			if( in_array('bbcode', $filters) ){ 	$result = bbcode2html(htmlEnt($result)); 	};
			if( in_array('markdown', $filters) ){ 	$result = self::markdown($result); 			};
			if( in_array('clickable', $filters) ){ 	$result = self::make_clickable($result); 	};
			if( in_array('smartypants', $filters) ){$result = self::smartyPantsTypographer($result); 	};
			
			return $result;
	  }
  
  
	/**
	 * Format text according to PHP SmartyPants Typographer.
	 *
	 * @param string $text the text that should be formatted.
	 * @return string as the formatted html-text.
	 */
	public static function smartyPantsTypographer($text) {
	  require_once(__DIR__ . '/php-smartypants-typographer/smartypants.php');
	  return SmartyPants($text);
	}  
	
	
  
	 /**
	 * Make clickable links from URLs in text.
	 *
	 * @param string $text the text that should be formatted.
	 * @return string with formatted anchors.
	 */
	public static function make_clickable($text) {
	  return preg_replace_callback(
		'#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
		create_function(
		  '$matches',
		  'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
		),
		$text
	  );
	} 
	
	
	 
	/**
	 * Format text according to Markdown syntax.
	 *
	 * @param string $text the text that should be formatted.
	 * @return string as the formatted html-text.
	 */
	public static function markdown($text) {
	  require_once(__DIR__ . '/php-markdown-lib/Michelf/Markdown.php');
	  require_once(__DIR__ . '/php-markdown-lib/Michelf/MarkdownExtra.php');
	  return MarkdownExtra::defaultTransform($text);
	}	
  
}