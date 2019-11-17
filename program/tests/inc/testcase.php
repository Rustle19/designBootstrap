<?php

/**
 * 테스트 케이스를 작성하기 위하여 상속 받아야하는 기본 상위 클래스입니다.
 *
 * @package tests
 * @author  Platform Team
 */
class TSA_TestCase extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $mockSession = new TSA_mockup_session(); // Session Mockup 변경하기
        $this->getPrivateProperty("Session", 'instance')->setValue(null, $mockSession);
    }

    /**
     * 보호된 메서드 얻어오기
     * getPrivateProperty
     *
     * @param
     *            $sContName
     * @param
     *            $sMethodName
     *            
     * @return \ReflectionMethod
     */
    public function getPrivateMethod($sContName, $sMethodName)
    {
        $oRef = new ReflectionClass($sContName);
        $oMethod = $oRef->getMethod($sMethodName);
        $oMethod->setAccessible(true);
        
        return $oMethod;
    }

    /**
     * 보호댄 속성 얻어오기
     * getPrivateProperty
     *
     * @param
     *            $sContName
     * @param
     *            $propertyName
     *            
     * @return \ReflectionProperty
     */
    public function getPrivateProperty($sContName, $propertyName)
    {
        $oRef = new ReflectionClass($sContName);
        $oProperty = $oRef->getProperty($propertyName);
        $oProperty->setAccessible(true);
        
        return $oProperty;
    }

    /**
     * Mock 빌더 오브젝트 얻어오기
     *
     * @param
     *            $sContName
     *            
     * @return \PHPUnit_Framework_MockObject_MockBuilder
     * @internal param $sController
     */
    public function mockBuilder($sClassName)
    {
        // disableOriginalConstructor 기본생성자 비활성하기
        return $this->getMockBuilder($sClassName)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        $this->getPrivateProperty('Session', 'instance')->setValue(null, null);
    }

    /**
     * 모델 키 얻어오기
     *
     * @param
     *            $sClassName
     *            
     * @return string
     */
    private function _getModelKey($sClassName)
    {
        if (strstr($sClassName, 'modelCs')) {
            $sDatabase = 'global_cs';
        }
        
        return $sClassName . serialize(getDsn($sDatabase));
    }

    /**
     * 디비의 목 오브젝트를 바인딩합니다.
     *
     * @param
     *            $sClassName
     * @param null $oMockObject            
     *
     * @return bool
     */
    protected function invokeModel($sClassName, $oMockObject = null)
    {
        if (empty($sClassName) === true) {
            return false;
        }
        $sInstanceKey = $this->_getModelKey($sClassName);
        $this->getPrivateProperty('Model', 'aModel')->setValue(null, array(
            $sInstanceKey => $oMockObject
        ));
        return true;
    }

    public static function tearDownAfterClass()
    {}

    /**
     * xml 파일에 정의돼는 기본 변수값입니다.
     *
     * @param
     *            $sValue
     * @param string $sKey            
     */
    protected function setResultValue($sValue, $sKey = 'default')
    {
        $GLOBALS['result_value'][$sKey] = $sValue;
    }

    protected function getResultValue($sKey = 'default')
    {
        return $GLOBALS['result_value'][$sKey];
    }
}
