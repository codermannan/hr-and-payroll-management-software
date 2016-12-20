<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('employee');
        $parsingData['numrec'] = $this->Search_Model->numRec('employee');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('employee', 'employee_id'); 
        
        if($this->session->userdata('username'))
        {
           
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
            
            $this->load->view('pages/employee', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $unit = $this->input->post('unitId');
        $floor = $this->input->post('floorId');
        $section = $this->input->post('sectionId');
        $subSection = $this->input->post('subsectionId');
        $incharge = $this->input->post('inchargeId');
        $supervisor = $this->input->post('supervisorId');
        $employee_type = $this->input->post('employee_typeId');
        $designation = $this->input->post('designationId');
        $employeePreCode = $this->input->post('pre_code');
        $employeeCode = $this->input->post('employeeCode');
        $fullName = $this->input->post('fullName');
        $guardianName = $this->input->post('guardianName');
        $educationQualification = $this->input->post('educationQualification');
        $grade = $this->input->post('grade');
        $dateOfBirth = $this->input->post('dateOfBirth');
        $joiningDate = $this->input->post('joiningDate');
        $permanentAddress = $this->input->post('permanentAddress');
        $presentAddress = $this->input->post('presentAddress');
        $phone = $this->input->post('phone');
        
        
       
      
        
        $insertionData1 = array(
                'employee_pre_code' => $employeePreCode,
                'employee_code' => $employeeCode,
                'unit_id' => $unit,
                'floor_id' => $floor,
                'section_id' => $section,
                'subsection_id' => $subSection,
                'incharge_id' => $incharge,
                'supervisor_id' => $supervisor,
                'designation_id' => $designation,
                'employee_type_id' => $employee_type,
                'employee_grade' => $grade,
                'employee_name' => $fullName,
                'employee_guardian' => $guardianName,
                'employee_permanentAddress' => $permanentAddress,
                'employee_presentAddress' => $presentAddress,
                'employee_education' => $educationQualification,
                'employee_dateOfBirth' => $dateOfBirth,
                'employee_joiningDate' => $joiningDate,
                'employee_phone' => $phone,
            );
        $callInsertionMethod = $this->Operation_Model->insertDataGetId('employee', $insertionData1);
        echo $callInsertionMethod;
    }
    public function submitDataToSalary()
    {
        $salary_type_id = $this->input->post('salary_type_id');
        $amount = $this->input->post('amount');
        $employee_id = $this->input->post('employee_id');
        
         $insertionData1 = array(
                'employee_id' => $employee_id,
                'salary_head_id' => $salary_type_id,
                'salary_head_amount' => $amount,
                
            );
        $callInsertionMethod = $this->Operation_Model->insertInToTable('salary', $insertionData1);
       
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'employee', 'employee_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfEmployeeData_page($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'employee_id';
                $parsingData['tableFeild2'] = 'employee_pre_code';
                $parsingData['tableFeild3'] = 'employee_code';
                $parsingData['tableFeild4'] = 'employee_name';
                $parsingData['tableFeild5'] = 'designation_name';
                $parsingData['tableFeild6'] = 'employee_joiningDate';
                
                $this->load->view('pages/employee_data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $employeeId =$this->uri->segment(3);
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
            $parsingData['unit_id'] = $this->Operation_Model->getTableData('unit_id', $employeeId, 'employee_id', 'employee');
            $parsingData['floor_id'] = $this->Operation_Model->getTableData('floor_id', $employeeId, 'employee_id', 'employee');
            $parsingData['section_id'] = $this->Operation_Model->getTableData('section_id', $employeeId, 'employee_id', 'employee');
            $parsingData['subsection_id'] = $this->Operation_Model->getTableData('subsection_id', $employeeId, 'employee_id', 'employee');
            $parsingData['incharge_id'] = $this->Operation_Model->getTableData('incharge_id', $employeeId, 'employee_id', 'employee');
            $parsingData['supervisor_id'] = $this->Operation_Model->getTableData('supervisor_id', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_type_id'] = $this->Operation_Model->getTableData('employee_type_id', $employeeId, 'employee_id', 'employee');
            $parsingData['designation_id'] = $this->Operation_Model->getTableData('designation_id', $employeeId, 'employee_id', 'employee');
            
            $parsingData['employee_pre_code'] = $this->Operation_Model->getTableData('employee_pre_code', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_code'] = $this->Operation_Model->getTableData('employee_code', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_name'] = $this->Operation_Model->getTableData('employee_name', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_guardian'] = $this->Operation_Model->getTableData('employee_guardian', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_education'] = $this->Operation_Model->getTableData('employee_education', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_grade'] = $this->Operation_Model->getTableData('employee_grade', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_dateOfBirth'] = $this->Operation_Model->getTableData('employee_dateOfBirth', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_joiningDate'] = $this->Operation_Model->getTableData('employee_joiningDate', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_permanentAddress'] = $this->Operation_Model->getTableData('employee_permanentAddress', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_presentAddress'] = $this->Operation_Model->getTableData('employee_permanentAddress', $employeeId, 'employee_id', 'employee');
            $parsingData['employee_phone'] = $this->Operation_Model->getTableData('employee_phone', $employeeId, 'employee_id', 'employee');
                  
            
            if($parsingData['unit_id'] != 0)
            {
                $parsingData['unit_name'] = $this->Operation_Model->getTableData('unit_name', $parsingData['unit_id'], 'unit_id', 'unit');
            }
            if($parsingData['floor_id'] != 0)
            {
                $parsingData['floor_name'] = $this->Operation_Model->getTableData('floor_name', $parsingData['floor_id'], 'floor_id', 'floor');
            }
            if($parsingData['section_id'] != 0)
            {
                $parsingData['section_name'] = $this->Operation_Model->getTableData('section_name', $parsingData['section_id'], 'section_id', 'section');
            }
            if( $parsingData['subsection_id'] != 0 )
            {
                $parsingData['subsection_name'] = $this->Operation_Model->getTableData('subsection_name', $parsingData['subsection_id'], 'subsection_id', 'subsection');
            }

            if($parsingData['incharge_id'] != 0)
            {
                $parsingData['incharge_name'] = $this->Operation_Model->getTableData('incharge_name', $parsingData['incharge_id'], 'incharge_id', 'incharge');
            }
            if($parsingData['supervisor_id'] != 0)
            {
                $parsingData['supervisor_name'] = $this->Operation_Model->getTableData('supervisor_name', $parsingData['supervisor_id'], 'supervisor_id', 'supervisor');
            }
            if($parsingData['employee_type_id'] != 0)
            {
                $parsingData['employee_type_name'] = $this->Operation_Model->getTableData('employee_type_name', $parsingData['employee_type_id'], 'employee_type_id', 'employeetype');
            }
            if($parsingData['designation_id'] != 0)
            {
                $parsingData['designation_name'] = $this->Operation_Model->getTableData('designation_name', $parsingData['designation_id'], 'designation_id', 'designation');
            }
            $parsingData['employee_id'] = $employeeId;
            $this->load->view('pages/employee', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $unit = $this->input->post('unitId');
        $floor = $this->input->post('floorId');
        $section = $this->input->post('sectionId');
        $subSection = $this->input->post('subsectionId');
        $incharge = $this->input->post('inchargeId');
        $supervisor = $this->input->post('supervisorId');
        $employee_type = $this->input->post('employee_typeId');
        $designation = $this->input->post('designationId');
        $employeePreCode = $this->input->post('pre_code');
        $employeeCode = $this->input->post('employeeCode');
        $fullName = $this->input->post('fullName');
        $guardianName = $this->input->post('guardianName');
        $educationQualification = $this->input->post('educationQualification');
        $grade = $this->input->post('grade');
        $dateOfBirth = $this->input->post('dateOfBirth');
        $joiningDate = $this->input->post('joiningDate');
        $permanentAddress = $this->input->post('permanentAddress');
        $presentAddress = $this->input->post('presentAddress');
        $phone = $this->input->post('phone');
        $employeeId = $this->input->post('employeeId');
        
       
      
        
        $UpdateData = array(
                'employee_pre_code' => $employeePreCode,
                'employee_code' => $employeeCode,
                'unit_id' => $unit,
                'floor_id' => $floor,
                'section_id' => $section,
                'subsection_id' => $subSection,
                'incharge_id' => $incharge,
                'supervisor_id' => $supervisor,
                'designation_id' => $designation,
                'employee_type_id' => $employee_type,
                'employee_grade' => $grade,
                'employee_name' => $fullName,
                'employee_guardian' => $guardianName,
                'employee_permanentAddress' => $permanentAddress,
                'employee_presentAddress' => $presentAddress,
                'employee_education' => $educationQualification,
                'employee_dateOfBirth' => $dateOfBirth,
                'employee_joiningDate' => $joiningDate,
                'employee_phone' => $phone,
            );
        
        
        $this->Operation_Model->updateTable('employee_id', $employeeId, 'employee', $UpdateData);
        echo $employeeId;
    }
    
    public function editDataToSalary()
    {
        $salary_type_id = $this->input->post('salary_type_id');
        $amount = $this->input->post('amount');
        $employee_id = $this->input->post('employee_id');
        
         $UpdateData = array(
                'salary_head_amount' => $amount,
            );
        
        $this->Operation_Model->updateSalary('employee_id', $employee_id, 'salary_head_id', $salary_type_id, 'salary', $UpdateData);
       
    }
    
    
    
    function delete()
    {
        $employeeId =$this->uri->segment(3);
        $this->Operation_Model->deleteTableData('employee_id', $employeeId, 'employee');
        $this->Operation_Model->deleteTableData('employee_id', $employeeId, 'salary');
        $this->Operation_Model->limit = 10;
        $this->Operation_Model->Mostlimit = 1;
        $this->Operation_Model->offset = $this->uri->segment(3);
        $parsingData['query'] = $this->Operation_Model->listOfData('employee');
        $parsingData['numrec'] = $this->Operation_Model->numRec('employee');
        $parsingData['requestNo'] = $this->Operation_Model->getAllRequestCount('employee', 'employee_id');
        $parsingData['successInsered'] = "Employee Has been Deleted Successfully!";
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['unit'] = $this->Operation_Model->getParentTable('unit_id', 'unit_name', 'unit');
            $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
            $this->load->view('pages/employee', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function getCode()
    {
        $tableName = $this->uri->segment(3);
        $selectField = $this->uri->segment(4);
        $compareField = $this->uri->segment(5);
        $compareBy = $this->uri->segment(6);
        $this->load->model('Operation_Model');
        $employeeCode = $this->Operation_Model->getShortCodeData($tableName, $selectField, $compareField, $compareBy);
        echo $employeeCode;
        //echo $tableName.' '.$selectField.' '.$compareField.' '.$compareBy;
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
    public function loadSupervisor()
    {
        $inchargeId = $this->input->post('inchargeId');
        $supervisorData = $this->Operation_Model->nameSupervisor($inchargeId);
        echo json_encode($supervisorData);
    }
    public function loadDesignation()
    {
        $employeeCodeId = $this->input->post('employeeCodeId');
        $designationData = $this->Operation_Model->nameDesignation($employeeCodeId);
        echo json_encode($designationData);
    }
    public function loadSalary()
    {
        $employeeCodeId = $this->input->post('employeeCodeId');
        $salaryData = $this->Operation_Model->nameSalary($employeeCodeId);
        echo json_encode($salaryData);
    }
    
    public function loadEmployeeSalary()
    {
        $employeeId = $this->input->post('employeeId');
        $salaryData = $this->Operation_Model->EmployeeSalary($employeeId);
        echo json_encode($salaryData);
    }
}
