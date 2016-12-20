<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');


    function calculateattendance($empId,$salaryDays,$month)
    {
        $CI = get_instance();
        $CI->load->model('search_model');
        $attenDays = $CI->Search_Model->searchempAttendanceData($empId,$salaryDays,$month);
        return $attenDays;
    }

