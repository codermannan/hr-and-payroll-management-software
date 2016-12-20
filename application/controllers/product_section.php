<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_section extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('product_section');
        $parsingData['numrec'] = $this->Search_Model->numRec('product_section');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('product_section', 'product_section_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('product_section');// Passing the table name
            $this->load->view('pages/product_section', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('productSectionName', 'Product Section Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('product_section');// Passing the table name
            $this->load->view('pages/product_section', $parsingData);
        }
        else
        {
            $product_sectionName = $this->input->post('productSectionName');
            
            $insertionData = array(
                'product_section_name' => $product_sectionName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('product_section',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('product_section');// Passing the table name
                    $parsingData['successInsered'] = "Product Section Create Successfully!";
                    $this->load->view('pages/product_section', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('product_section');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/product_section', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'product_section', 'product_section_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'product_section', 'product_section_id', 'product_section_name');//passing table name and fields
                $parsingData['tableFeild1'] = 'product_section_id';
                $parsingData['tableFeild2'] = 'product_section_name';
                $parsingData['controllerName'] = 'product_section';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $product_sectionId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['product_section_name'] = $this->Operation_Model->getTableData('product_section_name', $product_sectionId, 'product_section_id', 'product_section');
            $parsingData['product_section_id'] = $product_sectionId;
            $this->load->view('pages/product_section', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $product_section_id = $this->input->post('productSectionCode');
        $product_section_name = $this->input->post('productSectionName');
        $UpdateData = array(
                'product_section_name' => $product_section_name,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('product_section_id', $product_section_id, 'product_section', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Product Section Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('product_section');// Passing the table name
                $this->load->view('pages/product_section', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('product_section');// Passing the table name
                $this->load->view('pages/product_section', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
        $product_section_id =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('product_section_id', $product_section_id, 'product_section');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Product Section Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('product_section');// Passing the table name
                $this->load->view('pages/product_section', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('product_section');// Passing the table name
                $this->load->view('pages/product_section', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
