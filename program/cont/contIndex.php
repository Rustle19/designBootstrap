<?php

/**
 * index controller
 * @package controller
 * @author
 * @version  1.0
 * @since 2017.05.09
 */
class contIndex extends contBase {
  /**
   * index page
   */
  public function index() {
    $this->setTemplate('default');
    $this->setTitle('Login');
    $this->view('login');
  }
}
