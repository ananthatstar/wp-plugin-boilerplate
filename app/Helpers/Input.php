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

use Valitron\Validator;

class Input
{
    /**
     * Sanitize Array (recursively)
     *
     * @param array $array
     * @param string $callback
     * @return array
     */
    public static function sanitizeArray(&$array, $callback = 'sanitize_text_field')
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = self::sanitizeArray($value, $callback);
            } else {
                $value = call_user_func($callback, $value);
            }
        }
        return $array;
    }

    /**
     * Sanitize Text
     *
     * @param array|string
     * @return array|string
     */
    public static function sanitizeText($value) {
        if (is_array($value)) {
            return self::sanitizeArray($value, 'sanitize_text_field');
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
            return self::sanitizeArray($value, 'sanitize_title');
        }
        return sanitize_title($value);
    }

    /**
     * Sanitize Long Text (textarea)
     *
     * @param array|string
     * @return array|string
     */
    public static function sanitizeLongText($value) {
        if (is_array($value)) {
            return self::sanitizeArray($value, 'sanitize_textarea_field');
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
            return self::sanitizeArray($value, 'sanitize_email');
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

    /**
     * Validator (vlucas/valitron)
     *
     * @link https://github.com/vlucas/valitron
     *
     * @param $data
     * @return Validator
     */
    public static function validator($data)
    {
        return new Validator($data);
    }
}