<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('season');
        $parsingData['numrec'] = $this->Search_Model->numRec('season');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('season', 'season_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('season');// Passing the table name
            $this->load->view('pages/season', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('seasonName', 'Season Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('season');// Passing the table name
            $this->load->view('pages/season', $parsingData);
        }
        else
        {
            $seasonName = $this->input->post('seasonName');
            
            
            $insertionData = array(
                'season_name' => $seasonName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('season',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('season');// Passing the table name
                    $parsingData['successInsered'] = "Season Create Successfully!";
                    $this->load->view('pages/season', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('season');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/season', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'season', 'season_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'season', 'season_id', 'season_name');//passing table name and fields
                $parsingData['tableFeild1'] = 'season_id';
                $parsingData['tableFeild2'] = 'season_name';
                $parsingData['controllerName'] = 'season';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $seasonId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['season_name'] = $this->Operation_Model->getTableData('season_name', $seasonId, 'season_id', 'season');
            $parsingData['season_id'] = $seasonId;
            $this->load->view('pages/season', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $seasonId = $this->input->post('seasonCode');
        $seasonName = $this->input->post('seasonName');
        $UpdateData = array(
                'season_name' => $seasonName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('season_id', $seasonId, 'season', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Season Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('season');// Passing the table name
                $this->load->view('pages/season', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('season');// Passing the table name
                $this->load->view('pages/season', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $seasonId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('season_id', $seasonId, 'season');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Season Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('season');// Passing the table name
                $this->load->view('pages/season', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('season');// Passing the table name
                $this->load->view('pages/season', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
