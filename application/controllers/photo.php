<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends CI_Controller 
{
    private $pagesize = 10;
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
        $this->Search_Model->limit = 10;
        $this->Search_Model->Mostlimit = 1;
        $this->Search_Model->offset = $this->uri->segment(3);
        $parsingData['query'] = $this->Search_Model->listOfData('employee');
        $parsingData['numrec'] = $this->Search_Model->numRec('employee');
        $parsingData['requestNo'] = $this->Search_Model->getAllRequestCount('employee', 'employee_id'); 
        if($this->session->userdata('username'))
        {
            $parsingData['username'] = $this->session->userdata('username');
            $this->load->view('pages/photo', $parsingData);
        }
        else 
        {
            redirect('login', 'refresh');
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
                $parsingData['rec'] = $this->Search_Model->numRec_page($vDescp, 'employee', 'employee_name');//passing table name and fields
                $parsingData['query'] = $this->Search_Model->listOfData_page_photo($vDescp);//passing table name and fields
                $parsingData['tableFeild1'] = 'employee_id';
                $parsingData['tableFeild2'] = 'employee_pre_code';
                $parsingData['tableFeild3'] = 'employee_code';
                $parsingData['tableFeild4'] = 'employee_name';
                $parsingData['tableFeild5'] = 'designation_name';
                $parsingData['tableFeild6'] = 'employee_image_url';
                $this->load->view('pages/employee_data_photo', $parsingData);
        }
        else
        {
                redirect('login', 'refresh');
        }
    }
    function do_upload()
    {
        $empId = $this->input->post('empId');
        $fileName = $_FILES['userfile']['name'];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $renamePhoto = $empId.'.'.$ext;
        $deleteIfExists = './uploads/'.$empId.'/'.$renamePhoto;
        unlink($deleteIfExists);
        if (!file_exists('./uploads/'.$empId)) 
        {
            
            mkdir('./uploads/'.$empId, 0777, true);
        }
        
        $config['upload_path'] = './uploads/'.$empId.'/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['file_name'] = $renamePhoto;
        $this->load->library('upload', $config);
        $UpdateData = array(
                'employee_image_url' => $renamePhoto,
                );
        $this->Operation_Model->updateTable('employee_id', $empId, 'employee', $UpdateData);
        
        if ( ! $this->upload->do_upload())
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['errorInsered'] =  $this->upload->display_errors();
            $this->load->view('pages/photo', $parsingData);
        }
        else
        {
            $parsingData['username'] = $this->session->userdata('username');
            $parsingData['successInsered'] =  "Photo Uploaded Successfully";
            $this->load->view('pages/photo', $parsingData);
        }
    }
}
