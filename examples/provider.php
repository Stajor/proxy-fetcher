<?php require_once './vendor/autoload.php';

$manager = new \ProxyFetcher\Manager();
$proxies = $manager->fetch(['provider' => 'xroxy.com']);

print_r($proxies);
