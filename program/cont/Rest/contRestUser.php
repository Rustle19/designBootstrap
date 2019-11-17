<?php

/**
 * Rest for user
 * @package rest
 * @author russell <russell@simplexi.com.ph>
 * @version  1.0
 * @since  2019.11.05
 */
class contRestUser extends contBase
{
    public function afterInit()
    {
        $this->setTemplate(null);
        $this->setContentType('json');
    }

    //login
    public function login()
    {
        //rest/user/login?username=russell&password=sads
        $sUsername = r()->getParam('username');
        $sPassword = r()->getParam('password');
        //will only have value if you logged in using google or facebook
        $sName = r()->getParam('name');
        $sType = r()->getParam('type');
        $sImage = r()->getParam('image');
        $sAppId = r()->getParam('app_id');
        $oModel = new blUser(modelUser::instance());
        $oResult = $oModel->doLogin(['username' => $sUsername, 'pw' => $sPassword, 'name' => $sName, 'type' => $sType, 'image' => $sImage, 'app_id' => $sAppId]);
        echo json_encode($oResult);
    }

    //create member
    public function register()
    {
        //rest/user/register?username=russell&name=asds&password=12345678&confirmPassword=12345678&image=wat&app_id=sadss
        $sUserName = r()->getParam('username');
        $sName = r()->getParam('name');
        $sPassword = r()->getParam('password');
        $sConfirmPassword = r()->getParam('confirmPassword');
        $sAppId = r()->getParam('app_id');
        $sImage = r()->getParam('image');
        $oModel = new blUser(modelUser::instance());
        $oResult = $oModel->createUser(['username' => $sUserName, 'name' => $sName, 'pw' => $sPassword, 'confirmPw' => $sConfirmPassword, 'app_id' => $sAppId, 'image' => $sImage]);
        echo json_encode($oResult);
    }

    public function checkUsername()
    {
        //rest/user/checkUsername?username=asd
        $sUserName = r()->getParam('username');
        $oModel = new blUser(modelUser::instance());
        $oResult = $oModel->checkUsername($sUserName);
        echo json_encode($oResult);
    }

    public function logout()
    {
        //rest/user/logout
        $oModel = new blUser(modelUser::instance());
        $oResult = $oModel->doLogout();
        echo json_encode($oResult);
    }
}
