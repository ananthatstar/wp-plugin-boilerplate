<?php
/**
 * {plugin_name}
 *
 * @package           {plugin_slug}
 * @author            {author_name} <{author_email}>
 * @copyright         {author_copyright}
 * @license           {author_license}
 * @link              {author_url}
 *
 * @wordpress-plugin
 * Plugin Name:       {plugin_name}
 * Plugin URI:        {plugin_url}
 * Description:       {plugin_description}
 * Version:           {plugin_version}
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            {author_name}
 * Author URI:        {author_url}
 * Text Domain:       {plugin_slug}
 * Domain Path:       /i18n/languages
 * License:           {plugin_license}
 * License URI:       {plugin_license_url}
 */

defined('ABSPATH') or exit;

defined('PREFIX_PLUGIN_FILE') or define('PREFIX_PLUGIN_FILE', __FILE__);
defined('PREFIX_PLUGIN_PATH') or define('PREFIX_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Load PSR4 autoloader
 *
 * @since 1.0.0
 */
require PREFIX_PLUGIN_PATH . '/vendor/autoload.php';

if (class_exists('PREFIX\App\Boot')) {
    new PREFIX\App\Boot(); // start plugin
} else {
    wp_die(__('{plugin_name} is unable to find the Boot class.', '{plugin_slug}'));
}
