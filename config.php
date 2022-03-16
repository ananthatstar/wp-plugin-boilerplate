<?php
return [
    'debug' => false,

    'plugin' => [
        'name' => "{plugin_name}",
        'version' => "{plugin_version}",
        'prefix' => "{prefix}_",
        'textdomain' => "{plugin_slug}",
    ],

    'require' => [
        'php' => ">=5.6",
        'wordpress' => ">=5.2",
        'plugins' => [
            [
                'name' => "WooCommerce",
                'version' => ">=3.0",
                'url' => "https://woocommerce.com",
                'path' => "woocommerce/woocommerce.php",
            ],
        ],
    ],
];