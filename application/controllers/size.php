<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Size extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('size');
        $parsingData['numrec'] = $this->Search_Model->numRec('size');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('size', 'size_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('size');// Passing the table name
            $this->load->view('pages/size', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('sizeName', 'size Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('size');// Passing the table name
            $this->load->view('pages/size', $parsingData);
        }
        else
        {
            $sizeName = $this->input->post('sizeName');
            
            $insertionData = array(
                'size_name' => $sizeName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('size',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('size');// Passing the table name
                    $parsingData['successInsered'] = "Size Create Successfully!";
                    $this->load->view('pages/size', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('size');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/size', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'size', 'size_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'size', 'size_id', 'size_name');//passing table name and fields
                $parsingData['tableFeild1'] = 'size_id';
                $parsingData['tableFeild2'] = 'size_name';
                $parsingData['controllerName'] = 'size';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $sizeId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['size_name'] = $this->Operation_Model->getTableData('size_name', $sizeId, 'size_id', 'size');
            $parsingData['size_id'] = $sizeId;
            $this->load->view('pages/size', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $sizeId = $this->input->post('sizeCode');
        $sizeName = $this->input->post('sizeName');
        $UpdateData = array(
                'size_name' => $sizeName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('size_id', $sizeId, 'size', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Size Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('size');// Passing the table name
                $this->load->view('pages/size', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('size');// Passing the table name
                $this->load->view('pages/size', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $sizeId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('size_id', $sizeId, 'size');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Size Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('size');// Passing the table name
                $this->load->view('pages/size', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('size');// Passing the table name
                $this->load->view('pages/size', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
