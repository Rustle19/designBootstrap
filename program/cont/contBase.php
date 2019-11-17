<?php

/**
 * Base controller
 * @package cont
 * @author lee <lee.simplexi.com.ph>
 * @version  1.0
 * @since  2016.05.01
 */
abstract class contBase extends coreController {
  //common codes goes here
  public function afterInit() {
    $this->setMetaContent('viewport', 'width=device-width, initial-scale=1');
    $this->setMetaContent('google-signin-client_id', '264854911238-qju50l42oodadeoubial81nm4crngufs.apps.googleusercontent.com');
    $this->css('index');
    $this->js('jquery');
    $this->js('popper');
    $this->js('moment.min');
    $this->js('bootstrap.min');
    $this->externalJS('https://apis.google.com/js/platform.js');
    $this->externalJS('https://connect.facebook.net/en_US/all.js');
    $this->js('validator');
    $this->js('common');
    $this->js('oAuth');
    $this->js('event');
    $this->sessionLocation();
  }

  public function sessionLocation() {
    $oBl     = new blUser(modelUser::instance());
    $aResult = $oBl->isLogin();
    $sUrl    = $_SERVER['REQUEST_URI'];
    $aForms  = ['/', '/registration'];
    if ($aResult['bResult'] === true && in_array($sUrl, $aForms) === true) {
      echo utilJavascript::getInstance()->locationReplace('/home');
    } else if ($aResult['bResult'] === false && in_array($sUrl, $aForms) === false) {
      echo utilJavascript::getInstance()->locationReplace('/');
    }
  }
}
