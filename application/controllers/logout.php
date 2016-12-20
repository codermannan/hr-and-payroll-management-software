<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logout extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}
	public function index()
	{
		//Unset session Variable & Destroy all session
                $this->session->unset_userdata('userId');
		$this->session->unset_userdata('userType');
                $this->session->unset_userdata('userStatus');
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}
}