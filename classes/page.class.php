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

			// Register settings
			add_action( 'admin_init', array( &$this, 'register_settings' ) );
			add_action( 'admin_init', array( &$this, 'add_settings_sections' ) );
			add_action( 'admin_init', array( &$this, 'add_settings_fields' ) );
		}
	}

	function register_settings()
	{
		if( is_array( $this->fields ) )
		{
			foreach( $this->fields as $id => $field )
			{
				register_setting( 'cuztom', 'cuztom[' . $field->id . ']' );
			}
		}
	}

	function add_settings_sections()
	{
		add_settings_section( 'cuztom_section', 'Cuztom Section', array( &$this, 'section_callback' ), $this->menu_slug );
	}

		function section_callback()
		{
			echo 'Just a description here!';
		}

	function add_settings_fields()
	{
		if( is_array( $this->fields ) )
		{
			foreach( $this->fields as $id => $field )
			{
				add_settings_field( $field->id, $field->label, array( $field, 'output' ), $this->menu_slug, 'cuztom_section' );
			}
		}
	}

	function callback()
	{
		echo '<div class="wrap cuztom">';
			echo '<div id="icon-options-general" class="icon32"><br></div>';
			echo '<h2>' . $this->page_title . '</h2>';

			echo '<form method="post" action="options.php">';

				settings_fields( 'cuztom' );
				do_settings_sections( $this->menu_slug );

				// parent::callback( 'page' );

				submit_button();

			echo '</form>';

		echo '</div>';
	}
}