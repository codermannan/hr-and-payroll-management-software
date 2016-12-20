<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_Deduct extends CI_Controller 
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
        $parsingData['query'] = $this->Search_Model->listOfData('salarydeduct');
        $parsingData['numrec'] = $this->Search_Model->numRec('salarydeduct');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('salarydeduct', 'salary_deduct_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('salarydeduct');// Passing the table name
            $this->load->view('pages/salary_deduct', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('salaryAdvance', 'Advance', 'trim|required|xss_clean');
        $this->form_validation->set_rules('salaryPFfund', 'PF Fund', 'trim|required|xss_clean');
        $this->form_validation->set_rules('salaryOtherDeduct', 'Other Deduction', 'trim|required|xss_clean');
         if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('salarydeduct');// Passing the table name
            $this->load->view('pages/salary_deduct', $parsingData);
        }
        else
        {
            $salaryAdvance = $this->input->post('salaryAdvance');
            $salaryPFfund = $this->input->post('salaryPFfund');
            $salaryOtherDeduct = $this->input->post('salaryOtherDeduct');
             
            $insertionData = array(
                'salary_deduct_advance' => $salaryAdvance,
                'salary_deduct_pf' => $salaryPFfund,
                'salary_deduct_other' => $salaryOtherDeduct,
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('salarydeduct',$insertionData);//passing table size with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('salarydeduct');// Passing the table size
                    $parsingData['successInsered'] = "Salary Setting Create Successfully!";
                    $this->load->view('pages/salary_deduct', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('salarydeduct');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/salary_deduct', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'salarydeduct', 'salary_deduct_id');//passing table size and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_deduct($vDescp, 'salarydeduct', 'salary_deduct_id', 'salary_deduct_advance', 'salary_deduct_pf','salary_deduct_other');//passing table size and fields
                $parsingData['tableFeild1'] = 'salary_deduct_id';
                $parsingData['tableFeild2'] = 'salary_deduct_advance';
                $parsingData['tableFeild3'] = 'salary_deduct_pf';
                $parsingData['tableFeild4'] = 'salary_deduct_other';
                $parsingData['controllerName'] = 'salary_deduct';
                $this->load->view('pages/data_table_deduct', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $salaryId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['salary_deduct_advance'] = $this->Operation_Model->getTableData('salary_deduct_advance', $salaryId, 'salary_deduct_id', 'salarydeduct');
            $parsingData['salary_deduct_pf'] = $this->Operation_Model->getTableData('salary_deduct_pf', $salaryId, 'salary_deduct_id', 'salarydeduct');
            $parsingData['salary_deduct_other'] = $this->Operation_Model->getTableData('salary_deduct_other', $salaryId, 'salary_deduct_id', 'salarydeduct');
            $parsingData['salary_deduct_id'] = $salaryId;
            $this->load->view('pages/salary_deduct', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $salaryDeductId = $this->input->post('salaryDeductId');
        $salaryAdvance = $this->input->post('salaryAdvance');
        $salaryPFfund = $this->input->post('salaryPFfund');
        $salaryOtherDeduct = $this->input->post('salaryOtherDeduct');
            
        $updateData = array(
                'salary_deduct_advance' => $salaryAdvance,
                'salary_deduct_pf' => $salaryPFfund,
                'salary_deduct_other' => $salaryOtherDeduct,
            );
        $callUpdateMethod = $this->Operation_Model->updateTable('salary_deduct_id', $salaryDeductId, 'salarydeduct', $updateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Salary Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('salarydeduct');// Passing the table name
                $this->load->view('pages/salary_deduct', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('salarydeduct');// Passing the table size
                $this->load->view('pages/salary_deduct', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $salaryDeductId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('salary_deduct_id', $salaryDeductId, 'salarydeduct');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Salary Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('salarydeduct');// Passing the table size
                $this->load->view('pages/salary_deduct', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('salarydeduct');// Passing the table name
                $this->load->view('pages/salary_deduct', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}

