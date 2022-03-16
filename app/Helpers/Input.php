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

defined('ABSPATH') or exit;

class Input
{
    /**
     * Get inputs from request
     *
     * @param $key
     * @param string|null $method
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $method = null, $default = null)
    {
        if (is_null($method)) {
            $default = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
        } else if ($method == "post") {
            $default = isset($_POST[$key]) ? $_POST[$key] : $default;
        } else if ($method == "get") {
            $default = isset($_GET[$key]) ? $_GET[$key] : $default;
        }
        return $default;
    }
}