<?php

/**
 * blUser
 * @package bl
 * @author russell <russell@simplexi.com.ph>
 * @version  1.0
 * @since  2019.11.05
 */
class blUser extends blBase {
  /**
   * user model instance
   * @var object
   */
  private $oUserModel;
  /**
   * groupware library instance
   * @var object
   */
  private $oGroupwareLib;
  /**
   * string generator library instance
   * @var object
   */
  private $oStringGenerator;
  /**
   * validation library instance
   * @var object
   */
  private $oValidate;

  /**
   * __construct
   * @param object $oUserModel
   */
  public function __construct($oUserModel) {
    $this->oUserModel       = $oUserModel;
    $this->oGroupwareLib    = new libGroupware();
    $this->oStringGenerator = new libRandom();
    $this->oValidate        = new libValidation();
  }

  /**
   * @param $aUser
   */
  public function doLogin($aUser) {
    // $bIsGroupware = $aUser['type'] === 'GroupwareLogin';
    // $bIsLogin     = $aUser['type'] === 'Login';
    // //read app_id instead of username if you are logging to facebook or google
    $sColumn = ($aUser['type'] === 'Google' || $aUser['type'] === 'Facebook') ? 'app_id' : 'username';
    $aDBUser = $this->oUserModel->readByColumn($aUser[$sColumn], $sColumn);
    // $bCheckPassword = $this->oGroupwareLib->login($aUser['username'], $aUser['pw']);
    // $bUsernameExist = ($bIsGroupware) ? $this->oGroupwareLib->getSelEmpList($aUser['username']) : $aDBUser;
    // $bPasswordMatch = ($bIsGroupware) ? $bCheckPassword['data'][0]['userflag'] : $aDBUser['password'] === $aUser['pw'];

    // if ($bUsernameExist === '' || ($bIsLogin === true && $bUsernameExist === false)) {
    //   $sMsg = ($bIsGroupware) ? 'Groupware user does not exists' : 'Uh oh ! It seems like username is not registered yet';

    //   return ['bResult' => false, 'sMsg' => $sMsg];
    // } else if ($bPasswordMatch === 'false' || ($bIsLogin === true && $bPasswordMatch === false)) {
    //   $sMsg = ($bIsGroupware) ? 'Groupware password is incorrect ' : 'Password is incorrect';

    //   return ['bResult' => false, 'sMsg' => $sMsg];
    // }
    $aUser['image']    = $aUser['image'] ?? '/img/default-avatar.jpg';
    $aUser['name']     = $aUser['name'] ?? $aDBUser['name'];
    $aUser['username'] = $aUser['username'] ?? (($aDBUser === false) ? $oGroupware = $this->oStringGenerator->generate(20) : $aDBUser['username']);
    // (($bIsGroupware === true) ? $this->oGroupwareLib->getSelEmpList($aUser['username'])['name'] : $aDBUser['name'])
    //(($aDBUser === false) ? $oGroupware = $this->oStringGenerator->generate(20) : $aDBUser['username'])
    $iId = ($aDBUser === false) ? $this->oUserModel->addUser($aUser) : $aDBUser['id'];

    s()->set('sLoginUsername', $aUser['username']);
    s()->set('sLoginName', $aUser['name']);
    s()->set('sLoginImage', $aUser['image']);
    s()->set('sLoginId', $iId);

    return ['bResult' => true, 'sMsg' => 'Successfully logged in'];
  }

  public function isLogin() {
    if (empty(s()->get('sLoginUsername')) === false) {
      return ['bResult' => true, 'sUsername' => s()->get('sLoginUsername')];
    }

    return ['bResult' => false];
  }

  /**
   * @param $aUser
   */
  public function createUser($aUser) {
    $bFormat        = $this->oValidate->validateFormat(['user' => $aUser, 'sType' => 'register']);
    $bCheckUserName = $this->checkUsername($aUser['username']);
    if ($bFormat['bErrorExist'] === false && $bCheckUserName['bResult'] === true) {
      $this->oUserModel->addUser($aUser);

      return ['bResult' => true, 'sMsg' => 'You successfully created an account'];
    }

    $sMsg = ($bCheckUserName['bResult'] === false) ? $bCheckUserName['sMsg'] : $bFormat;

    return ['bResult' => false, 'sMsg' => $sMsg];
  }

  /**
   * @param $sUsername
   */
  public function readByUsername($sUsername) {

    return ['bResult' => true, 'user' => $this->oUserModel->readByColumn($sUsername, 'username')];
  }

  //return true if username does not exist in db  and groupware
  /**
   * @param $sUserName
   */
  public function checkUsername($sUserName) {
    if ($this->oUserModel->readByColumn($sUserName, 'username') === false && $this->oGroupwareLib->getSelEmpList($sUserName) === '') {
      return ['bResult' => true];
    }

    return ['bResult' => false, 'sMsg' => 'Username already exists. Please choose another username'];

  }

  public function doLogout() {
    s()->destruct();

    return ['sMsg' => 'Logged Out Successfully'];
  }
}
