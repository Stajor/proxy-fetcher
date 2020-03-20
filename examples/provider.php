<?php require_once './vendor/autoload.php';

$manager = new \ProxyFetcher\Manager();
$proxies = $manager->fetch(['provider' => 'proxyrack.com']);

print_r($proxies);
