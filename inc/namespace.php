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
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\disable_block_editor_fullscreen', 100 );
	add_action( 'init', __NAMESPACE__ . '\restore_admin_bar', 100 );
	add_filter( 'rest_page_query', __NAMESPACE__ . '\page_attributes_fix', 10, 2 );
	/**
	 * Allow unprotected events feeds.
	 *
	 * @see https://github.com/dol-lab/spaces-partners/issues/36
	 */
	add_filter( 'spaces.more-privacy-options.allow-event-feeds', '__return_true' );
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

		.admin-bar .main-menu {
			margin-top: 32px;
		}

		@media screen and (max-width: 800px) {
			.admin-bar .main-menu {
				margin-top: 46px;
			}
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

/**
 * Disable Block Editor fullscreen mode.
 *
 * @since 1.1.0
 */
function disable_block_editor_fullscreen() {
	if ( is_admin() ) {
		$script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
		wp_add_inline_script( 'wp-blocks', $script );
	}
}

/**
 * Restore admin bar for super admins.
 *
 * @since 1.2.0
 */
function restore_admin_bar() {
	add_action( 'show_admin_bar', 'is_super_admin', 100 );
}

/**
 * Fix for https://github.com/dol-lab/spaces-partners/issues/37
 *
 * Todo: Remove once https://core.trac.wordpress.org/ticket/46294 is fixed in core.
 *
 * @param array            $args request args.
 * @param \WP_REST_Request $request current request object.
 *
 * @return array $args altered request args.
 *
 * @since 1.3.0
 */
function page_attributes_fix( $args, $request ) {
	if (
		isset( $args['orderby'] ) &&
		is_string( $args['orderby'] ) &&
		'menu_order' === $args['orderby']
	) {
		$args['orderby'] = array(
			'menu_order' => 'ASC',
			'ID'         => 'ASC',
		);
	}
	return $args;
}
