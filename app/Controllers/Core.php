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

namespace PREFIX\App\Controllers;

defined('ABSPATH') or exit;

class Core
{
    /**
     * View
     *
     * @param $path
     * @param $data
     * @param bool $print
     * @return false|string
     */
    public static function view($path, $data, $print = true)
    {
        $view_file = PREFIX_PLUGIN_PATH . '/app/Views/' . $path . '.php';
        if (file_exists($view_file)) {
            // Extract the variables to a local namespace
            extract($data);

            // Start output buffering
            ob_start();

            // Include the template file
            include $view_file;

            // End buffering and return its contents
            $output = ob_get_clean();

            if ($print) {
                print $output;
            }
            return $output;
        } else {
            return false;
        }
    }
}