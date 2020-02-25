<?php require_once './vendor/autoload.php';

$manager = new \ProxyFetcher\Manager();
$proxies = $manager->fetch(['provider' => 'proxy-list.org']);

print_r($proxies);
