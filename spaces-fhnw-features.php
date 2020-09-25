<?php
/**
 * Plugin Name:     Spaces FHNW Features
 * Plugin URI:      https://github.com/dol-lab/spaces-fhnw-features
 * Description:     FHNW specific customizations for the Spaces install.
 * Author:          Silvan Hagen
 * Author URI:      https://silvanhagen.com
 * Text Domain:     spaces-fhnw-features
 * Domain Path:     /languages
 * Version:         1.2.0
 *
 * @package         Spaces_Fhnw_Features
 */

namespace Spaces\FHNW;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	include __DIR__ . '/vendor/autoload.php';
}

bootstrap();
