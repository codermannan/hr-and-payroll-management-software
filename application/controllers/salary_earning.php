<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_Earning extends CI_Controller 
{
    private $pagesize = 2000;
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
        $this->Search_Model->limit = 2000;
        $this->Search_Model->Mostlimit = 1;
        $this->Search_Model->offset = $this->uri->segment(3);
        $parsingData['query'] = $this->Search_Model->listOfData('salaryearning');
        $parsingData['numrec'] = $this->Search_Model->numRec('salaryearning');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('salaryearning', 'salaryearning_id');
        if($this->session->userdata('username'))
        {
            $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name
            $this->load->view('pages/salary_earning', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('employee_type', 'Employee Type', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name
            $this->load->view('pages/salary_earning', $parsingData);
        }
        else
        {
            $headIdRecieveArray = array();
            $employeeTypeId = $this->input->post('employee_type');
            $salaryHeadIdArray = $this->input->post('salaryHeadId');
            if ($salaryHeadIdArray)
            {
                foreach ($salaryHeadIdArray as $value)
                {
                    array_push($headIdRecieveArray,$value);
                }
            }
            for($i=0; $i<sizeof($headIdRecieveArray); $i++)
            {
                $salaryHeadId = $headIdRecieveArray[$i];
                $salaryAmountVariable = 'amount_'.$salaryHeadId;
                $salaryHeadAmount = $this->input->post($salaryAmountVariable);
                $insertionData = array(
                    'employee_type_id' => $employeeTypeId,
                    'salary_head_id' => $salaryHeadId,
                    'salary_head_amount' => $salaryHeadAmount,
                    
                );
                $callInsertionMethod = $this->Operation_Model->insertInToTable('salaryearning',$insertionData);//passing table size with inserted data
            }
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                    $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name
                    $parsingData['successInsered'] = "Salary Setting Create Successfully!";
                    $this->load->view('pages/salary_earning', $parsingData);
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
                    $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                    $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/salary_earning', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'salaryearning', 'salaryearning_id');//passing table size and fields
                $parsingData['query'] = $this->Search_Model->GetSalaryEarningData($vDescp);//passing table size and fields
                $parsingData['employeeQuery'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['salaryTypeQuery'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
                $parsingData['counter'] = $this->Search_Model->numRec_page($vDescp, 'salarytype', 'salary_type_id');
                $parsingData['tableFeild1'] = 'employee_type_id';
                $parsingData['tableFeild2'] = 'employee_type_name';
                $parsingData['tableFeild3'] = 'salary_head_id';
                $parsingData['tableFeild4'] = 'salary_head_amount';
                $parsingData['tableFeild5'] = 'salary_type_name';
                $parsingData['controllerName'] = 'salary_earning';
                $this->load->view('pages/data_table_salary', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $employeeTypeId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['employee_type_id'] = $employeeTypeId;
            $parsingData['employee_type_name'] = $this->Operation_Model->getTableData('employee_type_name', $employeeTypeId, 'employee_type_id', 'employeetype');
            $parsingData['salary_head_amount'] = $this->Operation_Model->getParentTableData('employee_type_id', $employeeTypeId);
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name
            $this->load->view('pages/salary_earning', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $headIdRecieveArray = array();
        $employeeTypeId = $this->input->post('employee_type');
        $salaryHeadIdArray = $this->input->post('salaryHeadId');
        if ($salaryHeadIdArray)
        {
            foreach ($salaryHeadIdArray as $value)
            {
                array_push($headIdRecieveArray,$value);
            }
        }
        for($i=0; $i<sizeof($headIdRecieveArray); $i++)
        {
            $salaryHeadId = $headIdRecieveArray[$i];
            $salaryAmountVariable = 'amount_'.$salaryHeadId;
            $salaryHeadAmount = $this->input->post($salaryAmountVariable);
            $UpdateData = array(
                'salary_head_amount' => $salaryHeadAmount,

            );
             $callUpdateMethod = $this->Operation_Model->updateSalaryEarningTable('employee_type_id', 'salary_head_id', $employeeTypeId, $salaryHeadId, 'salaryearning', $UpdateData);//passing table size with inserted data
        }
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name
                $parsingData['successInsered'] = "Salary Setting Update Successfully!";
                $this->load->view('pages/salary_earning', $parsingData);
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
                $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name

                $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                $this->load->view('pages/salary_earning', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
        $salaryId =$this->uri->segment(3);
        //$callDeleteMethod = $this->Operation_Model->deleteTableData('salary_id', $salaryId, 'salaryearning');
        $callDeleteMethod2 = $this->Operation_Model->deleteTableData('employee_type_id', $salaryId, 'salaryearning');
        
        if($callDeleteMethod2 == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name
    
                $parsingData['successInsered'] = "Salary Deleted Successfully!";
                $this->load->view('pages/salary_earning', $parsingData);
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
                $parsingData['employeeType'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['salaryEarningHead'] = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['nextId'] = $this->Operation_Model->getNextId('salaryearning');// Passing the table name

                $parsingData['errorInsered'] = "An Error Has Been Occured While Deletion!";
                $this->load->view('pages/salary_earning', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}

