<?php

namespace Lotus\Navmenu;

use Lotus\Navmenu\MenuDefination;

class Menu extends MenuDefination {
	/**
	 *
	 * @var array
	 */
	protected static $allmenu = array ();
	protected static $userEmbed = TRUE;
	
	/**
	 * add menu arrays for multiple users, key is user type or menu type
	 *
	 * @param array $new_menu        	
	 * @param string $key        	
	 */
	static function append(array $new_menu, $attributes = '', $key = 'public') {
		self::$allmenu [$key] = $new_menu;
		if (is_array ( $attributes )) {
			parent::setAttributes ( $attributes );
		}

	}
	/**
	*  Get Output
	*
	*
	*/
	static function renderSitemap($type = null, $label = '' ) {	
		
		$i = 0;
		echo '<div class="">';		
			
			echo '<div class="col-sm-6"><h2>Public</h2>' . (new Menu ())->generateSitemap ( self::$allmenu ['public'] ) . '</div>';
			
			echo !empty($type)?'<div class="col-sm-6"><h2>' . $label . '</h2>' . (new Menu ())->generateSitemap ( self::$allmenu [$type] ) . '</div>':'';

		echo '</div>';
	}
	
	/**
	* Generate HTML navigation menu
	* 
	*  @param int $depth        	
	*  @param string $type 
	*  @return string
	*/	
	static function render($depth = 10, $type = 'public'){
		parent::setMenuArray(self::$allmenu[$type] );
		
		return parent::render($depth);
	}
	
	/**
	 * 
	 * @param boolean $isEmbed
	 */
	public static function setEmbedUser($isEmbed = true){
		self::$userEmbed = $isEmbed;
	}
	
	
	public static function isEmbed(){
		return self::$userEmbed;
	}
	

	/**
	 *
	 * @param unknown $key        	
	 * @param string $attributes        	
	 */
	static function setMenuType($key, $attributes = '') {
		self::$key = $key;
		if ($key) {
		
			if(self::$userEmbed) {
				self::setMenuArray ( array_merge ( self::$allmenu [$key], isset(self::$allmenu ['user'])?self::$allmenu ['user']:null ), $attributes );
			}else{
				self::setMenuArray (  self::$allmenu [$key],  $attributes );
			}			
		} else {
			self::setMenuArray ( self::$allmenu ['public'],  $attributes );
		}
	}
	
	/**
	 * Generating the Sitemap to HTML String
	 *
	 * @param array $menu        	
	 * @param string $child        	
	 * @return string
	 */
	protected function generateSitemap($menu, $child = FALSE) {
		$stringmenu = '<ul class="">';
		
		foreach ( $menu as $key => $val ) {
			
			if (is_array ( $val )) {
				
				if (isset ( $val ['child'] )) {
					$stringmenu .= '<li class=""><a
                    href="' . $val ['url'] . '"> ' . $val ['label'] . '</a>';
					
					$stringmenu .= $this->generateSitemap ( $val ['child'], TRUE );
					$stringmenu .= '</li>';
				} elseif (isset ( $val ['subchild'] )) {
					$stringmenu .= '<li class=""';
					$stringmenu .= '"><a
                    href="' . $val ['url'] . '"> ' . $val ['label'] . '</a>';
					
					$stringmenu .= $this->generateSitemap ( $val ['subchild'], TRUE );
					$stringmenu .= '</li>';
				} else {
					
					$stringmenu .= '<li ';
					
					$stringmenu .= '><a href="' . $val ['url'] . '" ';
					
					if (isset ( $val ['atribute'] )) {
						foreach ( $val ['atribute'] as $attkey => $attval )
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
    
    protected function generateXMLSitemap($menu, $child = FALSE) {
        // TODO
}
}
