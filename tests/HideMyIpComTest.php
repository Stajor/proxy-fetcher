<?php

class HideMyIpComTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('hide-my-ip.com');
    }
}
