# PHP lib for managing proxies

## Installation

    $ composer require stajor/proxy-fetcher
    
## Usage


```php
<?php

$manager = new \ProxyFetcher\Manager();

// Filter proxies by country
$proxies = $manager->fetch(['country' => 'US']);

// Filter proxies by type
$proxies = $manager->fetch(['type' => 'SOCKS5']);

// Limit proxies results
$proxies = $manager->fetch(['limit' => 100]);
```

## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/Stajor/proxy-fetcher. This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [Contributor Covenant](http://contributor-covenant.org) code of conduct.

## License

The library is available as open source under the terms of the [MIT License](https://opensource.org/licenses/MIT).
