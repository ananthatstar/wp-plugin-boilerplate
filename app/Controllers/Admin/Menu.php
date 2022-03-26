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
    /**
     * Page slug
     *
     * @var string
     */
    protected $slug;

    /**
     * Menu constructor
     */
    public function __construct()
    {
        // set page slug
        $this->slug = $this->config()->get('plugin.slug', '{plugin_slug}');

        // add assets only for this page
        if ($this->request()->get('page') == $this->slug) {
            $this->assets()
                ->addCss('admin', 'sample')
                ->addJs('admin', 'sample')
                ->enqueue('admin');
        }

        // add admin menu page
        add_action('admin_menu', [$this, 'addMenu']);
    }

    /**
     * Add Menu
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
            [$this, 'page']
        );
    }

    /**
     * Page View
     *
     * @return void
     */
    public function page()
    {
        $data = [
            'config' => $this->config(),
            'request' => $this->request(),
        ];

        $this->view('Admin/Sample', $data);
    }
}