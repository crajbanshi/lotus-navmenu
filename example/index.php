<?php
error_reporting(E_ALL);
use Lotus\Navmenu\Menu;
require_once('../src/Menu.php');

$navbar = [ 'home' => [ 'label' => 'Home', 'url' =>  ( '/Home' ),  ],
	    'View' => [ 'label' => 'View', 'url' => '',
			 'child' => [
				 'user_related' => [ 'label' => 'User Related', 'url' => '#' , 'icon'=>'fa fa-user',
                 'subchild' =>[
                     'jjuser_related' => [ 'label' => 'User1', 'url' => 'index.php/User' ,'icon'=>'fa fa-user' ],
                     'use2' => [ 'label' => 'User2', 'url' => 'index.php/User2' ,'icon'=>'fa fa-user',
                        'subchild' => [
                                'user_relatexccscd' => [ 'label' => 'sub User', 'url' => '#' , 'icon'=>'fa fa-user',
                                'subchild' =>[
                                    'jjuser_relx cxzated' => [ 'label' => 'User133', 'url' => 'index.php/User2/use' ,'icon'=>'fa fa-user' ],
                                    'use232' => [ 'label' => 'User2323', 'url' => 'index.php/User2/dsjcd' ,'icon'=>'fa fa-user',
                                    
                                    ]
                                ]
                                ]
                            ]
                      ]
                 ]
                  ]
			]
		 ],
		'AboutUs' => [ 'label' => 'About Us', 'url' => '#' , 
			'child' => [ 'aboutus' => [ 'label' => 'About Us', 'url' =>  ( 'index.php/About-us' ) ],
				     'contactus' => [ 'label' => 'Contact Us', 'icon' => 'fa fa-envelope', 'url' =>  ( 'index.php/Contactus' ) ]
				 ] 
			],
		'usermenu' => [ 'label' => 'Login', 'icon' => 'fa fa-sign-in', 'url' => "#", 'atribute' => [ 'onClick' => "log_in();" ] ] 
	];

Menu::setBaseUrl('http://localhost/phpmailer/lotus-navmenu/example/');
    $type = 'user';
Menu::setMenuArray ( $navbar,[ 'class' => 'nav nav-bar' ] );

echo Menu::render ( );

echo "<br/><br/><br/><br/>";
echo Menu::renderBreadcumb();

echo "<br/><br/><br/><br/><pre>";
var_dump( Menu::getActiveMenu(0) );

echo "<br/><br/><br/><br/><pre>";
var_dump( Menu::getActiveMenu(0) );





