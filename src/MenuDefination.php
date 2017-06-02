<?php

namespace Lotus\Navmenu;
/**
 * This class is helps to generate nevigation bar and breadcumb.
 *
 * Future Scope: Generate Site Map.
 *
 * @package Sarthac-HCCMC
 * @author Chanchal Rajbanshi
 * @since version 1.0
 *         
 */
abstract class MenuDefination {
	
	/**
	 *
	 * @var array
	 */
	protected static $menu = array ();
	
	/**
	 *
	 * @var array
	 */
	protected static $breadcumb = array ();
	
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
	 * Setting Valid Menu in the form of an array
	 *
	 * @param string $menu        	
	 * @return boolean
	 */
	protected static function setMenuArray($menu = NULL, $attributes = '') {
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


}
