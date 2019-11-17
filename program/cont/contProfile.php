<?php

/**
 * Front for member
 * @package cont
 * @author lee <lee.simplexi.com.ph>
 * @version  1.0
 * @since  2016.05.01
 */
class contProfile extends contBase {
  public function initialize() {
    $this->viewProfile();
  }

  public function viewProfile() {
    $this->setTitle('Profile');
    $this->view('navbar', ['name' => s()->get('sLoginName'), 'username' => s()->get('sLoginUsername'), 'image' => s()->get('sLoginImage')]);
    $this->view('profile');
  }

}
