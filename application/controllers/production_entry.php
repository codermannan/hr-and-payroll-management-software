<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_Entry extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Operation_Model');
        $this->load->model('Search_Model');
    }
    
    public function index()
    {
        
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/production_entry', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function searchEmployee()
    {
        $unitId = $this->input->post('unit');
        $floorId = $this->input->post('floor');
        $sectionId = $this->input->post('section');
        $subSectionId = $this->input->post('subsection');
        $inchargeId = $this->input->post('incharge');
        $supervisorId = $this->input->post('supervisor');
        
        $employeeData = $this->Search_Model->searchEmployeeData($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId);
        $parsingData['productionData'] = $this->Operation_Model->getAllDataFromTable('production');
        $parsingData['employeeData'] =  $employeeData;
        $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
        $parsingData['username'] = $this->session->userdata('username');
        $this->load->view('pages/production_entry', $parsingData);
        
    }
    
    public function loadBlockMajor()
    {
        $supervisorId = $this->input->post('supervisorId');
        $BlockMajorData = $this->Operation_Model->blockMajor($supervisorId);
        echo json_encode($BlockMajorData);
    }
    
    public function submitData()
    {
        $employeeId = $this->input->post('employee_id');
        $operationId = $this->input->post('operationId');
        $quantityId = $this->input->post('quantity');
        $operationDate = $this->input->post('operationDate');
        
        $insertionData = array(
            'employee_id' => $employeeId,
            'production_operation_id' => $operationId,
            'production_quantity' => $quantityId,
            'operation_date' => $operationDate
        );
//           
        $callInsertionMethod = $this->Operation_Model->insertDataGetId('production', $insertionData);
//       
    }
    
    public function checkData()
    {
        $employeeId = $this->input->post('employee_id');
        $callDuplicacyMethod = $this->Operation_Model->checkDuplicacy('employee_id', $employeeId, 'production');
        echo $callDuplicacyMethod;
    }
    
    public function deleteData()
    {
        $employeeId = $this->input->post('employee_id');
        $calldeleteMethod = $this->Operation_Model->deleteTableData('employee_id', $employeeId, 'production');
        echo $calldeleteMethod;
    }
}
