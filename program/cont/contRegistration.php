<?php
/**
 * Front for member
 * @package cont
 * @author lee <lee.simplexi.com.ph>
 * @version  1.0
 * @since  2016.05.01
 */
class contRegistration extends contBase
{
    public function initialize()
    {
        $this->viewRegistration();
    }
    public function viewRegistration()
    {
        $this->setTemplate('default');
        $this->setTitle('Register');
        $this->view('register');
    }

}
