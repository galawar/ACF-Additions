<?php

namespace ACFAdditions;

class Main
{
	use Singleton;

	public static function init()
	{
		add_action( 'admin_init', function() {
			if ( function_exists( 'acf_register_field_type' ) ) {
				acf_register_field_type( '\ACFAdditions\Fields\Field_ContactForm7' );
				acf_register_field_type( '\ACFAdditions\Fields\Field_GravityForms' );
			}
		} );
	}

}