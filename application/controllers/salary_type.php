<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_Type extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('salarytype');
        $parsingData['numrec'] = $this->Search_Model->numRec('salarytype');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('salarytype', 'salary_type_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('salarytype');// Passing the table name
            $this->load->view('pages/salary_type', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('salaryTypeName', 'Salary Type', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('salarytype');// Passing the table name
            $this->load->view('pages/salary_type', $parsingData);
        }
        else
        {
            $salaryTypeName = $this->input->post('salaryTypeName');
            
            $insertionData = array(
                'salary_type_name' => $salaryTypeName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('salarytype',$insertionData);//passing table size with inserted data
            $employeeQuery = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            
            foreach ($employeeQuery as $key => $value) {
                    $insertionData2 = array(
                    'employee_type_id' => $value['employee_type_id'],
                    'salary_head_id' => $salaryTypeId,
                );
                $callInsertionMethod = $this->Operation_Model->insertInToTable('salaryearning',$insertionData2);//passing table size with inserted data
            
            }
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('salarytype');// Passing the table size
                    $parsingData['successInsered'] = "Salary Type Create Successfully!";
                    $this->load->view('pages/salary_type', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('salarytype');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/salarytype', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'salarytype', 'salary_type_name');//passing table size and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_data($vDescp, 'salarytype', 'salary_type_id', 'salary_type_name');//passing table size and fields
                $parsingData['tableFeild1'] = 'salary_type_id';
                $parsingData['tableFeild2'] = 'salary_type_name';
                $parsingData['controllerName'] = 'salary_type';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $salaryTypeId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['salary_type_name'] = $this->Operation_Model->getTableData('salary_type_name', $salaryTypeId, 'salary_type_id', 'salarytype');
            $parsingData['salary_type_id'] = $salaryTypeId;
            $this->load->view('pages/salary_type', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $salaryTypeId = $this->input->post('salaryTypeId');
        $salaryTypeName = $this->input->post('salaryTypeName');
        $UpdateData = array(
                'salary_type_name' => $salaryTypeName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('salary_type_id', $salaryTypeId, 'salarytype', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Salary Type Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('salarytype');// Passing the table name
                $this->load->view('pages/salary_type', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('salarytype');// Passing the table size
                $this->load->view('pages/salary_type', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $salaryTypeId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('salary_type_id', $salaryTypeId, 'salarytype');
        $callDeleteMethod2 = $this->Operation_Model->deleteTableData('salary_head_id', $salaryTypeId, 'salaryearning');
        if($callDeleteMethod == TRUE && $callDeleteMethod2 == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Salary Type Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('salarytype');// Passing the table size
                $this->load->view('pages/salary_type', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('salarytype');// Passing the table name
                $this->load->view('pages/salary_type', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}

