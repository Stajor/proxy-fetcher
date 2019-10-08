<?php require_once './vendor/autoload.php';

$manager = new \ProxyFetcher\Manager();
$proxies = $manager->fetch(['country' => 'BR']);

print_r($proxies);
