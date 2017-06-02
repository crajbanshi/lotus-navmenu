<?php
/**
 * This class is helps to generate nevigation bar and breadcumb.
 *
 * Future Scope: Generate Site Map.
 *
 * @package pw
 * @author Chanchal Rajbanshi
 * @version 1.1
 *         
 */

namespace Lotus\Navmenu;


require_once('MenuDefination.php');

use Lotus\Navmenu\MenuDefination;

/**
*
*
*
*
*/

class Menu {
	
	/**
	 *
	 * @var array
	 */
	protected static $menu = array ();
	
	/**
	 *
	 * @var array
	 */
	public static $breadcumb = array ();
	
	/**
	 *
	 * @var boolean
	 */
	protected static $is_breadcumb = FALSE;
	
	/**
	 *
	 * @var array
	 */
	protected static $attributes = array ();

	protected static $activeMenu = array();

	/**
	 * base url
	 *
	 * @var array
	 */
	protected static $baseUrl = '';
	
	
	public static function setBaseUrl( $base = NULL ) {
		if(empty($base)){
			$base = $_SERVER['HTTP_HOST'];
		}
		if (!filter_var($base, FILTER_VALIDATE_URL) === false) {
			self::$baseUrl = $base;
		} else {
			throw Exception ("$base is not a valid URL");
		}
			
	}
	/*
	 * |-------------------------------------------------------------------------- | Queueable Jobs |-------------------------------------------------------------------------- | | This job base class provides a central location to place any logic that | is shared across all of your jobs. The trait included with the class | provides access to the "queueOn" and "delay" queue helper methods. |
	 */
	/**
	 * This is a static method that helps to generate HTML nevigation menu bar.
	 *
	 * @return String
	 */
	public static function render( $depth = 10 ) {
		return (new Menu ())->menuHelper ($depth);
	}
	
	/**
	 * This is a static method that helps to generate HTML Breadcumb for the respective Menu paths
	 *
	 * @return string
	 */
	public static function breadcumbHelper() {
		return (new Menu ())->htmlBreadcumb ();
	}
	
	/**
	 * Setting Valid Menu in the form of an array
	 *
	 * @param string $menu        	
	 * @return boolean
	 */
	public static function setMenuArray($menu = NULL, $attributes = '') {
		if ($menu === NULL) {
			// TODO
		}
		
		// set Attributes for Menu UL
		if (is_array ( $attributes )) {
			self::setAttributes ( $attributes );
		}
		
		// validate and set Menu
		if (self::validate ( $menu )) {
			self::$menu = $menu;
			return true;
		}
	}
	
	/**
	 * set attributes for UL manu
	 *
	 * @param array $attributes        	
	 */
	public static function setAttributes(array $attributes) {
		self::$attributes = $attributes;
	}
	
	/**
	 */
	public function getAttributes() {
		$str = '';
		
		foreach ( self::$attributes as $key => $val ) {
			$str .= " $key = \"$val\"";
		}
		
		return $str;
	}
	/**
	 * Getting the menu as an array
	 *
	 * @return array
	 */
	public static function getMenuArray() {
		if (empty ( self::$menu )) {
			// TODO
		}
		return self::$menu;
	}

	/**
	 * Getting breadcumb string Alias
	 *
	 * @return string
	 */
	public static function renderBreadcumb() {
		return self::breadcumbHelper();
	}
	
