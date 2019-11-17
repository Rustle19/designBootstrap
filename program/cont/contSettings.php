<?php

/**
 * Front for member
 * @package cont
 * @author lee <lee.simplexi.com.ph>
 * @version  1.0
 * @since  2016.05.01
 */
class contSettings extends contBase {
  public function initialize() {
    $this->viewSettings();
  }

  public function viewSettings() {
    $this->setTitle('Settings');
    $this->view('navbar', ['name' => s()->get('sLoginName'), 'username' => s()->get('sLoginUsername'), 'image' => s()->get('sLoginImage')]);
    $this->view('settings');
  }

}
