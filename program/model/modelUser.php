<?php

/**
 * modelUser
 * @package model
 * @author  russell <russell@simplexi.com.ph>
 * @version  1.0
 * @since 2019.11.05
 */
class modelUser extends modelCommon {
  /**
   * instance
   * @return object model instance
   */
  public static function instance() {
    return parent::_load(__CLASS__);
  }

  /**
   * @param array $aParams array('username' => 'username here','name' => 'name here', 'pw' => 'password here')
   * @return integer id
   * @throws exceptionActiverecord
   */
  public function addUser($aParams) {
    // return $iSequence;0

    $aData  = ['username' => $aParams['username'], 'name' => $aParams['name'], 'password' => $aParams['pw'], 'image' => $aParams['image'], 'app_id' => $aParams['app_id']];
    $sQuery = $this->helper->insert('t_user', $aData);

    $this->query($sQuery);
    $iId = $this->lastInsertId();

    return $iId;
  }

  /**
   * @param string $sUserName user username
   * @return array array('id' => ' id here', 'username' => 'username here','name' => 'name here', 'password' => 'password here','image'=> image.here)
   */

  public function readByColumn($sUserName, $sColumn) {
    $this->helper->select(' * ');
    $this->helper->from('t_user');
    $sQuery = $this->helper->where($sColumn, $sUserName);
    $sQuery = $this->helper->get();

    return $this->query($sQuery, FW_MODEL_RESULT_ROW);
  }

}