<?php
require_once('PHPUnit/Autoload.php');

class AllTests extends PHPUnit_Framework_TestSuite {

    protected function setUp() {}

    protected function tearDown() {}

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Sample');

        $directoryIterator = null;
        if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID >= 50300) {
            $directoryIterator = new RecursiveDirectoryIterator(__DIR__);
        }
        else {
            $directoryIterator = new RecursiveDirectoryIterator(dirname(__FILE__));
        }
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator);
        $filteredIterator = new RegexIterator($recursiveIterator, '/Test\.php$/');
        $arrayFiltered = iterator_to_array($filteredIterator);

        if (count($arrayFiltered) > 0)
            $suite->addTestFiles($arrayFiltered);

        /**
         * Manually add tests
         */
        //$suite->addTest(new SoapServiceUnitTest('testValidateA'));
        //$suite->addTest(new SoapServiceUnitTest('testValidateB'));
        //$suite->addTestSuite('SoapServiceUnitTest');

        return $suite;
    }
}
