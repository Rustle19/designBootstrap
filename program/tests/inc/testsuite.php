<?php
/**
 * 테스트 집합
 *
 * @package tests
 * @author  Platform Team
 */

class TSA_TestSuite extends PHPUnit_Framework_TestSuite
{
    public function addTestSuite($testClass)
    {
        return parent::addTestSuite('TU_case_' . $testClass);
    }
}