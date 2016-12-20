<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        //Load all neccessary Library and Helper file
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Login_Model');
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
            $this->load->view('pages/login');
        }
    }
    
    public function submitData()
    {
        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
	
        // if not valide the input data
        if($this->form_validation->run() == FALSE) 
        {
            $this->load->view('pages/login');
        }
        else
        {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            // Check user Exist or Not
            $checkUser = $this->Login_Model->checkUser($username, $password);
            
            if($checkUser != FALSE)
            {
                $sessionDataArray = array();
                foreach($checkUser as $loginData)
                {
                    //Array contain value for session
                    $sessionDataArray = array(              
                        'userId' => $loginData->u_user_id,
                        'userType' => $loginData->u_type,
                        'userStatus' => $loginData->u_status,
                        'username' => $username
                    );
                    // Set login infor into session
                    $this->session->set_userdata($sessionDataArray); 
                }
                //Redirect to Member Home Page
                if($this->session->userdata('userStatus') == 1)
                {
                    redirect('home', 'refresh');
                }
                else 
                {
                    $errorData['errorMessage'] = "User doesn't Active Yet!";
                    $this->load->view('pages/login',$errorData);
                }
            }
            else 
            {
                $errorData['errorMessage'] = "Incorrect Username or Password!";
                $this->load->view('pages/login',$errorData);
            }
        }
    }
}
