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

class Functions
{
    /**
     * Check version
     *
     * @param string $current
     * @param string $required
     * @return bool
     */
    public static function checkVersion($current, $required, $operator = null)
    {
        if ($required == "*") {
            return true;
        }
        if (empty($operator)) {
            $operator = preg_replace("/[^><=]+/", "", $required);
        }
        $required = rtrim(preg_replace("/[^a-z0-9.-]+/", "", $required), ".");
        return (bool) version_compare($current, $required, $operator);
    }
}