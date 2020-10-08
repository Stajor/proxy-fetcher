<?php

class ProxypediaOrgTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('proxypedia.org');
    }
}
