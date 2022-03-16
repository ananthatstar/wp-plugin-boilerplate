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

namespace PREFIX\App;

defined('ABSPATH') or exit;

class Config
{
    /**
     * Get config
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    public static function get($key = null, $default = false)
    {
        $config = require PREFIX_PLUGIN_PATH . '/config.php';
        if (is_null($key)) {
            return $config;
        } else if (strpos($key, '.') !== false) {
            foreach (explode('.', $key) as $index) {
                if (!is_array($config) || !array_key_exists($index, $config)) {
                    return $default;
                }
                $config = &$config[$index];
            }
            return $config;
        } else {
            if (array_key_exists($key, $config)) {
                return $config[$key];
            } else {
                $key = self::get('plugin.prefix', '{prefix}_') . $key;
                return get_option($key, $default);
            }
        }
    }

    /**
     * Set config
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value)
    {
        $key = self::get('plugin.prefix', '{prefix}_') . $key;
        return update_option($key, $value);
    }
}