<?php require_once './vendor/autoload.php';

$manager = new \ProxyFetcher\Manager();
$proxies = $manager->fetch(['provider' => 'proxyfish.com']);

print_r($proxies);
