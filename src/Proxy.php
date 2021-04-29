<?php namespace ProxyFetcher;

class Proxy {
    private $ip;
    private $port;
    private $country;
    private $type;

    /**
     * @return string
     */
    public function getIp(): string {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip) {
        $this->ip = trim($ip);
    }

    /**
     * @return int
     */
    public function getPort(): int {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port) {
        $this->port = (int)$port;
    }

    /**
     * @return string
     */
    public function getCountry(): string {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country) {
        $this->country = empty($country) ? 'N/A' : trim($country);
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type) {
        $this->type = trim($type);
    }
}
