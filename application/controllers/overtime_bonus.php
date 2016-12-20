<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Overtime_Bonus extends CI_Controller 
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
            $this->load->view('pages/overtime_bonus', $parsingData);
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
        $month = $this->input->post('month');
        $year = date('Y');
        
        $parsingData['month'] = $month;
        $parsingData['productionData'] = $this->Operation_Model->getAllDataFromTable('production');
        $parsingData['employeeData'] =  $this->Search_Model->searchEmployeeData($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId);
        $parsingData['employeeDataOvertimeBonus'] =  $this->Search_Model->searchEmployeeDataOvertimeBonus($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId, $month, $year);
        $parsingData['salaryData'] =  $this->Search_Model->searchEmployeeSalary($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId);
        $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
        $parsingData['username'] = $this->session->userdata('username');
        $this->load->view('pages/overtime_bonus', $parsingData);
        
    }
    
    public function loadBlockMajor()
    {
        $supervisorId = $this->input->post('supervisorId');
        $BlockMajorData = $this->Operation_Model->blockMajor($supervisorId);
        echo json_encode($BlockMajorData);
    }
    
    public function submitData()
    {
        $loopcount = $this->input->post('loopCount');
        $month = $this->input->post('monthField');
        $year = date('Y');
        for($i=1; $i<$loopcount; $i++)
        {
            $employeeId = $this->input->post('employeeId_'.$i);
            $calculateAmount = $this->input->post('calculateSalary_'.$i);
            $hours = $this->input->post('overtimeHours_'.$i);
            $days = $this->input->post('overtimeDays_'.$i);
            $insertionData = array(
                'employee_id' => $employeeId,
                'overtime_bonus_month' => $month,
                'overtime_bonus_days' => $days,
                'overtime_bonus_hours' => $hours,
                'overtime_bonus_year' => $year,
                'overtime_bonus_amount' => $calculateAmount
            );
            $callInsertionMethod = $this->Operation_Model->insertDataInToTable('overtime_bonus', $insertionData);
        }     
        
        if(empty($callInsertionMethod))
        {
            if($this->session->userdata('username'))
            {
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['successInsered'] = "Bonus Inserted Successfully!";
                $parsingData['username'] = $this->session->userdata('username');
                $this->load->view('pages/overtime_bonus', $parsingData);
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
                $parsingData['errorInsered'] = $callInsertionMethod;
                $parsingData['username'] = $this->session->userdata('username');
                $this->load->view('pages/overtime_bonus', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
        
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