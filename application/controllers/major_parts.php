<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Major_parts extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('majorparts');
        $parsingData['numrec'] = $this->Search_Model->numRec('majorparts');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('majorparts', 'majorParts_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('majorparts');// Passing the table name
            $this->load->view('pages/major_parts', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('majorPartsName', 'Major Parts Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('majorparts');// Passing the table name
            $this->load->view('pages/major_parts', $parsingData);
        }
        else
        {
            $majorPartsName = $this->input->post('majorPartsName');
            
            $insertionData = array(
                'majorParts_name' => $majorPartsName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('majorparts',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('majorparts');// Passing the table name
                    $parsingData['successInsered'] = "Major Parts Create Successfully!";
                    $this->load->view('pages/major_parts', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('majorparts');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/major_parts', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'majorparts', 'majorParts_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'majorparts', 'majorParts_id', 'majorParts_name');//passing table name and fields
                $parsingData['tableFeild1'] = 'majorParts_id';
                $parsingData['tableFeild2'] = 'majorParts_name';
                $parsingData['controllerName'] = 'major_parts';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $majorPartsId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['majorParts_name'] = $this->Operation_Model->getTableData('majorParts_name', $majorPartsId, 'majorParts_id', 'majorparts');
            $parsingData['majorParts_id'] = $majorPartsId;
            $this->load->view('pages/major_parts', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $majorPartsId = $this->input->post('majorPartsCode');
        $majorPartsName = $this->input->post('majorPartsName');
        $UpdateData = array(
                'majorParts_name' => $majorPartsName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('majorParts_id', $majorPartsId, 'majorparts', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Major Parts Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('majorparts');// Passing the table name
                $this->load->view('pages/major_parts', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('majorparts');// Passing the table name
                $this->load->view('pages/major_parts', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
        $majorPartsId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('majorParts_id', $majorPartsId, 'majorparts');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Major Parts Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('majorparts');// Passing the table name
                $this->load->view('pages/major_parts', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('majorparts');// Passing the table name
                $this->load->view('pages/major_parts', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
