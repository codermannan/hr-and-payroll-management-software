<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supervisor extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('supervisor');
        $parsingData['numrec'] = $this->Search_Model->numRec('supervisor');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('supervisor', 'supervisor_id');
        
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
            $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('supervisor');// Passing the table name
            $this->load->view('pages/supervisor', $parsingData);
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
        $this->form_validation->set_rules('subsection', 'Sub Section Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('incharge', 'Incharge Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('supervisorName', 'Supervisor Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
            $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('supervisor');// Passing the table name
            $this->load->view('pages/supervisor', $parsingData);
        }
        else
        {
            //$supervisorId = $this->input->post('supervisorCode');
            $inchageId = $this->input->post('incharge');
            $supervisorName = $this->input->post('supervisorName');
            $blockString = '';       
            $blockArray = array();
            $blockName = $this->input->post('block');
            if ($blockName)
            {
                foreach ($blockName as $value)
                {
                    array_push($blockArray,$value);
                }
            }
            for($i=0; $i<sizeof($blockArray); $i++)
            {
                $blockString .= $blockArray[$i].','; 
            }
            
            $majorpartsString = '';       
            $majorpartsArray = array();
            $majorpartsName = $this->input->post('majorparts');
            if ($majorpartsName)
            {
                foreach ($majorpartsName as $value)
                {
                    array_push($majorpartsArray,$value);
                }
            }
            for($i=0; $i<sizeof($majorpartsArray); $i++)
            {
                $majorpartsString .= $majorpartsArray[$i].','; 
            }
            
            $insertionData = array(
                
                'incharge_id' => $inchageId,
                'supervisor_name' => $supervisorName,
                'blockline_name' => $blockString,
                'majorpart_name' => $majorpartsString,
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('supervisor',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
                    $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('supervisor');// Passing the table name
                    $parsingData['successInsered'] = "Supervisor Create Successfully!";
                    $this->load->view('pages/supervisor', $parsingData);
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
                    $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
                    $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('supervisor');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/supervisor', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'supervisor', 'supervisor_id');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->GetSupervisorData($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'supervisor_id';
                $parsingData['tableFeild2'] = 'unit_name';
                $parsingData['tableFeild3'] = 'floor_name';
                $parsingData['tableFeild4'] = 'section_name';
                $parsingData['tableFeild5'] = 'subsection_name';
                $parsingData['tableFeild6'] = 'incharge_name';
                $parsingData['tableFeild7'] = 'supervisor_name';
                $parsingData['tableFeild8'] = 'blockline_name';
                $parsingData['tableFeild9'] = 'majorpart_name';
                $parsingData['controllerName'] = 'supervisor';
                $this->load->view('pages/data_table_supervisor', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $supervisorId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
            $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['supervisor_name'] = $this->Operation_Model->getTableData('supervisor_name', $supervisorId, 'supervisor_id', 'supervisor');
            $inchargeId = $parsingData['incharge_edit'] = $this->Operation_Model->getTableData('incharge_id', $supervisorId, 'supervisor_id', 'supervisor');
            if(isset($inchargeId))
            {
                $parsingData['incharge_name'] = $this->Operation_Model->getTableData('incharge_name', $inchargeId, 'incharge_id', 'incharge');
                $parsingData['subsection_id'] = $this->Operation_Model->getTableData('subsection_id', $inchargeId, 'incharge_id', 'incharge');
                $parsingData['subsection_name'] = $this->Operation_Model->getTableData('subsection_name', $parsingData['subsection_id'], 'subsection_id', 'subsection');
                $parsingData['section_id'] = $this->Operation_Model->getTableData('section_id', $parsingData['subsection_id'], 'subsection_id', 'subsection');
                $parsingData['section_name'] = $this->Operation_Model->getTableData('section_name', $parsingData['section_id'], 'section_id', 'section');
                $parsingData['floor_id'] = $this->Operation_Model->getTableData('floor_id', $parsingData['section_id'], 'section_id', 'section');
                $parsingData['floor_name'] = $this->Operation_Model->getTableData('floor_name', $parsingData['floor_id'], 'floor_id', 'floor');
                $parsingData['unit_id'] = $this->Operation_Model->getTableData('unit_id', $parsingData['floor_id'], 'floor_id', 'floor');
                $parsingData['unit_name'] = $this->Operation_Model->getTableData('unit_name', $parsingData['unit_id'], 'unit_id', 'unit');
            }
            $parsingData['supervisor_id'] = $supervisorId;
            $this->load->view('pages/supervisor', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $supervisorId = $this->input->post('supervisorCode');
        $inchageId = $this->input->post('incharge');
        $supervisorName = $this->input->post('supervisorName');
        $blockString = '';       
        $blockArray = array();
        $blockName = $this->input->post('block');
        if ($blockName)
        {
            foreach ($blockName as $value)
            {
                array_push($blockArray,$value);
            }
        }
        for($i=0; $i<sizeof($blockArray); $i++)
        {
            $blockString .= $blockArray[$i].','; 
        }

        $majorpartsString = '';       
        $majorpartsArray = array();
        $majorpartsName = $this->input->post('majorparts');
        if ($majorpartsName)
        {
            foreach ($majorpartsName as $value)
            {
                array_push($majorpartsArray,$value);
            }
        }
        for($i=0; $i<sizeof($majorpartsArray); $i++)
        {
            $majorpartsString .= $majorpartsArray[$i].','; 
        }
        
        $UpdateData = array(
                'incharge_id' => $inchageId,
                'supervisor_name' => $supervisorName,
                'blockline_name' => $blockString,
                'majorpart_name' => $majorpartsString,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('supervisor_id', $supervisorId, 'supervisor', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
                $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Supervisor Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('supervisor');// Passing the table name
                $this->load->view('pages/supervisor', $parsingData);
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
                $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
                $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('supervisor');// Passing the table name
                $this->load->view('pages/supervisor', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $supervisorId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('supervisor_id', $supervisorId, 'supervisor');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
                $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Supervisor Deleted Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('supervisor');// Passing the table name
                $this->load->view('pages/supervisor', $parsingData);
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
                $parsingData['block'] = $this->Operation_Model->getParentTable('block_id', 'block_name', 'block');
                $parsingData['majorparts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Deletion!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('supervisor');// Passing the table name
                $this->load->view('pages/supervisor', $parsingData);
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
    public function loadSubcection()
    {
        $sectionId = $this->input->post('sectionId');
        //exit($unitId);
        $subsectionData = $this->Operation_Model->nameSubSection($sectionId);
        echo json_encode($subsectionData);
    }
    public function loadIncharge()
    {
        $subsectionId = $this->input->post('subsectionId');
        $inchargeData = $this->Operation_Model->nameIncharge($subsectionId);
        echo json_encode($inchargeData);
    }
    
    
}
