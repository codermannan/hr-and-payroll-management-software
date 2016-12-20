<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Style extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('style');
        $parsingData['numrec'] = $this->Search_Model->numRec('style');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('style', 'style_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('style');// Passing the table name
            $this->load->view('pages/style', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('styleName', 'style Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('style');// Passing the table name
            $this->load->view('pages/style', $parsingData);
        }
        else
        {
            $styleId = $this->input->post('styleCode');
            $styleName = $this->input->post('styleName');
            
            $insertionData = array(
                'style_name' => $styleName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('style',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('style');// Passing the table name
                    $parsingData['successInsered'] = "Style Create Successfully!";
                    $this->load->view('pages/style', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('style');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/style', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'style', 'style_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'style', 'style_id', 'style_name');//passing table name and fields
                $parsingData['tableFeild1'] = 'style_id';
                $parsingData['tableFeild2'] = 'style_name';
                $parsingData['controllerName'] = 'style';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $styleId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['style_name'] = $this->Operation_Model->getTableData('style_name', $styleId, 'style_id', 'style');
            $parsingData['style_id'] = $styleId;
            $this->load->view('pages/style', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $styleId = $this->input->post('styleCode');
        $styleName = $this->input->post('styleName');
        $UpdateData = array(
                'style_name' => $styleName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('style_id', $styleId, 'style', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Style Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('style');// Passing the table name
                $this->load->view('pages/style', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('style');// Passing the table name
                $this->load->view('pages/style', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $styleId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('style_id', $styleId, 'style');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Style Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('style');// Passing the table name
                $this->load->view('pages/style', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('style');// Passing the table name
                $this->load->view('pages/style', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
