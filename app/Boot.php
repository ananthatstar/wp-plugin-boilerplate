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

use PREFIX\App\Controllers\Admin\Ajax;
use PREFIX\App\Controllers\Admin\Menu;
use PREFIX\App\Helpers\Plugin;

defined('ABSPATH') or exit;

class Boot
{
    /**
     * Bootstrap plugin
     */
    public function __construct()
    {
        Setup::init();
        add_action('init', [$this, 'init']);
    }

    /**
     * Init plugin
     */
    public function init()
    {
        $this->initI18n();
        if (Plugin::checkDependencies()) {
            $this->initHooks();
        }
    }

    /**
     * Init plugin hooks
     */
    public function initHooks()
    {
        new Ajax();
        if (is_admin()) {
            new Menu();
        }
    }

    /**
     * Init plugin internationalization
     */
    public function initI18n()
    {
        load_plugin_textdomain('{plugin_slug}', false, dirname(plugin_basename(PREFIX_PLUGIN_FILE)) . '/i18n/languages');
    }
}