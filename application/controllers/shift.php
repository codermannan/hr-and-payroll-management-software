<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shift extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('shift');
        $parsingData['numrec'] = $this->Search_Model->numRec('shift');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('shift', 'shift_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('shift');// Passing the table name
            $this->load->view('pages/shift', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('shiftCode', 'ShiftSize', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('shift');// Passing the table name
            $this->load->view('pages/shift', $parsingData);
        }
        else
        {
            $shiftCode = $this->input->post('shiftCode');
            
            $insertionData = array(
                'shift_code' => $shiftCode
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('shift',$insertionData);//passing table size with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('shift');// Passing the table size
                    $parsingData['successInsered'] = "Shift Create Successfully!";
                    $this->load->view('pages/shift', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('shift');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/shift', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'shift', 'shift_code');//passing table size and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'shift', 'shift_id', 'shift_code');//passing table size and fields
                $parsingData['tableFeild1'] = 'shift_id';
                $parsingData['tableFeild2'] = 'shift_code';
                $parsingData['controllerName'] = 'shift';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $shiftId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['shift_code'] = $this->Operation_Model->getTableData('shift_code', $shiftId, 'shift_id', 'shift');
            $parsingData['shift_id'] = $shiftId;
            $this->load->view('pages/shift', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $shiftId = $this->input->post('shiftId');
        $shiftCode = $this->input->post('shiftCode');
        $UpdateData = array(
                'shift_code' => $shiftCode,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('shift_id', $shiftId, 'shift', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Shift Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('shift');// Passing the table name
                $this->load->view('pages/shift', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('shift');// Passing the table size
                $this->load->view('pages/shift', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $shiftId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('shift_id', $shiftId, 'shift');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Shift Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('shift');// Passing the table size
                $this->load->view('pages/shift', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('shift');// Passing the table size
                $this->load->view('pages/shift', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}

