<?php

namespace ACFAdditions;

class Requirements
{
	use Singleton;
	public function checkPluginRequirements() {
		if ( ! function_exists( 'acf' ) ) {
			$this->display_error(
				__( 'Advanced Custom Fields or Advanced Custom Fields PRO are required plugin.', ACFA_DOMAIN )
			);

			return false;
		}

		if ( version_compare( acf()->version, '5.6.0', '<' ) ) {
			$this->display_error(
				__( 'Advanced Custom Fields should be on version 5.6.0 or above.', ACFA_DOMAIN )
			);

			return false;
		}

		return true;
	}

	// Display message and handle errors
	public function display_error( $message ) {
		trigger_error( esc_html( $message ) );

		add_action(
			'admin_notices',
			function () use ( $message ) {
				printf(
					'<div class="notice error is-dismissible"><p>%s</p></div>',
					esc_html( $message )
				);
			}
		);

		// Deactive self
		add_action(
			'admin_init',
			function () {
				deactivate_plugins( ACFA_MAIN_FILE );
				unset( $_GET['activate'] );
			}
		);
	}
}