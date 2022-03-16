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

namespace PREFIX\App\Controllers\Admin;

defined('ABSPATH') or exit;

use PREFIX\App\Controllers\Core;

class Menu extends Core
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addMenu']);
    }

    /**
     * Add Admin Menu
     *
     * @since 1.0.0
     * @hook admin_menu
     *
     * @return void
     */
    public function addMenu()
    {
        add_menu_page(
            __("{plugin_name}", '{plugin_slug}'),
            __("{plugin_name}", '{plugin_slug}'),
            'update_core',
            '{plugin_slug}',
            [$this, 'menuCallback']
        );
    }

    /**
     * Menu Callback Function
     *
     * @return void
     */
    public function menuCallback()
    {
        $data = [
            'message' => "It's working!"
        ];
        self::view('Admin/Sample', $data);
    }
}