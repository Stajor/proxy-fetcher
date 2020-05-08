<?php

class GatherproxyComTest  extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('gatherproxy.com');
    }
}
