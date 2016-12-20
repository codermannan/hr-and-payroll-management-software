<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Block extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('block');
        $parsingData['numrec'] = $this->Search_Model->numRec('block');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('block', 'block_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('block');// Passing the table name
            $this->load->view('pages/block', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('blockName', 'GaugeSize', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('block');// Passing the table name
            $this->load->view('pages/block', $parsingData);
        }
        else
        {
           $blockName = $this->input->post('blockName');
            
            $insertionData = array(
                'block_name' => $blockName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('block',$insertionData);//passing table size with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('block');// Passing the table size
                    $parsingData['successInsered'] = "Block Create Successfully!";
                    $this->load->view('pages/block', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('block');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/block', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'block', 'block_name');//passing table size and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'block', 'block_id', 'block_name');//passing table size and fields
                $parsingData['tableFeild1'] = 'block_id';
                $parsingData['tableFeild2'] = 'block_name';
                $parsingData['controllerName'] = 'block';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $blockId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['block_name'] = $this->Operation_Model->getTableData('block_name', $blockId, 'block_id', 'block');
            $parsingData['block_id'] = $blockId;
            $this->load->view('pages/block', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $blockId = $this->input->post('blockCode');
        $blockName = $this->input->post('blockName');
        $UpdateData = array(
                'block_name' => $blockName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('block_id', $blockId, 'block', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Block Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('block');// Passing the table name
                $this->load->view('pages/block', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('block');// Passing the table size
                $this->load->view('pages/block', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $blockId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('block_id', $blockId, 'block');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Block Hase Been Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('block');// Passing the table size
                $this->load->view('pages/block', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('block');// Passing the table size
                $this->load->view('pages/block', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}

