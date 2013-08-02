<?php

/**
 * Class to register Menu Pages
 *
 * @author 	Gijs Jorissen
 * @since 	3.0
 *
 */
class Cuztom_Menu_Page extends Cuztom_Page
{
	var $icon_url;
	var $position;
	
	/**
	 * Constructor
	 *
	 * @param 	string 			$page_title
	 * @param 	string 			$menu_title
	 * @param 	string 			$capability
	 * @param 	string 			$menu_slug
	 * @param 	string|array	$data
	 * @param 	string 			$icon_url
	 * @param 	integer 		$position
	 *
	 * @author 	Gijs Jorissen 
	 * @since 	3.0
	 *
	 */
	function __construct( $page_title, $menu_title, $capability, $menu_slug, $data = array(), $icon_url = '', $position = 100 )
	{
		parent::__construct( $page_title, $menu_title, $capability, $menu_slug, $data );

		$this->icon_url 	= $icon_url;
		$this->position 	= $position;
		
		add_action( 'admin_menu', array( $this, 'register_menu_page' ) );
	}
	
	/**
	 * Hooked function to regster the menu page
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 *
	 */
	function register_menu_page()
	{
		add_menu_page( 
			$this->page_title, 
			$this->menu_title, 
			$this->capability, 
			$this->menu_slug, 
			$this->callback, 
			$this->icon_url,
			$this->position
		);
	}
	
	/**
	 * Add submenu page to the current parent page
	 * Method chaining is possible
	 *
	 * @param 	string 			$page_title
	 * @param 	string 			$menu_title
	 * @param 	string 			$capability
	 * @param 	string 			$menu_slug
	 * @param 	string|array	$data
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 *
	 */
	function add_submenu_page( $page_title, $menu_title, $capability, $menu_slug, $data = array() )
	{
		$submenu = new Cuztom_Submenu_Page( $this->menu_slug, $page_title, $menu_title, $capability, $menu_slug, $data );
		
		// For method chaining
		return $this;
	}
}