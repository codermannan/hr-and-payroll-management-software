<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance extends CI_Controller 
{
    private $pagesize = 10;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Search_Model');
        $this->load->model('Operation_Model');
    }
    
    public function index()
    {
        $this->Search_Model->limit = 10;
        $this->Search_Model->Mostlimit = 1;
        $this->Search_Model->offset = $this->uri->segment(3);
        $parsingData['query'] = $this->Search_Model->listOfData('attendance');
        $parsingData['numrec'] = $this->Search_Model->numRec('attendance');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('attendance', 'attendance_id');
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('attendance');// Passing the table name
            $this->load->view('pages/attendance', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('attendanceName', 'Attendance Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('attendanceShortCode', 'Attendance Short Code', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('attendance');// Passing the table name
            $this->load->view('pages/attendance', $parsingData);
        }
        else
        {
            $attendanceName = $this->input->post('attendanceName');
            $attendanceShortCode = $this->input->post('attendanceShortCode');
            
            $insertionData = array(
                'attendance_name' => $attendanceName,
                'attendance_short_code' => $attendanceShortCode
            );
            
            $callInsertionMethod = $this->Operation_Model->insertInToTable('attendance',$insertionData);//passing table name with inserted data
            
            if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('attendance');// Passing the table name
                    $parsingData['successInsered'] = "Attendance Create Successfully!";
                    $this->load->view('pages/attendance', $parsingData);
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
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('attendance');// Passing the table name
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/attendance', $parsingData);
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'attendance', 'attendance_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page($vDescp, 'attendance', 'attendance_id', 'attendance_name', 'attendance_short_code');//passing table name and fields
                $parsingData['tableFeild1'] = 'attendance_id';
                $parsingData['tableFeild2'] = 'attendance_name';
                $parsingData['tableFeild3'] = 'attendance_short_code';
                $parsingData['controllerName'] = 'attendance';
                $this->load->view('pages/data_table', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function viewEdit()
    {
        $attendanceId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['attendance_name'] = $this->Operation_Model->getTableData('attendance_name', $attendanceId, 'attendance_id', 'attendance');
            $parsingData['attendance_short_code'] = $this->Operation_Model->getTableData('attendance_short_code', $attendanceId, 'attendance_id', 'attendance');
            $parsingData['attendance_id'] = $attendanceId;
            $this->load->view('pages/attendance', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $attendanceId = $this->input->post('attendanceCode');
        $attendanceName = $this->input->post('attendanceName');
        $attendanceShortCode = $this->input->post('attendanceShortCode');
        $UpdateData = array(
                'attendance_name' => $attendanceName,
                'attendance_short_code' => $attendanceShortCode
                );
        $callUpdateMethod = $this->Operation_Model->updateTable('attendance_id', $attendanceId, 'attendance', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Attendance Update Successfully!";
                $parsingData['nextId'] = $this->Operation_Model->getNextId('attendance');// Passing the table name
                $this->load->view('pages/attendance', $parsingData);
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
                $parsingData['nextId'] = $this->Operation_Model->getNextId('attendance');// Passing the table name
                $this->load->view('pages/attendance', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
    
    function delete()
    {
       $unitId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('attendance_id', $unitId, 'attendance');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Attendance Deleted Successfully!";
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('unit');// Passing the table name
                $this->load->view('pages/attendance', $parsingData);
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
                 $parsingData['nextId'] = $this->Operation_Model->getNextId('attendance');// Passing the table name
                $this->load->view('pages/attendance', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}
