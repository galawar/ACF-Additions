<?php

namespace ACFAdditions\Fields;

class Field_GravityForms extends \acf_field {
	/**
	 * Controls field type visibilty in REST requests.
	 *
	 * @var bool
	 */
	public $show_in_rest = true;

	/**
	 * Environment values relating to the theme or plugin.
	 *
	 * @var array $env Plugin or theme context such as 'url' and 'version'.
	 */
	private $env;

	/**
	 * Constructor.
	 */
	public function __construct() {
		/**
		 * Field type reference used in PHP and JS code.
		 *
		 * No spaces. Underscores allowed.
		 */
		$this->name = 'acfa_gf';

		/**
		 * Field type label.
		 *
		 * For public-facing UI. May contain spaces.
		 */
		$this->label = __( 'Gravity Forms', ACFA_DOMAIN );

		/**
		 * The category the field appears within in the field type picker.
		 */
		$this->category = 'Additional'; // basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME

		/**
		 * Field type Description.
		 *
		 * For field descriptions. May contain spaces.
		 */
		//$this->description = __( 'FIELD_DESCRIPTION', ACFA_DOMAIN );

		/**
		 * Field type Doc URL.
		 *
		 * For linking to a documentation page. Displayed in the field picker modal.
		 */
		//$this->doc_url = 'FIELD_DOC_URL';

		/**
		 * Field type Tutorial URL.
		 *
		 * For linking to a tutorial resource. Displayed in the field picker modal.
		 */
		//$this->tutorial_url = 'FIELD_TUTORIAL_URL';

		/**
		 * Defaults for your custom user-facing settings for this field type.
		 */
		$this->defaults = array();

		/**
		 * Strings used in JavaScript code.
		 *
		 * Allows JS strings to be translated in PHP and loaded in JS via:
		 *
		 * ```js
		 * const errorMessage = acf._e("FIELD_NAME", "error");
		 * ```
		 */
		$this->l10n = array(
			'error' => __( 'Error! Please enter a higher value', ACFA_DOMAIN ),
		);

		$this->env = array(
			'url'     => ACFA_URL,
			'version' => ACFA_VERSION, // Replace this with your theme or plugin version constant.
		);

		/**
		 * Field type preview image.
		 *
		 * A preview image for the field type in the picker modal.
		 */
		$this->preview_image = $this->env['url'] . 'assets/images/field-type-icons/icon-field-gravityform.svg';

		parent::__construct();
	}

	/**
	 * Settings to display when users configure a field of this type.
	 *
	 * These settings appear on the ACF “Edit Field Group” admin page when
	 * setting up the field.
	 *
	 * @param array $field
	 * @return void
	 */
	public function render_field_settings( $field ) {
		/*
		 * Repeat for each setting you wish to display for this field type.
		 */
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Description',ACFA_DOMAIN ),
				'instructions' => __( 'Allows you to select an available form from dropdown instead of copying/pasting form shortcodes.<br>Require plugin "Gravity Forms".',
					ACFA_DOMAIN ),
				'type'         => 'message',
			)
		);

		// To render field settings on other tabs in ACF 6.0+:
		// https://www.advancedcustomfields.com/resources/adding-custom-settings-fields/#moving-field-setting
	}

	/**
	 * HTML content to show when a publisher edits the field on the edit screen.
	 *
	 * @param array $field The field settings and values.
	 * @return void
	 */
	function render_field( $field ) {
		/*
		*  Create a select input with options.
		*/
		if ( in_array( 'gravityforms/gravityforms.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$gforms = \GFAPI::get_forms();

			if ( empty( $gforms ) ) {
				$gforms = __( 'No contact forms were found. Create a new form first.', ACFA_DOMAIN );
			}

			if ( is_array( $gforms ) ) { ?>

				<select name='<?php echo $field['name'] ?>' placeholder='Select the form...'>
					<option value="null"><?php echo __( 'Select the form...', ACFA_DOMAIN ); ?></option>

					<?php foreach ( $gforms as $form ) { ?>

						<option <?php selected( $field['value'], $form['id'] ); ?> value="<?php echo $form['id']; ?>">
							<?php echo $form['title']; ?>
						</option>

					<?php } ?>

				</select>

				<?php
			} else {
				echo "<p>$gforms</p>";
			}
		} else {
			_e( '<p>Plugin "Gravity Forms" is not installed.</p>', ACFA_DOMAIN );
		}
	}

	/**
	 * Enqueues CSS and JavaScript needed by HTML in the render_field() method.
	 *
	 * Callback for admin_enqueue_script.
	 *
	 * @return void
	 */
	public function input_admin_enqueue_scripts() {
		$url     = trailingslashit( $this->env['url'] );
		$version = $this->env['version'];

		wp_register_style(
			'acfa-gf',
			"{$url}assets/css/acfa-gf.css",
			array( 'acf-input' ),
			$version
		);

		wp_enqueue_style( 'acfa-gf' );
	}
}