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

    /**
     * Sanitize Text
     *
     * @param array|string
     * @return array|string
     */
    public static function sanitizeText($value) {
        if (is_array($value)) {
            return array_map('sanitize_text_field', $value);
        }
        return sanitize_text_field($value);
    }

    /**
     * Sanitize Title
     *
     * @param array|string
     * @return array|string
     */
    public static function sanitizeTitle($value) {
        if (is_array($value)) {
            return array_map('sanitize_title', $value);
        }
        return sanitize_title($value);
    }

    /**
     * Sanitize Long Text
     *
     * @param array|string
     * @return array|string
     */
    public static function sanitizeLongText($value) {
        if (is_array($value)) {
            return array_map('sanitize_textarea_field', $value);
        }
        return sanitize_textarea_field($value);
    }

    /**
     * Sanitize Email
     *
     * @param array|string
     * @return array|string
     */
    public static function sanitizeEmail($value) {
        if (is_array($value)) {
            return array_map('sanitize_email', $value);
        }
        return sanitize_email($value);
    }

    /**
     * HTML filter.
     *
     * @param string $value
     * @param array $allowed_html
     * @return string
     */
    public static function filterHtml($value, $allowed_html = [])
    {
        return wp_kses($value, $allowed_html);
    }
}