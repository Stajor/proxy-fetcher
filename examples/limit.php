<?php require_once './vendor/autoload.php';

$manager = new \ProxyFetcher\Manager();
$proxies = $manager->fetch(['limit' => 100]);

print_r($proxies);
