<?php namespace ProxyFetcher\Providers;

interface ProviderInterface {
    public function fetch(): array;
}
