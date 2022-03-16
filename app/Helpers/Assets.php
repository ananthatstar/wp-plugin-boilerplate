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

class Assets
{
    /**
     * Get asset url
     *
     * @param $path
     * @return string
     */
    public static function getUrl($path)
    {
        return plugin_dir_url(PREFIX_PLUGIN_FILE) . "assets/" . $path;
    }

    /**
     * Check if the file is exists or not
     *
     * @param $path
     * @return bool
     */
    public static function fileExists($path)
    {
        return file_exists(PREFIX_PLUGIN_PATH . "/assets/" . $path);
    }

    /**
     * Load minified file or not
     *
     * @return bool
     */
    public static function loadMinified()
    {
        return (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG === true) || Config::get('debug') === true;
    }

    /**
     * Enqueue style
     *
     * @param string $name
     * @param string $file
     * @param array $deps
     * @param bool $admin
     * @return void
     */
    public static function enqueueStyle($name, $file, array $deps = [], $admin = false)
    {
        $extension = ".css";
        if (self::loadMinified() && self::fileExists("css/" . $file . ".min.css")) {
            $extension = ".min.css";
        }

        $prefix = Config::get('plugin.prefix', '{prefix}_');
        $version = Config::get('plugin.version', null);

        $style_name = $prefix . $name;
        $style_url = self::getUrl("css/" . $file . $extension);

        $hook = $admin ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
        add_action($hook, function () use ($style_name, $style_url, $deps, $version) {
            wp_enqueue_style($style_name, $style_url, $deps, $version);
        });
    }

    /**
     * Enqueue admin style
     *
     * @param string $name
     * @param string $file
     * @param array $deps
     * @return void
     */
    public static function enqueueAdminStyle($name, $file, array $deps = [])
    {
        self::enqueueStyle($name, $file, $deps, true);
    }

    /**
     * Enqueue script
     *
     * @param string $name
     * @param string $file
     * @param array $deps
     * @param array $data
     * @param bool $admin
     * @return void
     */
    public static function enqueueScript($name, $file, array $deps = [], array $data = [], $admin = false)
    {
        $extension = ".js";
        if (self::loadMinified() && self::fileExists("js/" . $file . ".min.js")) {
            $extension = ".min.js";
        }

        $prefix = Config::get('plugin.prefix', '{prefix}_');
        $version = Config::get('plugin.version', null);

        $script_name = $prefix . $name;
        $script_url = self::getUrl("js/" . $file . $extension);

        $hook = $admin ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
        add_action($hook, function () use ($script_name, $script_url, $deps, $version, $data) {
            wp_enqueue_script($script_name, $script_url, $deps, $version);
            if (!empty($data)) {
                wp_localize_script($script_name, $script_name, $data);
            }
        });
    }

    /**
     * Enqueue admin script
     *
     * @param string $name
     * @param string $file
     * @param array $deps
     * @param array $data
     * @return void
     */
    public static function enqueueAdminScript($name, $file, array $deps = [], array $data = [])
    {
        self::enqueueScript($name, $file, $deps, $data, true);
    }
}