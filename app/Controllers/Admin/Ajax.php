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

class Ajax extends Core
{
    public function __construct()
    {
        $events = [
            'test',
        ];

        foreach ($events as $event) {
            add_action('wp_ajax_{prefix}_' . $event, array(__CLASS__, $event));
        }
    }

    /**
     * Ajax Test
     */
    public static function test()
    {
        wp_send_json_success();
    }
}