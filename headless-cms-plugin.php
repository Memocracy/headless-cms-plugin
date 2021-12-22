<?php

/**
 * The plugin bootstrap file.
 *
 * @link              https://github.com/fedek6/wp-modern-plugin-boilerplate
 * @since             1.0.0
 * @package           wp_modern_plugin_boilerplate
 *
 * @wordpress-plugin
 * Plugin Name:       Memocracy
 * Plugin URI:        https://github.com/Memocracy/headless-cms-plugin
 * Requires PHP:      7.4
 * Requires at least: 5.2
 * Tested up to:      5.2
 * Description:       Additional code for headles cms.
 * Version:           1.0.0
 * Author:            {author}
 * Author URI:        http://realhe.ro
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-modern-plugin-boilerplate
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Composer.
 */
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * Bootstrap plugin.
 */

/** @var string $assetsUrl */
$assetsUrl = plugin_dir_url(__FILE__) . 'assets';

/** @var string $pluginName */
$pluginName = 'WpMPB';

$plugin = new \RealHero\Memocracy\Bootstrap($pluginName, $assetsUrl, __DIR__, '1.0.0');

// Add components.
$plugin->registerComponent('frontendAssets', '\RealHero\Memocracy\Components\FrontendAssets');
$plugin->registerComponent('adminAssets', '\RealHero\Memocracy\Components\AdminAssets');
$plugin->registerComponent('i18n', '\RealHero\Memocracy\Components\I18n');

// Plugin lifecycle.
register_activation_hook( __FILE__, ['\RealHero\Memocracy\AbstractActivation', 'run']);
register_deactivation_hook( __FILE__, ['\RealHero\Memocracy\AbstractDeactivation', 'run']);

$plugin->run();
