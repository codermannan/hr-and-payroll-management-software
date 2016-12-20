<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Section extends CI_Controller 
{
    private $pagesize = 20;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Operation_Model');
        $this->load->library('form_validation');
        $this->load->model('Search_Model');
    }
    
    public function index()
    {
        $this->Search_Model->limit = 20;
        $this->Search_Model->Mostlimit = 1;
        $this->Search_Model->offset = $this->uri->segment(3);
        $parsingData['query'] = $this->Search_Model->listOfData('section');
        $parsingData['numrec'] = $this->Search_Model->numRec('section');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('section', 'section_id');
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('section');// Passing the table name
            $this->load->view('pages/section', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('unit', 'Unit Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('floor', 'Floor Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sectionName', 'Section Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sectionShortCode', 'Section Short Code', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('section');// Passing the table name
            $this->load->view('pages/section', $parsingData);
        }
        else
        {
            //$sectionId = $this->input->post('sectionCode');
            $sectionName = $this->input->post('sectionName');
            $sectionShortCode = $this->input->post('sectionShortCode');
            $floorId = $this->input->post('floor');
            $insertionData = array(
                
                'floor_id' => $floorId,
                'section_name' => $sectionName,
                'section_short_code' => $sectionShortCode
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('section',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('section');// Passing the table name
                    $parsingData['successInsered'] = "Section Create Successfully!";
                    $this->load->view('pages/section', $parsingData);
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
                    $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('section');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/section', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'section', 'section_id');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->GetSectionData($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'section_id';
                $parsingData['tableFeild2'] = 'floor_name';
                $parsingData['tableFeild5'] = 'unit_name';
                $parsingData['tableFeild3'] = 'section_name';
                $parsingData['tableFeild4'] = 'section_short_code';
                $parsingData['controllerName'] = 'section';
                $this->load->view('pages/data_table_section', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $sectionId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['section_name'] = $this->Operation_Model->getTableData('section_name', $sectionId, 'section_id', 'section');
            $parsingData['section_short_code'] = $this->Operation_Model->getTableData('section_short_code', $sectionId, 'section_id', 'section');
            $floorId = $parsingData['floor_edit'] = $this->Operation_Model->getTableData('floor_id', $sectionId, 'section_id', 'section');;
            if(isset($floorId))
            {
                $parsingData['floor_name'] = $this->Operation_Model->getTableData('floor_name', $floorId, 'floor_id', 'floor');
                $parsingData['unit_id'] = $this->Operation_Model->getTableData('unit_id', $floorId, 'floor_id', 'floor');
                $parsingData['unit_name'] = $this->Operation_Model->getTableData('unit_name', $parsingData['unit_id'], 'unit_id', 'unit');
                
            }
            $parsingData['section_id'] = $sectionId;
            $this->load->view('pages/section', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $sectionId = $this->input->post('sectionCode');
        $sectionName = $this->input->post('sectionName');
        $sectionShortCode = $this->input->post('sectionShortCode');
        $floorId = $this->input->post('floor');
        $UpdateData = array(
                'section_name' => $sectionName,
                'floor_id' => $floorId,
                'section_short_code' => $sectionShortCode
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('section_id', $sectionId, 'section', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Section Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('section');// Passing the table name
                $this->load->view('pages/section', $parsingData);
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
                $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('section');// Passing the table name
                $this->load->view('pages/section', $parsingData);
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
        $checkChild = $this->Operation_Model->checkChild('subsection', 'section_id', $unitId);
        if($checkChild == TRUE)
        {
            $callDeleteMethod = $this->Operation_Model->deleteTableData('section_id', $unitId, 'section');
            if($callDeleteMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Section Deleted Successfully!";
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                    $this->load->view('pages/section', $parsingData);
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
                    $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Deletion!";
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('section');// Passing the table name
                    $this->load->view('pages/section', $parsingData);
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
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = "This Section Has Child Sub Section. Can't Delete With It's Child.!";
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('section');// Passing the table name
                    $this->load->view('pages/section', $parsingData);
                 }
                 else 
                 {
                     redirect('login', 'refresh');
                 }
        }
    }
    
    public function loadFloor()
    {
        $unitId = $this->input->post('unitId');
        //exit($unitId);
        $floorData = $this->Operation_Model->nameFloor($unitId);
        echo json_encode($floorData);
    }
}
