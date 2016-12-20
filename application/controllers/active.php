<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Active extends CI_Controller 
{
     private $pagesize = 20;
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
        $this->Search_Model->limit = 20;
        $this->Search_Model->Mostlimit = 1;
        $this->Search_Model->offset = $this->uri->segment(3);
        $parsingData['query'] = $this->Search_Model->listOfData('production_operation');
        $parsingData['numrec'] = $this->Search_Model->numRec('production_operation');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('production_operation', 'operation_id'); 
        if($this->session->userdata('username'))
        {
            
            $parsingData['section'] = $this->Operation_Model->getParentTable('section_id', 'section_name', 'section');
            $parsingData['buyer'] = $this->Operation_Model->getParentTable('buyer_id', 'buyer_name', 'buyer');
            $parsingData['season'] = $this->Operation_Model->getParentTable('season_id', 'season_name', 'season');
            $parsingData['style'] = $this->Operation_Model->getParentTable('style_id', 'style_name', 'style');
            $parsingData['gauge'] = $this->Operation_Model->getParentTable('guage_id', 'guage_size', 'guage');
            $parsingData['unitmeasure'] = $this->Operation_Model->getParentTable('measurement_id', 'measurement_name', 'measurement');
            $parsingData['majorParts'] = $this->Operation_Model->getParentTable('majorParts_id', 'majorParts_name', 'majorparts');
            $parsingData['nextId'] = $this->Operation_Model->getNextId('production_operation');
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/active', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    public function submitData()
    {
        
        
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'production_operation', 'operation_id');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_productOperation($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'operation_id';
                $parsingData['tableFeild2'] = 'section_name';
                $parsingData['tableFeild3'] = 'buyer_name';
                $parsingData['tableFeild4'] = 'season_name';
                $parsingData['tableFeild5'] = 'style_name';
                $parsingData['tableFeild6'] = 'guage_size';
                $parsingData['tableFeild7'] = 'size';
                $parsingData['tableFeild8'] = 'measurement_name';
                $parsingData['tableFeild9'] = 'major_parts';
                $parsingData['tableFeild10'] = 'rate';
                $parsingData['controllerName'] = 'active';
                $this->load->view('pages/active_table_data', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    
    
}
