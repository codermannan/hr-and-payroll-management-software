<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Floor extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('floor');
        $parsingData['numrec'] = $this->Search_Model->numRec('floor');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('floor', 'floor_id');
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
            $this->load->view('pages/floor', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('unit', 'Unit Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('floorName', 'Floor Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('floorShortCode', 'Floor Short Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('unit', 'Unit', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
            $this->load->view('pages/floor', $parsingData);
        }
        else
        {
            //$floorId = $this->input->post('floorCode');
            $floorName = $this->input->post('floorName');
            $floorShortCode = $this->input->post('floorShortCode');
            $unitCode = $this->input->post('unit');
            
            $insertionData = array(
                'unit_id' => $unitCode,
                'floor_name' => $floorName,
                'floor_short_code' => $floorShortCode,
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('floor',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
                    $parsingData['successInsered'] = "Floor Create Successfully!";
                    $this->load->view('pages/floor', $parsingData);
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
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/floor', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'floor', 'floor_id');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->GetFloorData($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'floor_id';
                $parsingData['tableFeild2'] = 'floor_name';
                $parsingData['tableFeild3'] = 'floor_short_code';
                $parsingData['tableFeild4'] = 'unit_name';
                $parsingData['controllerName'] = 'floor';
                $this->load->view('pages/data_table_floor', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $floorId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['floor_name'] = $this->Operation_Model->getTableData('floor_name', $floorId, 'floor_id', 'floor');
            $parsingData['floor_short_code'] = $this->Operation_Model->getTableData('floor_short_code', $floorId, 'floor_id', 'floor');
            $parsingData['floor_id'] = $floorId;
            $unitId = $parsingData['unit_edit'] = $this->Operation_Model->getTableData('unit_id', $floorId, 'floor_id', 'floor');;
            if(isset($unitId))
            {
                $parsingData['unit_name'] = $this->Operation_Model->getTableData('unit_name', $unitId, 'unit_id', 'unit');
            }
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $this->load->view('pages/floor', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $floorId = $this->input->post('floorCode');
        $floorName = $this->input->post('floorName');
        $floorShortCode = $this->input->post('floorShortCode');
        $unitCode = $this->input->post('unit');
        $UpdateData = array(
                'floor_name' => $floorName,
                'unit_id' => $unitCode,
                'floor_short_code' => $floorShortCode,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('floor_id', $floorId, 'floor', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Floor Update Successfully!";
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
                $this->load->view('pages/floor', $parsingData);
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
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
                $this->load->view('pages/floor', $parsingData);
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
       $checkChild = $this->Operation_Model->checkChild('section', 'floor_id', $unitId);
       if($checkChild == TRUE)
       {
            $callDeleteMethod = $this->Operation_Model->deleteTableData('floor_id', $unitId, 'floor');
            if($callDeleteMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Floor Deleted Successfully!";
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
                    $this->load->view('pages/floor', $parsingData);
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
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
                    $this->load->view('pages/floor', $parsingData);
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
                    $parsingData['errorInsered'] = "This Floor Has Child Section. Can't Delete With It's Child.!";
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('floor');// Passing the table name
                    $this->load->view('pages/floor', $parsingData);
                }
                else 
                {
                    redirect('login', 'refresh');
                }
       }
    }
}
