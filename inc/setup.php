<?php
//require __DIR__ . '/vendor/autoload.php';
header("Content-type:application/json"); 
require 'vendor/autoload.php';
use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'https://smecenter.tinklingd.com', 
    'ck_700ccf0c3f1acfc54a110c2bcd264541f607f744', 
    'cs_417d3c037758dfd082e644b236f40cb86bebff5f',
    [
        'wp_api' => true,
        'version' => 'wc/v2',
        'query_string_auth' => true,
		'verify_ssl' => false
    ]
);
?>