<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('unit');
        $parsingData['numrec'] = $this->Search_Model->numRec('unit');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('unit', 'unit_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
            //$parsingData['nextId'] = 122;
            $this->load->view('pages/unit', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('unitName', 'Unit Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('unitShortCode', 'Unit Code', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
            $this->load->view('pages/unit', $parsingData);
        }
        else
        {
            //$unitId = $this->input->post('unitCode');
            $unitName = $this->input->post('unitName');
            $unitShortCode = $this->input->post('unitShortCode');
            
            $insertionData = array(
                'unit_short_code' => $unitShortCode,
                'unit_name' => $unitName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('unit',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                    $parsingData['successInsered'] = "Unit Create Successfully!";
                    $this->load->view('pages/unit', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/unit', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'unit', 'unit_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page($vDescp, 'unit', 'unit_id', 'unit_name', 'unit_short_code');//passing table name and fields
                $parsingData['tableFeild1'] = 'unit_id';
                $parsingData['tableFeild2'] = 'unit_name';
                $parsingData['tableFeild3'] = 'unit_short_code';
                $parsingData['controllerName'] = 'unit';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $unitId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['unit_name'] = $this->Operation_Model->getTableData('unit_name', $unitId, 'unit_id', 'unit');
            $parsingData['unit_short_code'] = $this->Operation_Model->getTableData('unit_short_code', $unitId, 'unit_id', 'unit');
            $parsingData['unit_id'] = $unitId;
            $this->load->view('pages/unit', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $unitId = $this->input->post('unitCode');
        $unitName = $this->input->post('unitName');
        $unitShortCode = $this->input->post('unitShortCode');
        $UpdateData = array(
                'unit_name' => $unitName,
                'unit_short_code' => $unitShortCode,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('unit_id', $unitId, 'unit', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Unit Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                $this->load->view('pages/unit', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                $this->load->view('pages/unit', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $unitId =$this->uri->segment(3);
       
       $checkChild = $this->Operation_Model->checkChild('floor', 'unit_id', $unitId);
       
       if($checkChild == TRUE)
       {
            $callDeleteMethod = $this->Operation_Model->deleteTableData('unit_id', $unitId, 'unit');
            if($callDeleteMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Unit Deleted Successfully!";
                     $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                    $this->load->view('pages/unit', $parsingData);
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
                     $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                    $this->load->view('pages/unit', $parsingData);
                }
                else 
                {
                    redirect('login', 'refresh');
                }
            }
       }
       else
       {
           if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = "This Unit Has Child Floor. Can't Delete With It's Child.!";
                     $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                    $this->load->view('pages/unit', $parsingData);
                }
                else 
                {
                    redirect('login', 'refresh');
                }
       }
    }
}
