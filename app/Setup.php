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

use PREFIX\App\Helpers\Plugin;

defined('ABSPATH') or exit;

class Setup
{
    /**
     * Init setup
     */
    public static function init() {
        register_activation_hook(PREFIX_PLUGIN_FILE, [__CLASS__, 'activate']);
        register_deactivation_hook(PREFIX_PLUGIN_FILE, [__CLASS__, 'deactivate']);
        register_uninstall_hook(PREFIX_PLUGIN_FILE, [__CLASS__, 'uninstall']);
    }

    /**
     * Run plugin activation scripts
     */
    public static function activate()
    {
        Plugin::checkDependencies(true);
    }

    /**
     * Run plugin activation scripts
     */
    public static function deactivate()
    {
        // silence is golden
    }

    /**
     * Run plugin activation scripts
     */
    public static function uninstall()
    {
        // silence is golden
    }
}