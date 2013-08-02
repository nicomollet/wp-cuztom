<?php

/**
 * Main class for pages
 *
 * @author 	Gijs Jorissen
 * @since 	3.0
 *
 */
class Cuztom_Page extends Cuztom_Meta
{
	var $page_title;
	var $menu_title;
	var $capability;
	var $menu_slug;
	var $data;

	function __construct( $page_title, $menu_title, $capability, $menu_slug, $data )
	{
		$this->page_title 	= Cuztom::beautify( $page_title );
		$this->menu_title 	= Cuztom::beautify( $menu_title );
		$this->capability 	= $capability;
		$this->menu_slug 	= Cuztom::uglify( $menu_slug );
			
		// Chack if the class, function or method exist, otherwise use cuztom callback
		if( Cuztom::is_wp_callback( $data ) )
		{
			$this->callback = $data;
		}
		else
		{
			$this->callback = array( &$this, 'callback' );

			// Build the meta box and fields
			$this->data = $this->build( $data );
		}
	}

	function callback()
	{
		echo '<div class="wrap cuztom">';
			echo '<div id="icon-options-general" class="icon32"><br></div>';
			echo '<h2>' . $this->page_title . '</h2>';

			echo '<form method="post" action="options.php">';
		
				parent::callback( 'page' );

			echo '</form>';

		echo '</div>';
	}
}