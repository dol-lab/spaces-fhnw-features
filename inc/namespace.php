<?php
/**
 * Main file for plugin.
 *
 * @since 1.0.0
 */

namespace Spaces\FHNW;

/**
 * Bootstrap the plugin.
 */
function bootstrap() {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\add_styling_updates', 100 );
	add_action( 'customize_register', __NAMESPACE__ . '\add_customizer_css_feature', 100 );
}

/**
 * Add styling customizations to all the defaultspace themes and child themes.
 *
 * @uses wp_add_inline_style();
 *
 * @since 1.0.0
 */
function add_styling_updates() {
	wp_add_inline_style(
		'defaultspace-style',
		'
		.sidebar {
			order: 10;
		}

		@media screen and (max-width: 44.99875em) {
			.sidebar {
				order: inherit;
			}
		}

		.grid-container {
			max-width: 80rem;
		}
	'
	);
}

/**
 * Add Custom CSS customizer section.
 *
 * Was removed in ds-customizer.php, but used by FHNW.
 *
 * @param \WP_Customize_Manager $wp_customize customize manager object.
 *
 * @since 1.0.0
 */
function add_customizer_css_feature( $wp_customize ) {
	$wp_customize->add_section(
		'custom_css',
		array(
			'title'              => __( 'Additional CSS' ),
			'priority'           => 200,
			'description_hidden' => true,
		)
	);
}