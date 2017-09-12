<?php
/*
Plugin Name:  MCC Tribe Event Locations
Plugin URI:   https://www.madcitycoders.com/plugins/mcc-tribe-event-locations/
Description:  A simple plugin that adds a location field for tribe events that can be displayed using a shortcode. MUST HAVE ACF and The Event Calendar plugins installed first.
Version:      1.0.0
Author:       Andrew Derse
Author URI:   https://www.madcitycoders.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/
class MCCTelLocations {
	/**
	 * Plugin activation code.
	 * Add code here if you desire action on plugin activation.
	 */
	static function install() {
		// do not generate any output here
	}

	/**
	 * Plugin shortcode.
	 *
	 * @param $atts
	 * text -> Add in before locations are displayed.
	 *
	 * @return string
	 */
	public static function mcc_tribe_event_locations( $atts ) {
		$a = shortcode_atts( array(
			'text' => 'Pickup Locations:'
		), $atts );
		$output = '';
		if( get_field( 'event_locations' ) ) {
			$locations = get_field( 'event_locations' );
			$output .= '<p style="font-style: italic">' . $a['text'] . ' ';
			if( $locations ) {
				$last_key = end(array_keys( $locations ));

				foreach ( $locations as $key => $location ) {
					if ( $key == $last_key ) {
						$output .= $location;
					} else {
						$output .= $location . ', ';
					}
				}
			} else {
				$output .= $locations;
			}
			$output .= '</p>';
		}
		return $output;
	}

	/**
	 * Adds in ACF fields to WordPress.
	 */
	public static function add_acf_fields() {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array (
				'key' => 'group_59a4c69655ca0',
				'title' => 'Tribe Events -> Locations',
				'fields' => array (
					array (
						'key' => 'field_59a4c6a14d19f',
						'label' => 'Locations',
						'name' => 'event_locations',
						'type' => 'checkbox',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array (
							'Chicago'   => 'Chicago',
							'Denver'    => 'Denver',
							'New York'  => 'New York',
						),
						'allow_custom' => 1,
						'save_custom' => 1,
						'default_value' => array (
						),
						'layout' => 'vertical',
						'toggle' => 1,
						'return_format' => 'value',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'tribe_events',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

		endif;
	}
}
register_activation_hook( __FILE__, array( 'MCCTelLocations', 'install' ) );

add_shortcode( 'mcc_tel', array( 'MCCTelLocations', 'mcc_tribe_event_locations' ) );

add_action( 'acf/init', array( 'MCCTelLocations', 'add_acf_fields' ) );