	/**
	 * Validation for Menu Array
	 *
	 * @param array $menu        	
	 * @throws \Exception
	 * @return boolean
	 */
	public static function validate($menu) {
		foreach ( $menu as $key => $val ) {
			
			if (is_array ( $val )) {
				
				if (! array_key_exists ( 'label', $val )) {
					throw new \Exception ( 'Label required for manu entry.' );
				}
				if (! array_key_exists ( 'url', $val )) {
					
					throw new \Exception ( 'url required for manu entry.' );
				}
				
				if (isset ( $val ['child'] )) {
					
					self::validate ( $val ['child'], TRUE );
				} elseif (isset ( $val ['subchild'] )) {
					
					self::validate ( $val ['subchild'], TRUE );
				} else {
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Generating Absolute URL
	 */

	function url($path){
		if(function_exists('site_url')){
			$url = site_url($path);
		}elseif(function_exists('url')){
			$url = url($path);
		}
		elseif(function_exists('base_url')){
			$url = base_url($path);
		}else{
			$url = self::$baseUrl . $path;
		}
		

		return $url;
	}
	/**
	 * Generating HTML Navigation Bar in the form of HTML
	 */
	protected function menuHelper($depth) {
		$this->activeMenu ( self::$menu);
		
		echo '<ul ' . $this->getAttributes () . '>' . $this->generateMenu ( self::$menu, $depth ) . '';
		$this->renderJS ();
	}
	protected function renderJS() {
		// echo '<script type="text/javascript">';
		// echo '$(function(){';
		// /*When the form is submitted, validate all data and fields using HTML5 validation.*/
		// echo <<<JS
		// //TODO $('.dropdown-submenu > a').submenupicker();
		// JS;
		// echo '}); </script>';
	}
	
	/**
	 *
	 * @return mixed
	 */
	protected function requestUri() {
		if(function_exists('site_url') && function_exists('current_url')){
			$rawUri = str_replace(site_url(), '',current_url() ) ;
		}else{			
			$rawUri = !empty($rawUri)? $rawUri : ( $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER ['HTTP_HOST']. $_SERVER ['REQUEST_URI'] );
			$rawUri = (explode ( "#", (explode ( "?",  $rawUri ) [0]) ) [0]);
			$rawUri = str_replace(self::$baseUrl, '',$rawUri ) ;
		}

		return $rawUri; 
	}
	/**
	 * Generating the Menu Array to HTML String
	 *
	 * @param array $menu        	
	 * @param string $child        	
	 * @return string
	 */
	protected function generateMenu($menu, $depth , $child = FALSE, $attr = array()) {
		$stringmenu = '';
		if ($child) {
			$stringmenu .= '<ul class="dropdown-menu" ';			
			if (!empty ( $attr )) {
			
				foreach ( $attr as $attkey => $attval )
					$stringmenu .= $attkey . '="' . $attval . '" ';
			}
			
			$stringmenu .= ' >';
		}
		
		foreach ( $menu as $key => $val ) {
			
			if (is_array ( $val )) {
				
				if (isset ( $val ['child'] ) && $depth >= 2) {
					$stringmenu .= '<li class="dropdown ';
					
					$stringmenu .= $this->active ( $val );
					
					$stringmenu .= '"><a 
            class="dropdown-toggle " data-toggle="dropdown"
                data-hover="dropdown" data-delay="0" data-close-others="false"
                    href="' . $val ['url'] . '"> ';
					
					if (isset ( $val ['icon'] )) {
						
						$stringmenu .= '<i class="' . $val ['icon'] . '"></i>&nbsp;';
					}
					$stringmenu .= $val ['label'] . '<span class="caret"></span></a>';
					
					$stringmenu .= $this->generateMenu ( $val ['child'],$depth, TRUE );

					$stringmenu .= '</li>';
				} elseif (isset ( $val ['subchild'] ) && $depth>=3) {
					$stringmenu .= '<li class="dropdown-submenu ';
					
					$stringmenu .= $this->active ( $val );
					
					$stringmenu .= '"><a 
            class="dropdown-toggle " data-toggle="dropdown"
                data-hover="dropdown" data-delay="0" data-close-others="false"
                    href="' . $val ['url'] . '"> ';
					
					if (isset ( $val ['icon'] )) {
						
						$stringmenu .= '<i class="' . $val ['icon'] . '"></i>&nbsp;';
					}

					 $stringmenu .= $val ['label'] . '</a>';
					
					$stringmenu .= $this->generateMenu ( $val ['subchild'], $depth, TRUE,  isset($val ['attribute'])?$val ['attribute']:null );
					$stringmenu .= '</li>';
				} else {
					
					$stringmenu .= '<li ';
					if ($this->requestUri () === $val ['url'] || self::$activeMenu == $key  ) {
						
						$stringmenu .= ' class="active"';
					}
					
					$stringmenu .= '><a href="' . $this->url( $val ['url'] ) . '" ';
					
					if (isset ( $val ['attribute'] )) {
						foreach ( $val ['attribute'] as $attkey => $attval )
							$stringmenu .= $attkey . '="' . $attval . '"';
					}
					
					$stringmenu .= '>';
					
					if (isset ( $val ['icon'] )) {
						
						$stringmenu .= '<i class="' . $val ['icon'] . '"></i>&nbsp;';
					}
					
					$stringmenu .= $val ['label'] . '</a></li>';
				}
			}
		}
		$stringmenu .= '</ul>';
		
		return $stringmenu;
	}
	
	/**
	 * Finding out the active absolute path from menu array and setting up it as active path.
	 *
	 *
	 * @param array $menu        	
	 * @param string $child        	
	 */
	private function activeMenu($menu) {
		foreach ( $menu as $key => $val ) {
			if (is_array ( $val )) {
				if (isset ( $val ['child'] )) {
				  $ret =	$this->activeMenu ( $val ['child'] );	
				  if ($this->requestUri () === $val ['url']) {					
					self::$activeMenu = $key;
						$this->appendToBreadcumb ( [ 
							$key => $val 
					] );
				}		 
				 
				} elseif (isset ( $val ['subchild'] )) {
					
				return	$this->activeMenu ( $val ['subchild'] );
				} elseif ($this->requestUri () === $val ['url']) {
					
					$this->appendToBreadcumb ( [ 
							$key => $val 
					] );				
					
					self::$is_breadcumb = true;
					
				}
			}

			if(self::$is_breadcumb ){
				$this->appendToBreadcumb ( [ 
							$key => $val 
					] );
					self::$activeMenu = $key;
					break;
			}

		}
		
		// if breadcumb not found then clear record
		if (! self::$is_breadcumb) {
			
			$this->clearBreadcumb ();
		}
		
		return self::$is_breadcumb;
	}
	
	/**
	 * Clearing the Breadcumb
	 */
	private function clearBreadcumb() {
		self::$is_breadcumb = false;
		self::$breadcumb = array ();
	}
	
	/**
	 * Find Key from multidimention array
	 *
	 * @param unknown $array        	
	 * @param unknown $keySearch        	
	 * @return boolean
	 */
	private function findKey($array, $keySearch) {	
		if(!is_array($array)){
			return false;
		}	
		foreach ( $array as $key => $item ) {
			if(is_array($item) && array_key_exists($keySearch, $item) ){
				return true;
			} else {
				if (is_array ( $item ) ) {
					return $this->findKey ( $item, $keySearch );
				}
			}
		}
		
		return false;
	}
	private function active($val) {
		$stringmenu = '';
		foreach ( self::$breadcumb as $link ) {
			foreach ( $link as $keyb => $valb ) {
				
				if ($this->findKey ( $val, $keyb )) {					
					$stringmenu = 'active ';
				}
			}
		}
		
		return $stringmenu;
	}
	
	/**
	 * Returning the breadcumb if active path is set.
	 * Returning Boolean value false, otherwise
	 *
	 * @return array: boolean
	 */
	private static function getBreadcumb() {
		if (self::$is_breadcumb) {
			return self::$breadcumb;
		}
		return self::$is_breadcumb;
	}

/**
*  get active menu
*
*/
	public static function getActiveMenu($label = 0) {
		if (self::$activeMenu && $label == 0) {
			return isset(self::$menu[self::$activeMenu]['child'])?self::$menu[self::$activeMenu]['child']: false;
		}

	}
	
	private function getBreadcumbPath($key, $haystack) {
		$menuPath = array ();
		$strings = '';
		
		foreach ( $haystack as $keyb => $val ) {
			if ($this->findKey ( $val, $key )) {
				$menuPath [] = $keyb;
				$icon = isset($val ['icon'])?'<i class="' . $val ['icon'] . '"></i>':'';
				if (! empty ( $val ['url'] )){				
					$strings .= '<li><a href="' . $this->url($val ['url']) . '">' . $icon . '&nbsp;' . $val ['label'] . '</a></li>';
				}
				if (is_array ( $val )) {
					$strings .= $this->getBreadcumbPath ( $key, $val );
				}
			}
		}
		
		return $strings;
	}
	
	/**
	 * Generating Breadcumb in the form of HTML
	 *
	 * @return string
	 */
	private function htmlBreadcumb() {
		if ($this->requestUri () ===  'home'  || $this->requestUri () ===  '/') {
			return '';
		}
		
		$htmlStrings = '<ol class="breadcrumb">';
		$htmlStrings .= '<li><a href="' . $this->url ( '/' ) . '"><i class="fa fa-home"></i>&nbsp;Home</a></li>';
		
		$menuPath = array ();
		$key = '';
		if(isset( self::$breadcumb [0])){
			foreach ( self::$breadcumb [0] as $keyb => $val ) {
				$key = $keyb;
			}
			
			$htmlStrings .= $this->getBreadcumbPath ( $key, self::$menu );
			$icon = isset($val ['icon'])?'<i class="' . $val ['icon'] . '"></i>;':'';
			$htmlStrings .= '<li >' . $icon . '&nbsp;' . $val ['label'] . '</li>';
		}
		$htmlStrings .= '</ol>';
		
		echo $htmlStrings;
	}
	
	/**
	 * Appending absolute child path with the breadcumb.
	 *
	 * @param array $val        	
	 * @return multitype:
	 */
	protected function appendToBreadcumb($val) {
		if (! self::$is_breadcumb) {
			self::$is_breadcumb = true;
			self::$breadcumb [] = $val;			
			// Root active menu			
			return self::$breadcumb ;
		}
	}
}