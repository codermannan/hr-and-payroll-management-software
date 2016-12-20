<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holiday extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('holiday');
        $parsingData['numrec'] = $this->Search_Model->numRec('holiday');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('holiday', 'holiday_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('holiday');// Passing the table name
            $this->load->view('pages/holiday', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('holidayName', 'Holiday Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('holidayFrom', 'Holiday From', 'trim|required|xss_clean');
        $this->form_validation->set_rules('holidayTo', 'Holiday To', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('holiday');// Passing the table name
            $this->load->view('pages/holiday', $parsingData);
        }
        else
        {
            $holidayName = $this->input->post('holidayName');
            $holidayFrom = $this->input->post('holidayFrom');
            $holidayTo = $this->input->post('holidayTo');
            
            $insertionData = array(
                'holiday_name' => $holidayName,
                'holiday_from' => $holidayFrom,
                'holiday_to' => $holidayTo
                
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('holiday',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('holiday');// Passing the table name
                    $parsingData['successInsered'] = "Holiday Create Successfully!";
                    $this->load->view('pages/holiday', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('holiday');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/holiday', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'holiday', 'holiday_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page($vDescp, 'holiday', 'holiday_id', 'holiday_name', 'holiday_from', 'holiday_to');//passing table name and fields
                $parsingData['tableFeild1'] = 'holiday_id';
                $parsingData['tableFeild2'] = 'holiday_name';
                $parsingData['tableFeild3'] = 'holiday_from';
                $parsingData['tableFeild4'] = 'holiday_to';
                $parsingData['controllerName'] = 'holiday';
                $this->load->view('pages/data_table_holiday', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $holidayId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['holiday_name'] = $this->Operation_Model->getTableData('holiday_name', $holidayId, 'holiday_id', 'holiday');
            $parsingData['holiday_from'] = $this->Operation_Model->getTableData('holiday_from', $holidayId, 'holiday_id', 'holiday');
            $parsingData['holiday_to'] = $this->Operation_Model->getTableData('holiday_to', $holidayId, 'holiday_id', 'holiday');
            $parsingData['holiday_id'] = $holidayId;
            $this->load->view('pages/holiday', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $holidayId = $this->input->post('holidayId');
       
        $holidayName = $this->input->post('holidayName');
        $holidayFrom = $this->input->post('holidayFrom');
        $holidayTo = $this->input->post('holidayTo');
        $UpdateData = array(
                'holiday_name' => $holidayName,
                'holiday_from' => $holidayFrom,
                'holiday_to' => $holidayTo,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('holiday_id', $holidayId, 'holiday', $UpdateData);
        
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Holiday Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('holiday');// Passing the table name
                $this->load->view('pages/holiday', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('holiday');// Passing the table name
                $this->load->view('pages/holiday', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $holidayId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('holiday_id', $holidayId, 'holiday');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Holiday Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('holiday');// Passing the table name
                $this->load->view('pages/holiday', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('holiday');// Passing the table name
                $this->load->view('pages/holiday', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
