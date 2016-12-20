<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller 
{
    private $pagesize = 10;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('form');
        $this->load->model('Employee_Model');
        $this->load->model('Setup_Model');
        $this->load->library('form_validation');
    }
}