PHP Menu builder for Codeigniter and Laravel
============================================

This is a package for simply creating Navigation Menu, breadcumb and sitemap in PHP, Codeigniter and Laravel 5.

## Introduction

Simply use the `Menu` facade in the place of the `Nav Menu` facade when you want to generate a Navigation Menu.

Add via composer

```php
composer require lotus/navmenu
```


Menu is a php class which auto build navigation menu.



First Input the menu array and navbar css class.

```php
$type = 'user';
Menu::append ( $navbar_1,[ 'class' => 'nav nav-bar' ], $type );
```

To place menu at your page, use render method at your header page.

```php
echo Menu::render ( $type );
```



This one can generate sitemap also. site map using this class library.

Generate Sitemap in Sitemap page use,

Menu::renderSitemap( $type, 'Customer' ) ;

$menutype is either **public** or **user**.


Example menu input array

```php
$navbar = [ 'home' => [ 'label' => 'Home', 'url' =>  ( '/Home' ) ],
	    'View' => [ 'label' => 'View', 'url' => '',
			 'child' => [
				 'user_related' => [ 'label' => 'User Related', 'url' => '#'  ]
			]
		 ],
		'AboutUs' => [ 'label' => 'About Us', 'url' => '#' , 
			'child' => [ 'aboutus' => [ 'label' => 'About Us', 'url' =>  ( '/About-us' ) ],
				     'contactus' => [ 'label' => 'Contact Us', 'icon' => 'fa fa-envelope', 'url' =>  ( '/Contactus' ) ]
				 ] 
			],
		'usermenu' => [ 'label' => 'Login', 'icon' => 'fa fa-sign-in', 'url' => "#", 'atribute' => [ 'onClick' => "log_in();" ] ] 
	];
```

