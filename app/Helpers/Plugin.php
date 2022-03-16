<?php
/**
 * {plugin_name}
 *
 * @package   {plugin_slug}
 * @author    {author_name} <{author_email}>
 * @copyright {author_copyright}
 * @license   {author_license}
 * @link      {author_url}
 */

namespace PREFIX\App\Helpers;

use PREFIX\App\Config;

defined('ABSPATH') or exit;

class Plugin
{
    /**
     * Check dependencies
     *
     * @param bool $die
     * @return bool
     */
    public static function checkDependencies($die = false)
    {
        global $wp_version;

        $php_version = Config::get('require.php', '*');
        if (!Functions::checkVersion(PHP_VERSION, $php_version)) {
            $message = sprintf(__('{plugin_name} requires PHP version %s', '{plugin_slug}'), $php_version);
            $die ? die($message) : WP::adminNotice($message, 'error');
            return false;
        }

        $wordpress_version = Config::get('require.wordpress', '*');
        if (!Functions::checkVersion($wp_version, $wordpress_version)) {
            $message = sprintf(__('{plugin_name} requires WordPress version %s', '{plugin_slug}'), $wordpress_version);
            $die ? die($message) : WP::adminNotice($message, 'error');
            return false;
        }

        $plugins = Config::get('require.plugins', []);
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins', []));
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', []));
        }
        foreach ($plugins as $plugin) {
            if (!isset($plugin['name']) || !isset($plugin['path'])) {
                continue;
            }
            $plugin_name = isset($plugin['url']) ? '<a href="' . $plugin['url'] . '" target="_blank">' . $plugin['name'] . '</a>' : $plugin['name'];
            if (!in_array($plugin['path'], $active_plugins, false) && !array_key_exists($plugin['path'], $active_plugins)) {
                $message = sprintf(__('{plugin_name} requires %s plugin to be installed and active', '{plugin_slug}'), $plugin_name);
                $die ? die($message) : WP::adminNotice($message, 'error');
                return false;
            }

            $plugin_path = ABSPATH . 'wp-content/plugins/' . $plugin['path'];
            if (!file_exists($plugin_path)) {
                continue;
            }
            $plugin_data = get_plugin_data($plugin_path);
            $plugin_version = isset($plugin_data['Version']) ? $plugin_data['Version'] : '*';
            if (isset($plugin['version']) && !Functions::checkVersion($plugin_version, $plugin['version'])) {
                $message = sprintf(__('{plugin_name} requires %s version %s', '{plugin_slug}'), $plugin_name, $plugin['version']);
                $die ? die($message) : WP::adminNotice($message, 'error');
                return false;
            }
        }
        return true;
    }
}