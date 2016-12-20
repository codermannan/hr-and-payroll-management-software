<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
    }
    
    public function index()
    {
        
        if($this->session->userdata('username'))
        {
            $username['username'] = $this->session->userdata('username');
            $this->load->view('pages/home', $username);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
}
