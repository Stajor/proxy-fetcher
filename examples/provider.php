<?php require_once './vendor/autoload.php';

$manager = new \ProxyFetcher\Manager();
$proxies = $manager->fetch(['provider' => 'httptunnel.ge']);

print_r($proxies);
