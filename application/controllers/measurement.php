<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Measurement extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('measurement');
        $parsingData['numrec'] = $this->Search_Model->numRec('measurement');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('measurement', 'measurement_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('measurement');// Passing the table name
            $this->load->view('pages/measurement', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('measurementName', 'Measurement Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('measurement');// Passing the table name
            $this->load->view('pages/measurement', $parsingData);
        }
        else
        {
            $measurementName = $this->input->post('measurementName');
            $measurementQuantity = $this->input->post('measurementQuantity');
            $insertionData = array(
                'measurement_name' => $measurementName,
                'measurement_quantity' => $measurementQuantity
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('measurement',$insertionData);//passing table size with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('measurement');// Passing the table size
                    $parsingData['successInsered'] = "Measurement Create Successfully!";
                    $this->load->view('pages/measurement', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('measurement');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/measurement', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'measurement', 'measurement_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'measurement', 'measurement_id', 'measurement_name');//passing table size and fields
                $parsingData['tableFeild1'] = 'measurement_id';
                $parsingData['tableFeild2'] = 'measurement_name';
                $parsingData['tableFeild3'] = 'measurement_quantity';
                $parsingData['controllerName'] = 'measurement';
                $this->load->view('pages/data_table_measurement', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $measurementId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['measurement_name'] = $this->Operation_Model->getTableData('measurement_name', $measurementId, 'measurement_id', 'measurement');
            $parsingData['measurement_id'] = $measurementId;
            $parsingData['measurement_quantity'] = $this->Operation_Model->getTableData('measurement_quantity', $measurementId, 'measurement_id', 'measurement');
            $this->load->view('pages/measurement', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $measurementId = $this->input->post('measurementCode');
        $measurementName = $this->input->post('measurementName');
        $measurementQuantity = $this->input->post('measurementQuantity');
        $UpdateData = array(
                'measurement_name' => $measurementName,
                'measurement_quantity' => $measurementQuantity,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('measurement_id', $measurementId, 'measurement', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Measurement Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('measurement');// Passing the table name
                $this->load->view('pages/measurement', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('measurement');// Passing the table size
                $this->load->view('pages/measurement', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $measurementId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('measurement_id', $measurementId, 'measurement');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Measurement Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('measurement');// Passing the table size
                $this->load->view('pages/measurement', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('measurement');// Passing the table size
                $this->load->view('pages/measurement', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}

