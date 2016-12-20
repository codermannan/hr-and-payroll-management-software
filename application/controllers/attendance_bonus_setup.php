<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_Bonus_Setup extends CI_Controller 
{
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
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
            $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
            $this->load->view('pages/attendance_bonus_setup', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('bonusTitle', 'Bonus Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bonusStart', 'Start Range', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bonusEnd', 'End Range', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
            $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/attendance_bonus_setup', $parsingData);
        }
        else
        {
            $designationId = $this->input->post('designation');
            $bonusTitle = $this->input->post('bonusTitle');
            $bonusStart = $this->input->post('bonusStart');
            $bonusEnd = $this->input->post('bonusEnd');
            $fixedBonus = $this->input->post('fixedBonus');
            $bonusPercentage = $this->input->post('bonusPercentage');
            
            $insertionData = array(
                'designation_id' => $designationId,
                'attendance_bonus_setup_title' => $bonusTitle,
                'attendance_bonus_setup_start' => $bonusStart,
                'attendance_bonus_setup_end' => $bonusEnd,
                'attendance_bonus_setup_fixed' => $fixedBonus,
                'attendance_bonus_setup_percentage' => $bonusPercentage,
            );
            
            $callInsertionMethod = $this->Operation_Model->insertDataInToTable('attendance_bonus_setup',$insertionData);//passing table name with inserted data
            
            if(empty($callInsertionMethod))
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                    $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Productin Bonus Create Successfully!";
                    $this->load->view('pages/attendance_bonus_setup', $parsingData);
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
                    $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                    $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = $callInsertionMethod;
                    $this->load->view('pages/attendance_bonus_setup', $parsingData);
                }
                else 
                {
                    redirect('login', 'refresh');
                }
            }
        }
    }
    
    function viewEdit()
    {
        $systemId =$this->uri->segment(3);
        
        if($this->session->userdata('username'))
        {
            $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
            $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['designation_id'] = $this->Operation_Model->getSingleDataOfTable('designation_id', 'attendance_bonus_setup_id', $systemId, 'attendance_bonus_setup');
            if(isset($parsingData['designation_id']))
            {
                $parsingData['designation_name'] = $this->Operation_Model->getSingleDataOfTable('designation_name', 'designation_id', $parsingData['designation_id'], 'designation');
            }
            $parsingData['attendance_bonus_setup_title'] = $this->Operation_Model->getSingleDataOfTable('attendance_bonus_setup_title', 'attendance_bonus_setup_id', $systemId, 'attendance_bonus_setup');
            $parsingData['attendance_bonus_setup_start'] = $this->Operation_Model->getSingleDataOfTable('attendance_bonus_setup_start', 'attendance_bonus_setup_id', $systemId, 'attendance_bonus_setup');
            $parsingData['attendance_bonus_setup_end'] = $this->Operation_Model->getSingleDataOfTable('attendance_bonus_setup_end', 'attendance_bonus_setup_id', $systemId, 'attendance_bonus_setup');
            $parsingData['attendance_bonus_setup_fixed'] = $this->Operation_Model->getSingleDataOfTable('attendance_bonus_setup_fixed', 'attendance_bonus_setup_id', $systemId, 'attendance_bonus_setup');
            $parsingData['attendance_bonus_setup_percentage'] = $this->Operation_Model->getSingleDataOfTable('attendance_bonus_setup_percentage', 'attendance_bonus_setup_id', $systemId, 'attendance_bonus_setup');
            $parsingData['attendance_bonus_setup_id'] = $systemId;
            $this->load->view('pages/attendance_bonus_setup', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    function edit()
    {
        $designationId = $this->input->post('designation');
        $bonusTitle = $this->input->post('bonusTitle');
        $bonusStart = $this->input->post('bonusStart');
        $bonusEnd = $this->input->post('bonusEnd');
        $fixedBonus = $this->input->post('fixedBonus');
        $bonusPercentage = $this->input->post('bonusPercentage');
        $systemId = $this->input->post('systemId');
        $UpdateData = array(
            'designation_id' => $designationId,
            'attendance_bonus_setup_title' => $bonusTitle,
            'attendance_bonus_setup_start' => $bonusStart,
            'attendance_bonus_setup_end' => $bonusEnd,
            'attendance_bonus_setup_fixed' => $fixedBonus,
            'attendance_bonus_setup_percentage' => $bonusPercentage,
        );
        $callUpdateMethod = $this->Operation_Model->updateTable('attendance_bonus_setup_id', $systemId, 'attendance_bonus_setup', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Productin Bonus Update Successfully!";
                $this->load->view('pages/attendance_bonus_setup', $parsingData);
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
                $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Occured While Update!";
                $this->load->view('pages/attendance_bonus_setup', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
        
    }
    
    function delete()
    {
        $SystemId =$this->uri->segment(3);
        $callDeleteMethod = $this->Operation_Model->deleteTableData('attendance_bonus_setup_id', $SystemId, 'attendance_bonus_setup');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Productin Bonus Delete Successfully!";
                $this->load->view('pages/attendance_bonus_setup', $parsingData);
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
                $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                $parsingData['attendanceBonusSetupTableData'] = $this->Search_Model->getAttendanceBonusSetupDataFromTable();
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Occured While Deletion!";
                $this->load->view('pages/attendance_bonus_setup', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}