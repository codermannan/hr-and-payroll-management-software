<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave extends CI_Controller 
{
    private $pagesize = 20;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Operation_Model');
        $this->load->model('Search_Model');
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        $this->Search_Model->limit = 20;
        $this->Search_Model->Mostlimit = 1;
        $this->Search_Model->offset = $this->uri->segment(3);
        $parsingData['query'] = $this->Search_Model->listOfData('evacuate');
        $parsingData['numrec'] = $this->Search_Model->numRec('evacuate');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('evacuate', 'leave_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('evacuate');// Passing the table name
            $this->load->view('pages/leave', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('leaveType', 'Currency Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('leaveShortName', 'Currency Code', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('evacuate');// Passing the table name
            $this->load->view('pages/leave', $parsingData);
        }
        else
        {
            $leaveType = $this->input->post('leaveType');
            $leaveShortName = $this->input->post('leaveShortName');
            
            $insertionData = array(
                'leave_short_code' => $leaveShortName,
                'leave_type' => $leaveType
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('evacuate', $insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('evacuate');// Passing the table name
                    $parsingData['successInsered'] = "Leave Create Successfully!";
                    $this->load->view('pages/leave', $parsingData);
                }
                else 
                {
                    redirect('login', 'refresh');
                }
            }
            else 
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('evacuate');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/leave', $parsingData);
                }
                else 
                {
                    redirect('login', 'refresh');
                }
            }
        }
    }
    
    function searchData()
    {

        if($this->session->userdata('username'))
        {
                if (isset($_POST['descp_msg']) && $_POST['descp_msg'] != NULL) 
                    $vDescp = $_POST['descp_msg'];
                else
                    $vDescp = '';

                if (isset($_POST['pageNumber']) && $_POST['pageNumber'] != NULL) 
                    $idoffset = $_POST['pageNumber'] - 1;
                else
                    $idoffset=0;

                $this->Search_Model->limit =  $this->pagesize;
                $this->Search_Model->offset = $idoffset *  $this->pagesize;
                $parsingData['offset'] = $this->Search_Model->offset;
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'evacuate', 'leave_type');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page($vDescp, 'evacuate', 'leave_id', 'leave_type', 'leave_short_code');//passing table name and fields
                $parsingData['tableFeild1'] = 'leave_id';
                $parsingData['tableFeild2'] = 'leave_type';
                $parsingData['tableFeild3'] = 'leave_short_code';
                $parsingData['controllerName'] = 'leave';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $leaveId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['leave_type'] = $this->Operation_Model->getTableData('leave_type', $leaveId, 'leave_id', 'evacuate');
            $parsingData['leave_short_code'] = $this->Operation_Model->getTableData('leave_short_code', $leaveId, 'leave_id', 'evacuate');
            $parsingData['leave_id'] = $leaveId;
            $this->load->view('pages/leave', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $leaveId = $this->input->post('leaveId');
       
        $leaveType = $this->input->post('leaveType');
        $leaveShortName = $this->input->post('leaveShortName');
        $UpdateData = array(
                'leave_type' => $leaveType,
                'leave_short_code' => $leaveShortName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('leave_id', $leaveId, 'evacuate', $UpdateData);
        
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Leave Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('evacuate');// Passing the table name
                $this->load->view('pages/leave', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
        else 
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('evacuate');// Passing the table name
                $this->load->view('pages/leave', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $leaveId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('leave_id', $leaveId, 'evacuate');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Leave Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('evacuate');// Passing the table name
                $this->load->view('pages/leave', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
        else 
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Deletion!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('evacuate');// Passing the table name
                $this->load->view('pages/leave', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
