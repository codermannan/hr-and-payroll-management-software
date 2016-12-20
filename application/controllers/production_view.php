<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_View extends CI_Controller 
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
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/production_view', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function searchCurrent()
    {
        $month = date('n');
        $year = date('Y');
        
        $parsingData['productionData'] =  $this->Search_Model->searchCurrentMonthProductionData($month, $year);
        $parsingData['username'] = $this->session->userdata('username');
        $parsingData['checkMonth'] = $month;
        $parsingData['checkYear'] = $year;
        $this->load->view('pages/production_view', $parsingData);
        
    }

    public function searchLimitMonthData()
    {
        $beginMonth = $this->input->post('fromMonth');
        $endMonth = $this->input->post('toMonth');
        $year = $this->input->post('year');
        if($beginMonth=="" || $endMonth=="" ||  $year==""){
            $this->load->view('pages/production_view');
        }
        $parsingData['productionData'] =  $this->Search_Model->searchLimitMonthProductionData($beginMonth, $endMonth, $year);
        $parsingData['username'] = $this->session->userdata('username');
        // $parsingData['checkMonth'] = $month;
        // $parsingData['checkYear'] = $year;
        $this->load->view('pages/production_view', $parsingData);
        
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

            $insertionData = array(
                'employee_id' => $employeeId,
                'production_month' => $month,
                'production_year' => $year,
                'production_amount' => $calculateSalary
            );
            $callInsertionMethod = $this->Operation_Model->insertDataGetId('salary_sheet', $insertionData);
        }     
        
        if(empty($callInsertionMethod))
        {
            if($this->session->userdata('username'))
            {
                $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
                $parsingData['successInsered'] = "Salary Sheet Create Successfully!";
                $parsingData['username'] = $this->session->userdata('username');
                $this->load->view('pages/production_view', $parsingData);
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
                $this->load->view('pages/production_view', $parsingData);
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