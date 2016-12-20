<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_Sheet extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('calculateattendance_helper');
        $this->load->model('Operation_Model');
        $this->load->model('Search_Model');
    }
    
    public function index()
    {
        
        if($this->session->userdata('username'))
        {
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/salary_sheet', $parsingData);
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
        $salaryDays = $this->input->post('salaryDays');
        
        $parsingData['month'] = $month;
        $parsingData['salaryDays'] = $salaryDays;
        $parsingData['productionData'] = $this->Operation_Model->getAllDataFromTable('production');
        $parsingData['employeeData'] =  $this->Search_Model->searchEmployeeData($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId);
        $parsingData['salaryData'] =  $this->Search_Model->searchEmployeeSalary($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId);
        $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
        $parsingData['username'] = $this->session->userdata('username');
        $parsingData['calPaidDays'] = $this->Search_Model->calculatePaidDays($month);

        $this->load->view('pages/salary_sheet', $parsingData);
        
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
            $calculateSalary = $this->input->post('calculateSalary_'.$i);
            $salaryDaysCount = $this->input->post('daysOfAttand_'.$i);
            $insertionData = array(
                'employee_id' => $employeeId,
                'salary_sheet_month' => $month,
                'salary_sheet_days' => $salaryDaysCount,
                'salary_sheet_year' => $year,
                'salary_sheet_amount' => $calculateSalary
            );
            $callInsertionMethod = $this->Operation_Model->insertDataInToTable('salary_sheet', $insertionData);
        }     
        
        if(empty($callInsertionMethod))
        {
            if($this->session->userdata('username'))
            {
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['successInsered'] = "Salary Sheet Create Successfully!";
                $parsingData['username'] = $this->session->userdata('username');
                $this->load->view('pages/salary_sheet', $parsingData);
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
                $this->load->view('pages/salary_sheet', $parsingData);
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