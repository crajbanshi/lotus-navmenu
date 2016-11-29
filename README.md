# pw_NavMenu

import "github.com/crajbanshi/pw_NavMenu"

Menu is a php class which auto build navigation menu.

Array format of input manu array is

Menu class have five static methods.

First Input the menu array and navbar css class.

Menu::setMenuArray ( $navbar, [ 'class' => 'nav navbar-nav' ] );

To place menu at your page, use render method at your header page.

Menu::render ();

This class also generate breadcumb for your webside as,

Menu::breadcumbHelper ();

Get nav menu array by

Sitemap::getMenuArray();

set attribute array

Sitemap::setAttributes($attributes)

You can validate your menu array by using validate() method.

Menu::validate($navbar)

$navbar_1 = [ 'home' => [ 'label' => 'Home', 'url' => baseUrl ( '/Home' ) ], 'View' => [ 'label' => 'View', 'url' => '#', 'child' => [ 'ndview' => [ 'label' => 'View1', 'url' => baseUrl ( '/View1' ) ], 'saview' => [ 'label' => 'View2', 'url' => baseUrl ( '/View2' ) ], 'soview' => [ 'label' => 'View 3S', 'url' => baseUrl ( '/View3' ) ], 'user_related' => [ 'label' => 'User Related', 'url' => '#' , 'subchild' => [ 'user_desk Mapping' => [ 'label' => 'User - Desk Mapping', 'url' => baseUrl ( '/User-Desk-Mappings' ) ], ] ] ] ], 'AboutUs' => [ 'label' => 'About Us', 'url' => '#' , 'child' => [ 'aboutus' => [ 'label' => 'About Us', 'url' => baseUrl ( '/About-us' ) ], 'contactus' => [ 'label' => 'Contact Us', 'icon' => 'fa fa-envelope', 'url' => baseUrl ( '/Contactus' ) ] ] ], 'usermenu' => [ 'label' => 'Login', 'icon' => 'fa fa-sign-in', 'url' => "#", 'atribute' => [ 'onClick' => "$('#error_msg').html('');log_in();" ] ] ];

$navbar_2 =$navbar_ws = [ 
		'dashboard' => [ 
				'label' => 'Dashboard',
				'url' => baseUrl ( '/Dashboard' ) 
		],		
'usermenu' => [ 
				'label' => getUserRealName (),
				'url' => '#',				
				'child' => [ 
						'profile' => [ 
								'label' => 'Profile',
								'url' => baseUrl ( '/profile' ) 
						],						
						'logout' => [ 
								'label' => 'Log out',
								'icon' => 'fa fa-sign-out',
								'url' => baseUrl ( '/logout' ) 
						] 
				] 
		],
Its also use multiple array of menu.

to add multiple menu, suppose you have two nav menu namely $navbar_1 and $navbar_2.

Sitemap::append ( $navbar_1, 'public' );
Sitemap::append ( $navbar_1, 'user' );

now we have to select a menu is **user** dynamically using code

Sitemap::setMenuType ( 'user', 'nav navbar-nav' );

This one can generate sitemap also. site map using this class library.

Generate Sitemap in Sitemap page use,

Sitemap::renderSitemap( $menutype ) ;

$menutype is either **public** or **user**.



