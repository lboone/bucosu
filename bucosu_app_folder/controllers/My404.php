<?php 
class My404 extends Authorized_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
       $this->_show_401();
    } 
} 
?> 