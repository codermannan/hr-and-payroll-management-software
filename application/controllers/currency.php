<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('currency');
        $parsingData['numrec'] = $this->Search_Model->numRec('currency');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('currency', 'currency_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('currency');// Passing the table name
            $this->load->view('pages/currency', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('currencyName', 'Currency Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('currencyCode', 'Currency Code', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('currency');// Passing the table name
            $this->load->view('pages/currency', $parsingData);
        }
        else
        {
            $currencyName = $this->input->post('currencyName');
            $currencyCode = $this->input->post('currencyCode');
            
            $insertionData = array(
                'currency_code' => $currencyCode,
                'currency_name' => $currencyName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('currency',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('currency');// Passing the table name
                    $parsingData['successInsered'] = "Currency Create Successfully!";
                    $this->load->view('pages/currency', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('currency');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/currency', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'currency', 'currency_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page($vDescp, 'currency', 'currency_id', 'currency_name', 'currency_code');//passing table name and fields
                $parsingData['tableFeild1'] = 'currency_id';
                $parsingData['tableFeild2'] = 'currency_name';
                $parsingData['tableFeild3'] = 'currency_code';
                $parsingData['controllerName'] = 'currency';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $currencyId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['currency_name'] = $this->Operation_Model->getTableData('currency_name', $currencyId, 'currency_id', 'currency');
            $parsingData['currency_code'] = $this->Operation_Model->getTableData('currency_code', $currencyId, 'currency_id', 'currency');
            $parsingData['currency_id'] = $currencyId;
            $this->load->view('pages/currency', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $currencyId = $this->input->post('currencyId');
       
        $currencyName = $this->input->post('currencyName');
        $currencyCode = $this->input->post('currencyCode');
        $UpdateData = array(
                'currency_name' => $currencyName,
                'currency_code' => $currencyCode,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('currency_id', $currencyId, 'currency', $UpdateData);
        
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Currency Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('currency');// Passing the table name
                $this->load->view('pages/currency', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('currency');// Passing the table name
                $this->load->view('pages/currency', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $currencyId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('currency_id', $currencyId, 'currency');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Currency Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('currency');// Passing the table name
                $this->load->view('pages/currency', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('currency');// Passing the table name
                $this->load->view('pages/currency', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
