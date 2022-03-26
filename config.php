<?php
return [
    'debug' => false,

    'plugin' => [
        'name' => "{plugin_name}",
        'slug' => "{plugin_slug}",
        'version' => "{plugin_version}",
        'prefix' => "{prefix}_",
    ],

    'require' => [
        'php' => ">=5.6",
        'wordpress' => ">=5.2",
        'plugins' => [
            [
                'name' => "WooCommerce",
                'version' => ">=3.0",
                'file' => "woocommerce/woocommerce.php",
                'url' => "https://woocommerce.com",
            ],
        ],
    ],
];