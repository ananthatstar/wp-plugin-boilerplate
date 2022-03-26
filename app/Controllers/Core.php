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

use PREFIX\App\Config;
use PREFIX\App\Helpers\Assets;
use PREFIX\App\Helpers\Input;
use PREFIX\App\Helpers\Request;

class Core
{
    /**
     * Plugin assets instance
     *
     * @var object
     */
    public $assets;

    /**
     * Plugin config instance
     *
     * @var object
     */
    public $config;

    /**
     * Input instance
     *
     * @var object
     */
    public $input;

    /**
     * Request instance
     *
     * @var object
     */
    public $request;

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
            ob_start();
                extract($data);
                include $view_file;
            $output = ob_get_clean();

            if ($print) {
                echo $output;
            }
            return $output;
        } else {
            return false;
        }
    }

    /**
     * Return assets instance
     *
     * @return object
     */
    public function assets() {
        return isset($this->assets) ? $this->assets : new Assets();
    }

    /**
     * Return config instance
     *
     * @return object
     */
    public function config() {
        return isset($this->config) ? $this->config : new Config();
    }

    /**
     * Return input instance
     *
     * @return object
     */
    public function input() {
        return isset($this->input) ? $this->input : new Input();
    }

    /**
     * Return request instance
     *
     * @return object
     */
    public function request() {
        return isset($this->request) ? $this->request : new Request();
    }
}