<?php

/*
Plugin Name: ACF Additions
Plugin URI: https://github.com/galawar/acf-addtions
Description: Additional fields for Advanced Custom Fields
Version: 0.0.2
Author: galawar
Author URI: https://github.com/galawar
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( !defined( 'ABSPATH' ) ) die( 'Access denied.' );

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// Plugin constants
define( 'ACFA_VERSION', '0.0.2' );
define( 'ACFA_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACFA_URL', plugin_dir_url( __FILE__ ) );
define( 'ACFA_MAIN_FILE', __FILE__ );
define( 'ACFA_DOMAIN', 'acfa-additions' );

if ( class_exists( '\ACFAdditions\Requirements' ) ) {
	add_action(
		'init',
		function () {
			if ( \ACFAdditions\Requirements::getInstance()->checkPluginRequirements() ) {
				\ACFAdditions\Main::getInstance();
			}
		},
		100
	);
}