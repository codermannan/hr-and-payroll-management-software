<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_Type extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('employeetype');
        $parsingData['numrec'] = $this->Search_Model->numRec('employeetype');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('employeetype', 'employee_type_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('employeetype');// Passing the table name
            $this->load->view('pages/employee_type', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('employeeTypeName', 'Employee Type Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('employeetype');// Passing the table name
            $this->load->view('pages/employee_type', $parsingData);
        }
        else
        {
            $employeeTypeName = $this->input->post('employeeTypeName');
            
            $insertionData = array(
                'employee_type_name' => $employeeTypeName
            );
            
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('employeetype',$insertionData);//passing table name with inserted data
            $salaryHeadQuery = $this->Operation_Model->getParentTable('salary_type_id', 'salary_type_name', 'salarytype');
            
            foreach ($salaryHeadQuery as $key => $value) {
                    $insertionData2 = array(
                    'employee_type_id' => $employeeTypeCode,
                    'salary_head_id' => $value['salary_type_id'],
                );
                $callInsertionMethod = $this->Operation_Model->insertInToTable('salaryearning',$insertionData2);//passing table size with inserted data
            
            }
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('employeetype');// Passing the table name
                    $parsingData['successInsered'] = "Employee Type Create Successfully!";
                    $this->load->view('pages/employee_type', $parsingData);
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
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('employeetype');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/employee_type', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'employeetype', 'employee_type_id');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'employeetype', 'employee_type_id', 'employee_type_name');//passing table name and fields
                $parsingData['tableFeild1'] = 'employee_type_id';
                $parsingData['tableFeild2'] = 'employee_type_name';
                $parsingData['controllerName'] = 'employee_type';
                $this->load->view('pages/data_table', $parsingData);
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
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['employee_type_name'] = $this->Operation_Model->getTableData('employee_type_name', $employeeTypeId, 'employee_type_id', 'employeetype');
            $parsingData['employee_type_id'] = $employeeTypeId;
            $this->load->view('pages/employee_type', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $employeeTypeCode = $this->input->post('employeeTypeCode');
        $employeeTypeName = $this->input->post('employeeTypeName');
        $UpdateData = array(
                'employee_type_name' => $employeeTypeName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('employee_type_id', $employeeTypeCode, 'employeetype', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Employee Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('employeetype');// Passing the table name
                $this->load->view('pages/employee_type', $parsingData);
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
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('employeetype');// Passing the table name
                $this->load->view('pages/employee_type', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
        $employeeTypeName =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('employee_type_id', $employeeTypeName, 'employeetype');
        $callDeleteMethod2 = $this->Operation_Model->deleteTableData('employee_type_id', $employeeTypeName, 'salaryearning');
        
        if($callDeleteMethod == TRUE || $callDeleteMethod2 == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Employee Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('employeetype');// Passing the table name
                $this->load->view('pages/employee_type', $parsingData);
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
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Deletion!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('employeetype');// Passing the table name
                $this->load->view('pages/employee_type', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
