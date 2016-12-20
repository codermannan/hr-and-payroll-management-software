<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Operation extends CI_Controller 
{
     private $pagesize = 5;
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
        
        if($this->session->userdata('username'))
        {
            
            $parsingData['productionOperation'] = $this->Search_Model->listOfData_productOperation();
            $parsingData['section'] = $this->Operation_Model->getParentTable('product_section_id', 'product_section_name', 'product_section');
            $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
            $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
            $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
            $parsingData['size'] = $this->Operation_Model->getParentTable('size_id', 'size_name', 'size');
            $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
            $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
            $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('production_operation');
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/product_operation', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        $this->form_validation->set_rules('section', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('buyer', 'Buyer', 'trim|required|xss_clean');
        $this->form_validation->set_rules('season', 'Season', 'trim|required|xss_clean');
        $this->form_validation->set_rules('style', 'Style', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gauge', 'Gauge', 'trim|required|xss_clean');
        $this->form_validation->set_rules('size', 'Size', 'trim|required|xss_clean');
        $this->form_validation->set_rules('unitmeasure', 'Unit Measure', 'trim|required|xss_clean');
        $this->form_validation->set_rules('rate', 'Rates', 'trim|required|xss_clean');
        if($this->form_validation->run() == FALSE) 
        {
            $parsingData['productionOperation'] = $this->Search_Model->listOfData_productOperation();
            $parsingData['section'] = $this->Operation_Model->getParentTable('product_section_id', 'product_section_name', 'product_section');
            $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
            $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
            $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
            $parsingData['size'] = $this->Operation_Model->getParentTable('size_id', 'size_name', 'size');
            $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
            $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
            $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('production_operation');
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/product_operation', $parsingData);
        }
        $section = $this->input->post('section');
        $buyer = $this->input->post('buyer');
        $season = $this->input->post('season');
        $style = $this->input->post('style');
        $gauge = $this->input->post('gauge');
        $size = $this->input->post('size');
        $unitmeasure = $this->input->post('unitmeasure');
        $rate = $this->input->post('rate');
        $majorpartsName = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
        $majorpartsNameString = "";
        foreach ($majorpartsName as $value)
        {
           $majorpartValue = $this->input->post('parts_'.$value['majorParts_id']);
           if(!empty($majorpartValue))
           { 
               $majorpartsNameString .=$majorpartValue.", "; 
           }
               
        }
       
        $insertionData = array(
                'section_id' => $section,
                'buyer_id' => $buyer,
                'season_id' => $season,
                'style_id' => $style,
                'gauge_id' => $gauge,
                'size_id' => $size,
                'major_parts' => $majorpartsNameString,
                'unitmeasur_id' => $unitmeasure,
                'rate' => $rate,
            );
        $callInsertionMethod = $this->Operation_Model->insertInToTable('production_operation',$insertionData);
        if($callInsertionMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['productionOperation'] = $this->Search_Model->listOfData_productOperation();
                    $parsingData['section'] = $this->Operation_Model->getParentTable('product_section_id', 'product_section_name', 'product_section');
                    $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
                    $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
                    $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
                    $parsingData['size'] = $this->Operation_Model->getParentTable('size_id', 'size_name', 'size');
                    $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                    $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
                    $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('production_operation');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Product Operation Create Successfully!";
                    $this->load->view('pages/product_operation', $parsingData);
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
                    $parsingData['productionOperation'] = $this->Search_Model->listOfData_productOperation();
                    $parsingData['section'] = $this->Operation_Model->getParentTable('product_section_id', 'product_section_name', 'product_section');
                    $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
                    $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
                    $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
                    $parsingData['size'] = $this->Operation_Model->getParentTable('size_id', 'size_name', 'size');
                    $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                    $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
                    $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('production_operation');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Insertion!";
                    $this->load->view('pages/product_operation', $parsingData);
                }
                else 
                {
                    redirect('login', 'refresh');
                }
            }
    }
    
    
    
    public function viewEdit()
    {
        $operationId =$this->uri->segment(3);
        if($this->session->userdata('username'))
        {
            $parsingData['productionOperation'] = $this->Search_Model->listOfData_productOperation();
            $parsingData['section'] = $this->Operation_Model->getParentTable('product_section_id', 'product_section_name', 'product_section');
            $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
            $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
            $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
            $parsingData['size'] = $this->Operation_Model->getParentTable('size_id', 'size_name', 'size');
            $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
            $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
            $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');

            $parsingData['section_id'] = $this->Operation_Model->getTableData('section_id', $operationId, 'operation_id', 'production_operation');
            $parsingData['buyer_id'] = $this->Operation_Model->getTableData('buyer_id', $operationId, 'operation_id', 'production_operation');
            $parsingData['season_id'] = $this->Operation_Model->getTableData('season_id', $operationId, 'operation_id', 'production_operation');
            $parsingData['style_id'] = $this->Operation_Model->getTableData('style_id', $operationId, 'operation_id', 'production_operation');
            $parsingData['size_id'] = $this->Operation_Model->getTableData('size_id', $operationId, 'operation_id', 'production_operation');
            $parsingData['unitmeasur_id'] = $this->Operation_Model->getTableData('unitmeasur_id', $operationId, 'operation_id', 'production_operation');
            $parsingData['gauge_id'] = $this->Operation_Model->getTableData('gauge_id', $operationId, 'operation_id', 'production_operation');

            $major_parts = $this->Operation_Model->getTableData('major_parts', $operationId, 'operation_id', 'production_operation');
            $parsingData['major_parts_array'] = explode(", ", $major_parts);
            $parsingData['rate'] = $this->Operation_Model->getTableData('rate', $operationId, 'operation_id', 'production_operation');
            
            if($parsingData['section_id'] != 0)
            {
                $parsingData['section_name'] = $this->Operation_Model->getTableData('product_section_name', $parsingData['section_id'], 'product_section_id', 'product_section');
            }
            if($parsingData['season_id'] != 0)
            {
                $parsingData['season_name'] = $this->Operation_Model->getTableData('season_name', $parsingData['season_id'], 'season_id', 'season');
            }
            if($parsingData['buyer_id'] != 0)
            {
                $parsingData['buyer_name'] = $this->Operation_Model->getTableData('buyer_name', $parsingData['buyer_id'], 'buyer_id', 'buyer');
            }
            if($parsingData['style_id'] != 0)
            {
                $parsingData['style_name'] = $this->Operation_Model->getTableData('style_name', $parsingData['style_id'], 'style_id', 'style');
            }
            if($parsingData['size_id'] != 0)
            {
                $parsingData['size_name'] = $this->Operation_Model->getTableData('size_name', $parsingData['size_id'], 'size_id', 'size');
            }
            if( $parsingData['unitmeasur_id'] != 0 )
            {
                $parsingData['measurement_name'] = $this->Operation_Model->getTableData('measurement_name', $parsingData['unitmeasur_id'], 'measurement_id', 'measurement');
            }

            if($parsingData['gauge_id'] != 0)
            {
                $parsingData['guage_size'] = $this->Operation_Model->getTableData('guage_size', $parsingData['gauge_id'], 'guage_id', 'guage');
            }

            $parsingData['operation_id'] = $operationId;
            $this->load->view('pages/product_operation', $parsingData);
        }
        else
        {
            redirect('login', 'refresh');
        }
    }
    
    public function edit()
    {
        $operationId = $this->input->post('operationId');
        $section = $this->input->post('section');
        $buyer = $this->input->post('buyer');
        $season = $this->input->post('season');
        $style = $this->input->post('style');
        $gauge = $this->input->post('gauge');
        $size = $this->input->post('size');
        $unitmeasure = $this->input->post('unitmeasure');
        $rate = $this->input->post('rate');
        $majorpartsName = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
        $majorpartsNameString = "";
        foreach ($majorpartsName as $value)
        {
           $majorpartValue = $this->input->post('parts_'.$value['majorParts_id']);
           if(!empty($majorpartValue))
           { 
               $majorpartsNameString .=$majorpartValue.", "; 
           }
               
        }
       
        $UpdateData = array(
                'section_id' => $section,
                'buyer_id' => $buyer,
                'season_id' => $season,
                'style_id' => $style,
                'gauge_id' => $gauge,
                'size_id' => $size,
                'major_parts' => $majorpartsNameString,
                'unitmeasur_id' => $unitmeasure,
                'rate' => $rate,
            );
        $callUpdateMethod =  $this->Operation_Model->updateTable('operation_id', $operationId, 'production_operation', $UpdateData);
        if($callUpdateMethod == TRUE)
            {
                if($this->session->userdata('username'))
                {
                    $parsingData['productionOperation'] = $this->Search_Model->listOfData_productOperation();
                    $parsingData['section'] = $this->Operation_Model->getParentTable('product_section_id', 'product_section_name', 'product_section');
                    $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
                    $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
                    $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
                    $parsingData['size'] = $this->Operation_Model->getParentTable('size_id', 'size_name', 'size');
                    $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                    $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
                    $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('production_operation');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['successInsered'] = "Product Operation Update Successfully!";
                    $this->load->view('pages/product_operation', $parsingData);
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
                    $parsingData['productionOperation'] = $this->Search_Model->listOfData_productOperation();
                    $parsingData['section'] = $this->Operation_Model->getParentTable('product_section_id', 'product_section_name', 'product_section');
                    $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
                    $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
                    $parsingData['size'] = $this->Operation_Model->getParentTable('size_id', 'size_name', 'size');
                    $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
                    $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
                    $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
                    $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
                    $parsingData['nextId'] = $this->Operation_Model->getNextId('production_operation');
                    $parsingData['username'] = $this->session->userdata('username');
                    $parsingData['errorInsered'] = "An Error Has Been Occured While Update!";
                    $this->load->view('pages/product_operation', $parsingData);
                }
                else 
                {
                    redirect('login', 'refresh');
                }
            }
    }
    
    function delete()
    {
        $operationId =$this->uri->segment(3);
        $this->Operation_Model->deleteTableData('operation_id', $operationId, 'production_operation');
        $this->Operation_Model->limit = 5;
        $this->Operation_Model->Mostlimit = 1;
        $this->Operation_Model->offset = $this->uri->segment(3);
        $parsingData['query'] = $this->Operation_Model->listOfData('production_operation');
        $parsingData['numrec'] = $this->Operation_Model->numRec('production_operation');
        $parsingData['requestNo'] = $this->Operation_Model->getAllRequestCount('production_operation', 'operation_id'); 
        
        $parsingData['successInsered'] = "Operation Has been Deleted Successfully!";
        if($this->session->userdata('username'))
        {
            $parsingData['productionOperation'] = $this->Search_Model->listOfData_productOperation();
            $parsingData['section'] = $this->Operation_Model->getParentTable('product_section_id', 'product_section_name', 'product_section');;
            $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
            $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
            $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
            $parsingData['size'] = $this->Operation_Model->getParentTable('size_id', 'size_name', 'size');
            $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
            $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
            $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('production_operation');
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/product_operation', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
}
