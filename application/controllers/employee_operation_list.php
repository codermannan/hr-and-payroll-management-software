<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_Operation_List extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Operation_Model');
        $this->load->model('Search_Model');
    }
    
    public function index()
    {
        
        if($this->session->userdata('username'))
        {
            $parsingData['employeeID'] = $this->uri->segment(3);
            $parsingData['employeeProductionOperation'] = $this->Search_Model->employeeProductionOperationData($parsingData['employeeID']);
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/employee_operation_list', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    
}