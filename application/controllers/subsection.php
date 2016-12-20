<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsection extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('subsection');
        $parsingData['numrec'] = $this->Search_Model->numRec('subsection');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('subsection', 'subsection_id');//passing table name & table field Id
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
            $this->load->view('pages/subsection', $parsingData);
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
        $this->form_validation->set_rules('section', 'Section Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('subSectionName', 'Sub-Section Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
            $this->load->view('pages/subsection', $parsingData);
        }
        else
        {
            //$subSectionId = $this->input->post('subSectionCode');
            $sectionId = $this->input->post('section');
            $subSectionName = $this->input->post('subSectionName');
            
            $insertionData = array(
                
                'section_id' => $sectionId,
                'subsection_name' => $subSectionName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('subsection',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['floor'] = $this->Operation_Model->getParentTable('floor_id', 'floor_name', 'floor');
                    $parsingData['section'] = $this->Operation_Model->getParentTable('section_id', 'section_name', 'section');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
                    $parsingData['successInsered'] = "Sub Section Create Successfully!";
                    $this->load->view('pages/subsection', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/subsection', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'subsection', 'subsection_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->GetSubsectionData($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'subsection_id';
                $parsingData['tableFeild2'] = 'unit_name';
                $parsingData['tableFeild3'] = 'floor_name';
                $parsingData['tableFeild4'] = 'section_name';
                $parsingData['tableFeild5'] = 'subsection_name';
                $parsingData['controllerName'] = 'subsection';
                $this->load->view('pages/data_table_subsection', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $subsectionId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['subsection_name'] = $this->Operation_Model->getTableData('subsection_name', $subsectionId, 'subsection_id', 'subsection');
            $sectionId = $parsingData['section_edit'] = $this->Operation_Model->getTableData('section_id', $subsectionId, 'subsection_id', 'subsection');
            //exit($sectionId);
            if(isset($sectionId))
            {
                $parsingData['section_name'] = $this->Operation_Model->getTableData('section_name', $sectionId, 'section_id', 'section');
                $parsingData['floor_id'] = $this->Operation_Model->getTableData('floor_id', $sectionId, 'section_id', 'section');
                $parsingData['floor_name'] = $this->Operation_Model->getTableData('floor_name', $parsingData['floor_id'], 'floor_id', 'floor');
                $parsingData['unit_id'] = $this->Operation_Model->getTableData('unit_id', $parsingData['floor_id'], 'floor_id', 'floor');
                $parsingData['unit_name'] = $this->Operation_Model->getTableData('unit_name', $parsingData['unit_id'], 'unit_id', 'unit');
            }
            //$parsingData['section'] = $this->Operation_Model->getParentTable('section_id', 'section_name', 'section');
            $parsingData['subsection_id'] = $subsectionId;
            $this->load->view('pages/subsection', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $subSectionCode = $this->input->post('subSectionCode');
        $sectionCode = $this->input->post('section');
        $subSectionName = $this->input->post('subSectionName');
        $UpdateData = array(
                'section_id' => $sectionCode,
                'subsection_name' => $subSectionName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('subsection_id', $subSectionCode, 'subsection', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Sub Section Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
                $this->load->view('pages/subsection', $parsingData);
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
                $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
                $this->load->view('pages/subsection', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
        $subsectionId  =$this->uri->segment(3);
        $checkChild = $this->Operation_Model->checkChild('incharge', 'subsection_id', $unitId);
        if($checkChild == TRUE)
        {
            $callDeleteMethod = $this->Operation_Model->deleteTableData('subsection_id', $subsectionId , 'subsection');
            if($callDeleteMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Sub Section Deleted Successfully!";
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
                    $this->load->view('pages/subsection', $parsingData);
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
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Deletion!";
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
                    $this->load->view('pages/subsection', $parsingData);
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
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = "This Sub Section Has Child Incharge. Can't Delete With It's Child.";
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('subsection');// Passing the table name
                    $this->load->view('pages/subsection', $parsingData);
                    
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
    public function loadSection()
    {
        $floorId = $this->input->post('floorId');
        //exit($unitId);
        $sectionData = $this->Operation_Model->nameSection($floorId);
        echo json_encode($sectionData);
    }
}
