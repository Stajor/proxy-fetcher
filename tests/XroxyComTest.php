<?php

class XroxyComTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('xroxy.com');
    }
}
