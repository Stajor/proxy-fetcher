<?php

class MtproXyzTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('mtpro.xyz');
    }
}
