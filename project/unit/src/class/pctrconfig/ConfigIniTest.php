<?php

use PHPUnit\Framework\TestCase;

define("RACINE_UNIT", dirname(__FILE__) . "/../../..");
require_once(RACINE_UNIT . '/config_path.php');
require_once(RACINE_UNIT . '/function_test.php');
require_once(RACINE_WWW . '/src/class/pctrconfig/ConfigIni.php');

/**
 * ClassNameTest
 * @group group
 */
class ConfigIniTest extends TestCase
{
    /**
     * @var Create_folder
     */
    protected ConfigIni|null $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->assertTrue(true);
    }

}