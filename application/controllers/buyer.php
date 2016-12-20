<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buyer extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('buyer');
        $parsingData['numrec'] = $this->Search_Model->numRec('buyer');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('buyer', 'buyer_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('buyer');// Passing the table name
            $this->load->view('pages/buyer', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('buyerName', 'buyer Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('buyer');// Passing the table name
            $this->load->view('pages/buyer', $parsingData);
        }
        else
        {
            $buyerName = $this->input->post('buyerName');
            
            $insertionData = array(
                'buyer_name' => $buyerName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('buyer',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('buyer');// Passing the table name
                    $parsingData['successInsered'] = "Buyer Create Successfully!";
                    $this->load->view('pages/buyer', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('buyer');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/buyer', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'buyer', 'buyer_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'buyer', 'buyer_id', 'buyer_name');//passing table name and fields
                $parsingData['tableFeild1'] = 'buyer_id';
                $parsingData['tableFeild2'] = 'buyer_name';
                $parsingData['controllerName'] = 'buyer';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $buyerId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['buyer_name'] = $this->Operation_Model->getTableData('buyer_name', $buyerId, 'buyer_id', 'buyer');
            $parsingData['buyer_id'] = $buyerId;
            $this->load->view('pages/buyer', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $buyerId = $this->input->post('buyerCode');
        $buyerName = $this->input->post('buyerName');
        $UpdateData = array(
                'buyer_name' => $buyerName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('buyer_id', $buyerId, 'buyer', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Buyer Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('buyer');// Passing the table name
                $this->load->view('pages/buyer', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('buyer');// Passing the table name
                $this->load->view('pages/buyer', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $buyerId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('buyer_id', $buyerId, 'buyer');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Buyer Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('buyer');// Passing the table name
                $this->load->view('pages/buyer', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('buyer');// Passing the table name
                $this->load->view('pages/buyer', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
