<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guage extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('guage');
        $parsingData['numrec'] = $this->Search_Model->numRec('guage');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('guage', 'guage_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('guage');// Passing the table name
            $this->load->view('pages/guage', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('guageSize', 'GaugeSize', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('guage');// Passing the table name
            $this->load->view('pages/guage', $parsingData);
        }
        else
        {
            $guageSize = $this->input->post('guageSize');
            
            $insertionData = array(
                'guage_size' => $guageSize
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('guage',$insertionData);//passing table size with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('guage');// Passing the table size
                    $parsingData['successInsered'] = "Gauge Create Successfully!";
                    $this->load->view('pages/guage', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('guage');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/guage', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'guage', 'guage_size');//passing table size and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'guage', 'guage_id', 'guage_size');//passing table size and fields
                $parsingData['tableFeild1'] = 'guage_id';
                $parsingData['tableFeild2'] = 'guage_size';
                $parsingData['controllerName'] = 'guage';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $guageId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['guage_size'] = $this->Operation_Model->getTableData('guage_size', $guageId, 'guage_id', 'guage');
            $parsingData['guage_id'] = $guageId;
            $this->load->view('pages/guage', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $guageId = $this->input->post('guageCode');
        $guageSize = $this->input->post('guageSize');
        $UpdateData = array(
                'guage_size' => $guageSize,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('guage_id', $guageId, 'guage', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Gauge Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('guage');// Passing the table name
                $this->load->view('pages/guage', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('guage');// Passing the table size
                $this->load->view('pages/guage', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $guageId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('guage_id', $guageId, 'guage');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Gauge Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('guage');// Passing the table size
                $this->load->view('pages/guage', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('guage');// Passing the table size
                $this->load->view('pages/guage', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}

