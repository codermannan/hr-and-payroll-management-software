<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_Bonus_Setup extends CI_Controller 
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
            $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
            $this->load->view('pages/production_bonus_setup', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('bonusTitle', 'Bonus Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bonusStart', 'Bonus Start', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bonusEnd', 'Bonus End', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bonusPercentage', 'Bonus Percentage', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
            $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/production_bonus_setup', $parsingData);
        }
        else
        {
            $designationId = $this->input->post('designation');
            $bonusTitle = $this->input->post('bonusTitle');
            $bonusStart = $this->input->post('bonusStart');
            $bonusEnd = $this->input->post('bonusEnd');
            $bonusPercentage = $this->input->post('bonusPercentage');
            
            $insertionData = array(
                'designation_id' => $designationId,
                'production_bonus_setup_title' => $bonusTitle,
                'production_bonus_setup_start' => $bonusStart,
                'production_bonus_setup_end' => $bonusEnd,
                'production_bonus_setup_percentage' => $bonusPercentage,
            );
            
            $callInsertionMethod = $this->Operation_Model->insertDataInToTable('production_bonus_setup',$insertionData);//passing table name with inserted data
            
            if(empty($callInsertionMethod))
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                    $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Productin Bonus Create Successfully!";
                    $this->load->view('pages/production_bonus_setup', $parsingData);
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
                    $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = $callInsertionMethod;
                    $this->load->view('pages/production_bonus_setup', $parsingData);
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
            $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['designation_id'] = $this->Operation_Model->getSingleDataOfTable('designation_id', 'production_bonus_setup_id', $systemId, 'production_bonus_setup');
            if(isset($parsingData['designation_id']))
            {
                $parsingData['designation_name'] = $this->Operation_Model->getSingleDataOfTable('designation_name', 'designation_id', $parsingData['designation_id'], 'designation');
            }
            $parsingData['production_bonus_setup_title'] = $this->Operation_Model->getSingleDataOfTable('production_bonus_setup_title', 'production_bonus_setup_id', $systemId, 'production_bonus_setup');
            $parsingData['production_bonus_setup_start'] = $this->Operation_Model->getSingleDataOfTable('production_bonus_setup_start', 'production_bonus_setup_id', $systemId, 'production_bonus_setup');
            $parsingData['production_bonus_setup_end'] = $this->Operation_Model->getSingleDataOfTable('production_bonus_setup_end', 'production_bonus_setup_id', $systemId, 'production_bonus_setup');
            $parsingData['production_bonus_setup_percentage'] = $this->Operation_Model->getSingleDataOfTable('production_bonus_setup_percentage', 'production_bonus_setup_id', $systemId, 'production_bonus_setup');
            $parsingData['production_bonus_setup_id'] = $systemId;
            $this->load->view('pages/production_bonus_setup', $parsingData);
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
        $bonusPercentage = $this->input->post('bonusPercentage');
        $systemId = $this->input->post('systemId');
        $UpdateData = array(
            'designation_id' => $designationId,
            'production_bonus_setup_title' => $bonusTitle,
            'production_bonus_setup_start' => $bonusStart,
            'production_bonus_setup_end' => $bonusEnd,
            'production_bonus_setup_percentage' => $bonusPercentage,
        );
        $callUpdateMethod = $this->Operation_Model->updateTable('production_bonus_setup_id', $systemId, 'production_bonus_setup', $UpdateData);
        if($callUpdateMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Productin Bonus Update Successfully!";
                $this->load->view('pages/production_bonus_setup', $parsingData);
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
                $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Occured While Update!";
                $this->load->view('pages/production_bonus_setup', $parsingData);
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
        $callDeleteMethod = $this->Operation_Model->deleteTableData('production_bonus_setup_id', $SystemId, 'production_bonus_setup');
        if($callDeleteMethod == TRUE)
        {
            if($this->session->userdata('username'))
            {
                $parsingData['designation'] = $this->Operation_Model->getAllDataFromTable('designation');
                $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['successInsered'] = "Productin Bonus Delete Successfully!";
                $this->load->view('pages/production_bonus_setup', $parsingData);
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
                $parsingData['productionBonusSetupTableData'] = $this->Search_Model->getProductionBonusSetupDataFromTable();
                $parsingData['username'] = $this->session->userdata('username');
                $parsingData['errorInsered'] = "An Error Occured While Deletion!";
                $this->load->view('pages/production_bonus_setup', $parsingData);
            }
            else 
            {
                redirect('login', 'refresh');
            }
        }
    }
}