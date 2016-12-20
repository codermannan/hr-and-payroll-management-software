<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('designation');
        $parsingData['numrec'] = $this->Search_Model->numRec('designation');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('designation', 'designation_id');
        if($this->session->userdata('username'))
        {
            $parsingData['employee_type'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('designation');// Passing the table name
            $this->load->view('pages/designation', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('designationName', 'Designation Name', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('designation');// Passing the table name
            $this->load->view('pages/designation', $parsingData);
        }
        else
        {
            $designationName = $this->input->post('designationName');
            $employeeTypeId = $this->input->post('employee_type');
            $insertionData = array(
                'employee_type_id' => $employeeTypeId,
                'designation_name' => $designationName
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('designation',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['employee_type'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('designation');// Passing the table name
                    $parsingData['successInsered'] = "Designation Create Successfully!";
                    $this->load->view('pages/designation', $parsingData);
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
                    $parsingData['employee_type'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('designation');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/designation', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'designation', 'designation_id');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->GetDesignationData($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'designation_id';
                $parsingData['tableFeild2'] = 'designation_name';
                $parsingData['tableFeild3'] = 'employee_type_name';
                $parsingData['controllerName'] = 'designation';
                $this->load->view('pages/data_table_designation', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $designationId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['designation_name'] = $this->Operation_Model->getTableData('designation_name', $designationId, 'designation_id', 'designation');
            $employeeTypeId = $parsingData['employee_type_edit'] = $this->Operation_Model->getTableData('employee_type_id', $designationId, 'designation_id', 'designation');
            if(isset($employeeTypeId))
            {
                $parsingData['employee_type_name'] = $this->Operation_Model->getTableData('employee_type_name', $employeeTypeId, 'employee_type_id', 'employeetype');
            }
            $parsingData['employee_type'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
            $parsingData['designation_id'] = $designationId;
            $this->load->view('pages/designation', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $designationId = $this->input->post('designationCode');
        $designationName = $this->input->post('designationName');
        $employeeTypeId = $this->input->post('employee_type');
        $UpdateData = array(
                'employee_type_id' => $employeeTypeId,
                'designation_name' => $designationName,
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('designation_id', $designationId, 'designation', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['employee_type'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Designation Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('designation');// Passing the table name
                $this->load->view('pages/designation', $parsingData);
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
                $parsingData['employee_type'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('designation');// Passing the table name
                $this->load->view('pages/designation', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $designationId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('designation_id', $designationId, 'designation');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['employee_type'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Designation Deleted Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('designation');// Passing the table name
                $this->load->view('pages/designation', $parsingData);
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
                $parsingData['employee_type'] = $this->Operation_Model->getParentTable('employee_type_id', 'employee_type_name', 'employeetype');
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Has Been Occured While Deletion!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('designation');// Passing the table name
                $this->load->view('pages/designation', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
