<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incharge extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('incharge');
        $parsingData['numrec'] = $this->Search_Model->numRec('incharge');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('incharge', 'incharge_id');
        if($this->session->userdata('username'))
        {
            $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
            $this->load->view('pages/incharge', $parsingData);
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
        $this->form_validation->set_rules('inchargeName', 'Incharge Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
            $this->load->view('pages/incharge', $parsingData);
        }
        else
        {
            //$inchargeId = $this->input->post('inchargeCode');
            $inchargeName = $this->input->post('inchargeName');
            $subsectionId = $this->input->post('subsection');
            $guageString = '';       
            $guageArray = array();
            $guageName = $this->input->post('guage');
            if ($guageName)
            {
                foreach ($guageName as $value)
                {
                    array_push($guageArray,$value);
                }
            }
            for($i=0; $i<sizeof($guageArray); $i++)
            {
                $guageString .= $guageArray[$i].','; 
            }
            $insertionData = array(
                
                'incharge_name' => $inchargeName,
                'subsection_id'  => $subsectionId,
                'guage_name' => $guageString
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('incharge',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
                    $parsingData['successInsered'] = "Unit Create Successfully!";
                    $this->load->view('pages/incharge', $parsingData);
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
                    $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/incharge', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'incharge', 'incharge_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->GetInchargeData($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'incharge_id';
                $parsingData['tableFeild2'] = 'unit_name';
                $parsingData['tableFeild3'] = 'floor_name';
                $parsingData['tableFeild4'] = 'section_name';
                $parsingData['tableFeild5'] = 'subsection_name';
                $parsingData['tableFeild6'] = 'incharge_name';
                $parsingData['tableFeild7'] = 'guage_name';
                $parsingData['controllerName'] = 'incharge';
                $this->load->view('pages/data_table_incharge', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $inchargeId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['incharge_name'] = $this->Operation_Model->getTableData('incharge_name', $inchargeId, 'incharge_id', 'incharge');
            $subsectionId = $parsingData['subsection_edit'] = $this->Operation_Model->getTableData('subsection_id', $inchargeId, 'incharge_id', 'incharge');
            if(isset($subsectionId))
            {
                $parsingData['subsection_name'] = $this->Operation_Model->getTableData('subsection_name', $subsectionId, 'subsection_id', 'subsection');
                $parsingData['section_id'] = $this->Operation_Model->getTableData('section_id', $subsectionId, 'subsection_id', 'subsection');
                $parsingData['section_name'] = $this->Operation_Model->getTableData('section_name', $parsingData['section_id'], 'section_id', 'section');
                $parsingData['floor_id'] = $this->Operation_Model->getTableData('floor_id', $parsingData['section_id'], 'section_id', 'section');
                $parsingData['floor_name'] = $this->Operation_Model->getTableData('floor_name', $parsingData['floor_id'], 'floor_id', 'floor');
                $parsingData['unit_id'] = $this->Operation_Model->getTableData('unit_id', $parsingData['floor_id'], 'floor_id', 'floor');
                $parsingData['unit_name'] = $this->Operation_Model->getTableData('unit_name', $parsingData['unit_id'], 'unit_id', 'unit');
            }
            $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['incharge_id'] = $inchargeId;
            $this->load->view('pages/incharge', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $inchargeId = $this->input->post('inchargeCode');
        $inchargeName = $this->input->post('inchargeName');
        $subsectionId = $this->input->post('subsection');
        $guageString = '';       
        $guageArray = array();
        $guageName = $this->input->post('guage');
        if ($guageName)
        {
            foreach ($guageName as $value)
            {
                array_push($guageArray,$value);
            }
        }
        for($i=0; $i<sizeof($guageArray); $i++)
        {
            $guageString .= $guageArray[$i].','; 
        }
        
        $UpdateData = array(
                'incharge_name' => $inchargeName,
                'subsection_id'  => $subsectionId,
                'guage_name' => $guageString
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('incharge_id', $inchargeId, 'incharge', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Incharge Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
                $this->load->view('pages/incharge', $parsingData);
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
                $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
                $this->load->view('pages/incharge', $parsingData);
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
        $checkChild = $this->Operation_Model->checkChild('supervisor', 'incharge_id', $unitId);
       
        if($checkChild == TRUE)
        {
            $callDeleteMethod = $this->Operation_Model->deleteTableData('incharge_id', $unitId, 'incharge');
            if($callDeleteMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Incharge Deleted Successfully!";
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
                    $this->load->view('pages/incharge', $parsingData);
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
                    $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                    $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Deletion!";
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
                    $this->load->view('pages/incharge', $parsingData);
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
                $parsingData['guage'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "This Incharge Has Child Supervisor. Can't Delete With It's Child.!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('incharge');// Passing the table name
                $this->load->view('pages/incharge', $parsingData);
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
}
