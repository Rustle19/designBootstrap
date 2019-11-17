<?php

/**
 * Front for member
 * @package cont
 * @author lee <lee.simplexi.com.ph>
 * @version  1.0
 * @since  2016.05.01
 */
class contHome extends contBase {
  public function initialize() {
    $this->viewHomepage();
  }

  public function viewHomepage() {
    $this->setTitle('Home');
    $this->view('navbar', ['name' => s()->get('sLoginName'), 'username' => s()->get('sLoginUsername'), 'image' => s()->get('sLoginImage')]);
    $this->view('homepage');
  }

}
