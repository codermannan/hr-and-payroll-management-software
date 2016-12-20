<?php
class Search_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    
    public function listOfData($tableName) 
    {
        $query = $this->db->limit($this->limit, $this->offset)->get($tableName);
        return $query->result_array();
    }

    public function listOfData_page($descp, $tableName, $tableFieldId, $fieldName1, $fieldName2) 
    {
        $query = $this->db->select('*')->from($tableName)->like($tableFieldId, $descp)->or_like($fieldName1, $descp)->or_like($fieldName2, $descp)->order_by($fieldName1, 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    
    
    public function listOfData_page_deduct($descp, $tableName, $tableFieldId, $fieldName1, $fieldName2, $fieldName3)
    {
        $query = $this->db->select('*')->from($tableName)->like($tableFieldId, $descp)->or_like($fieldName1, $descp)->or_like($fieldName2, $descp)->or_like($fieldName3, $descp)->order_by($tableFieldId, 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    public function listOfData_page_data($descp, $tableName, $tableFieldId, $fieldName1) 
    {
        $query = $this->db->select('*')->from($tableName)->like($tableFieldId, $descp)->or_like($fieldName1, $descp)->order_by($fieldName1, 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    
    public function numRec($tableName) 
    {
        $result = $this->db->from($tableName);
        return $result->count_all();
    }

    public function numRec_page($descp, $tableName, $tableFieldName) 
    {
        $result = $this->db->like($tableFieldName, $descp)->from($tableName)->count_all_results();
        return $result;
    }

    public function getAllRequestCount($tableName, $tableFieldId)
    {
            $sql = "SELECT $tableFieldId FROM $tableName";
            $query = $this->db->query($sql);

            return $query->num_rows();
    }

 public function GetFloorData($descp) 
    {
        $query = $this->db->select('floor.floor_id, floor.floor_name, floor.floor_short_code, unit.unit_name')->from('floor')->join('unit', 'floor.unit_id=unit.unit_id', 'left')->like('floor.floor_id', $descp)->or_like('floor.floor_name', $descp)->or_like('floor.floor_short_code', $descp)->or_like('unit.unit_name', $descp)->order_by('floor.floor_name', 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    public function GetSectionData($descp) 
    {
        $query = $this->db->select('section.section_id, section.section_name, section.section_short_code, floor.floor_name, unit.unit_name')->from('section')->join('floor', 'section.floor_id=floor.floor_id', 'left')->join('unit', 'floor.unit_id=unit.unit_id', 'left')->like('section.section_id', $descp)->or_like('unit.unit_name', $descp)->or_like('section.section_name', $descp)->or_like('section.section_short_code', $descp)->or_like('floor.floor_name', $descp)->order_by('section.section_name', 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    public function GetSubsectionData($descp) 
    {
        $query = $this->db->select('subsection.subsection_id, subsection.subsection_name, section.section_name,  floor.floor_name, unit.unit_name')->from('subsection')->join('section', 'subsection.section_id=section.section_id', 'left')->join('floor', 'section.floor_id=floor.floor_id', 'left')->join('unit', 'floor.unit_id=unit.unit_id', 'left')->like('subsection.subsection_id', $descp)->or_like('subsection.subsection_name', $descp)->or_like('unit.unit_name', $descp)->or_like('floor.floor_name', $descp)->or_like('section.section_name', $descp)->order_by('subsection.subsection_name', 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    public function GetInchargeData($descp) 
    {
        $query = $this->db->select('incharge.incharge_id, incharge.incharge_name, subsection.subsection_name, incharge.guage_name, section.section_name,  floor.floor_name, unit.unit_name')->from('incharge')->join('subsection', 'incharge.subsection_id=subsection.subsection_id', 'left')->join('section', 'subsection.section_id=section.section_id', 'left')->join('floor', 'section.floor_id=floor.floor_id', 'left')->join('unit', 'floor.unit_id=unit.unit_id', 'left')->like('incharge.incharge_id', $descp)->or_like('unit.unit_name', $descp)->or_like('floor.floor_name', $descp)->or_like('incharge.incharge_name', $descp)->or_like('incharge.guage_name', $descp)->or_like('subsection.subsection_name', $descp)->order_by('incharge.incharge_name', 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    public function GetSupervisorData($descp) 
    {
        $query = $this->db->select('supervisor.supervisor_id, supervisor.supervisor_name, supervisor.blockline_name, supervisor.majorpart_name, incharge.incharge_name, subsection.subsection_name, incharge.guage_name, section.section_name,  floor.floor_name, unit.unit_name')->from('supervisor')->join('incharge', 'supervisor.incharge_id=incharge.incharge_id', 'left')->join('subsection', 'incharge.subsection_id=subsection.subsection_id', 'left')->join('section', 'subsection.section_id=section.section_id', 'left')->join('floor', 'section.floor_id=floor.floor_id', 'left')->join('unit', 'floor.unit_id=unit.unit_id', 'left')->like('supervisor.supervisor_id', $descp)->or_like('unit.unit_name', $descp)->or_like('section.section_name', $descp)->or_like('subsection.subsection_name', $descp)->or_like('floor.floor_name', $descp)->or_like('supervisor.supervisor_name', $descp)->or_like('supervisor.blockline_name', $descp)->or_like('supervisor.majorpart_name', $descp)->or_like('incharge.incharge_name', $descp)->order_by('supervisor.supervisor_name', 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    public function GetDesignationData($descp) 
    {
        $query = $this->db->select('designation.designation_id, designation.designation_name, employeetype.employee_type_name')->from('designation')->join('employeetype', 'designation.employee_type_id=employeetype.employee_type_id', 'left')->like('designation.designation_id', $descp)->or_like('employeetype.employee_type_name', $descp)->or_like('designation.designation_name', $descp)->order_by('designation.designation_name', 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    
    public function GetSalaryEarningData($descp) 
    {
        $query = $this->db->select('salaryearning.employee_type_id, salaryearning.salary_head_id, salaryearning.salary_head_amount, employeetype.employee_type_name, salarytype.salary_type_name')->from('salaryearning')->join('employeetype', 'employeetype.employee_type_id=salaryearning.employee_type_id', 'left')->join('salarytype', 'salarytype.salary_type_id=salaryearning.salary_head_id', 'left')->like('employeetype.employee_type_name', $descp)->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    public function searchEmployeeData($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId)
    {
        if($unitId == 0)
        {
           $unitId = ''; 
        }
        if($floorId == 0)
        {
           $floorId = ''; 
        }
        if($sectionId == 0)
        {
           $sectionId = ''; 
        }
        if($subSectionId == 0)
        {
           $subSectionId = ''; 
        }
        if($inchargeId == 0)
        {
           $inchargeId = ''; 
        }
        if($supervisorId == 0)
        {
           $supervisorId = ''; 
        }
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, designation.designation_name, designation.designation_id')
        ->from('employee')->join('designation', 'employee.designation_id=designation.designation_id', 'left')
        ->like('employee.unit_id', $unitId)
        ->like('employee.floor_id', $floorId)
       ->like('employee.section_id', $sectionId)
        ->like('employee.subsection_id', $subSectionId)
        ->like('employee.incharge_id', $inchargeId)
        ->like('employee.supervisor_id', $supervisorId)
        ->order_by('employee.employee_name', 'asc')
       ->get('');
       return $sql->result_array();
    
    }
    
    
    public function searchEmployeeSalary($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId)
    {
        if($unitId == 0)
        {
           $unitId = ''; 
        }
        if($floorId == 0)
        {
           $floorId = ''; 
        }
        if($sectionId == 0)
        {
           $sectionId = ''; 
        }
        if($subSectionId == 0)
        {
           $subSectionId = ''; 
        }
        if($inchargeId == 0)
        {
           $inchargeId = ''; 
        }
        if($supervisorId == 0)
        {
           $supervisorId = ''; 
        }
        $this->db->select('employee.employee_id, salary.salary_head_amount');
        $this->db->from('employee');
        $this->db->join('salary','salary.employee_id=employee.employee_id', 'left');
        $this->db->like('employee.unit_id', $unitId);
        $this->db->like('employee.floor_id', $floorId);
        $this->db->like('employee.section_id', $sectionId);
        $this->db->like('employee.subsection_id', $subSectionId);
        $this->db->like('employee.incharge_id', $inchargeId);
        $this->db->like('employee.supervisor_id', $supervisorId);
        $this->db->order_by('employee.employee_name', 'asc');
        $query = $this->db->get('');
        return $query->result_array(); 
    }
    public function searchEmployeeSalaryMonth($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId, $month)
    {
        if($unitId == 0)
        {
           $unitId = ''; 
        }
        if($floorId == 0)
        {
           $floorId = ''; 
        }
        if($sectionId == 0)
        {
           $sectionId = ''; 
        }
        if($subSectionId == 0)
        {
           $subSectionId = ''; 
        }
        if($inchargeId == 0)
        {
           $inchargeId = ''; 
        }
        if($supervisorId == 0)
        {
           $supervisorId = ''; 
        }
        $this->db->select('employee.employee_id, salary.salary_head_amount, attendance_bonus.attendance_bonus_month');
        $this->db->from('employee');
        $this->db->join('salary','salary.employee_id=employee.employee_id', 'left');
        $this->db->join('attendance_bonus','attendance_bonus.employee_id=employee.employee_id', 'left');
        $this->db->like('employee.unit_id', $unitId);
        $this->db->like('employee.floor_id', $floorId);
        $this->db->like('employee.section_id', $sectionId);
        $this->db->like('employee.subsection_id', $subSectionId);
        $this->db->like('employee.incharge_id', $inchargeId);
        $this->db->like('employee.supervisor_id', $supervisorId);
        $this->db->where('attendance_bonus.attendance_bonus_month !=', $month);
        $this->db->order_by('employee.employee_name', 'asc');
        //echo $this->db->last_query();
        $query = $this->db->get('');
        return $query->result_array(); 
    }
    public function calculatePaidDays($month)
    {
        $this->db->select('employee.employee_id, salary_sheet.salary_sheet_days');
        $this->db->from('employee');
        $this->db->join('salary_sheet','salary_sheet.employee_id=employee.employee_id', 'left');
        $this->db->where('salary_sheet_month', $month);
        $query = $this->db->get('');
        return $query->result_array(); 
    }
    


   
    public function searchProductionData($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId,$month)
    {
        //New Edit Start
        if($unitId == 0)
        {
           $unitId = ''; 
        }
        if($floorId == 0)
        {
           $floorId = ''; 
        }
        if($sectionId == 0)
        {
           $sectionId = ''; 
        }
        if($subSectionId == 0)
        {
           $subSectionId = ''; 
        }
        if($inchargeId == 0)
        {
           $inchargeId = ''; 
        }
        if($supervisorId == 0)
        {
           $supervisorId = ''; 
        }
        
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, 
            designation.designation_name, designation.designation_id,
            sum(production.production_quantity) as production_quantity, 
            sum(production_operation.rate*production.production_quantity) as rate, 
            ')
        ->like('employee.unit_id', $unitId)
        ->like('employee.floor_id', $floorId)
        ->like('employee.section_id', $sectionId)
        ->like('employee.subsection_id', $subSectionId)
        ->like('employee.incharge_id', $inchargeId)
        ->like('employee.supervisor_id', $supervisorId)
        ->join('employee', 'employee.employee_id=production.employee_id', 'left')
        ->join('production_operation', 'production.production_operation_id=production_operation.operation_id', 'left')
        ->join('production_bonus','production_bonus.employee_id=production.employee_id', 'left')
        ->join('designation','designation.designation_id=employee.designation_id','left')
        ->where('production.employee_id NOT IN (SELECT production_bonus.employee_id from production_bonus where production_bonus.production_bonus_month='.$month.')')
        ->group_by('employee.employee_id')
        ->get('production');
        //echo $this->db->last_query();
        return $sql->result_array(); 
    }

    public function searchEmployeeDataOvertimeBonus($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId, $month, $year)
    {
        //New Edit Start
        if($unitId == 0)
        {
           $unitId = ''; 
        }
        if($floorId == 0)
        {
           $floorId = ''; 
        }
        if($sectionId == 0)
        {
           $sectionId = ''; 
        }
        if($subSectionId == 0)
        {
           $subSectionId = ''; 
        }
        if($inchargeId == 0)
        {
           $inchargeId = ''; 
        }
        if($supervisorId == 0)
        {
           $supervisorId = ''; 
        }
        
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, 
            designation.designation_name, designation.designation_id,
            ')
        ->like('employee.unit_id', $unitId)
        ->like('employee.floor_id', $floorId)
        ->like('employee.section_id', $sectionId)
        ->like('employee.subsection_id', $subSectionId)
        ->like('employee.incharge_id', $inchargeId)
        ->like('employee.supervisor_id', $supervisorId)
        ->join('overtime_bonus','overtime_bonus.employee_id=employee.employee_id', 'left')
        ->join('designation','designation.designation_id=employee.designation_id','left')
        ->where('employee.employee_id NOT IN (SELECT overtime_bonus.employee_id from overtime_bonus where overtime_bonus.overtime_bonus_month='.$month. ' and overtime_bonus.overtime_bonus_year='.$year.')')
        ->group_by('employee.employee_id')
        ->get('employee');
        //echo $this->db->last_query();
        return $sql->result_array(); 
    }
    

    public function searchAttendanceBonusData($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId, $month)
    {
        //New Edit Start
        if($unitId == 0)
        {
           $unitId = ''; 
        }
        if($floorId == 0)
        {
           $floorId = ''; 
        }
        if($sectionId == 0)
        {
           $sectionId = ''; 
        }
        if($subSectionId == 0)
        {
           $subSectionId = ''; 
        }
        if($inchargeId == 0)
        {
           $inchargeId = ''; 
        }
        if($supervisorId == 0)
        {
           $supervisorId = ''; 
        }
       
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, 
            designation.designation_name, designation.designation_id,
            sum(salary.salary_head_amount) as grossSalary
            ')
        ->like('employee.unit_id', $unitId)
        ->like('employee.floor_id', $floorId)
        ->like('employee.section_id', $sectionId)
        ->like('employee.subsection_id', $subSectionId)
        ->like('employee.incharge_id', $inchargeId)
        ->like('employee.supervisor_id', $supervisorId)
        ->join('employee', 'employee.employee_id=salary.employee_id', 'left')
        ->join('designation','designation.designation_id=employee.designation_id','left')
        ->where('salary.employee_id NOT IN (SELECT attendance_bonus.employee_id from attendance_bonus where attendance_bonus.attendance_bonus_month='.$month.')')
        ->group_by('salary.employee_id')
        ->get('salary');
        //echo $this->db->last_query();
        return $sql->result_array(); 
    }
    


    public function listOfEmployeeData_page($descp) 
    {
        $query = $this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, employee.employee_joiningDate, designation.designation_name')->from('employee')->join('designation', 'designation.designation_id=employee.designation_id', 'left')->like('employee.employee_id', $descp)->or_like('employee.employee_name', $descp)->or_like('employee.employee_pre_code', $descp)->or_like('employee.employee_code', $descp)->or_like('designation.designation_name', $descp)->order_by('employee.employee_name', 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }

    public function listOfData_page_photo($descp) 
    {
        $query = $this->db->select('employee.employee_id, employee.employee_name, employee.employee_pre_code, employee.employee_code,  employee.employee_image_url, designation.designation_name')->from('employee')->join('designation', 'designation.designation_id=employee.designation_id', 'left')->like('employee.employee_id', $descp)->or_like('employee.employee_name', $descp)->or_like('employee.employee_pre_code', $descp)->or_like('employee.employee_code', $descp)->or_like('designation.designation_name', $descp)->order_by('employee.employee_name', 'asc')->get('', $this->limit, $this->offset);
        return $query->result_array(); 
    }
    public function listOfData_productOperation() 
    {
        $query = $this->db->select('production_operation.operation_id, product_section.product_section_name, season.season_name, buyer.buyer_name, style.style_name, guage.guage_size, size.size_name, production_operation.major_parts, measurement.measurement_name, production_operation.rate')->from('production_operation')->join('product_section', 'product_section.product_section_id=production_operation.section_id', 'left')->join('season', 'season.season_id=production_operation.season_id', 'left')->join('buyer', 'buyer.buyer_id=production_operation.buyer_id', 'left')->join('style', 'style.style_id=production_operation.style_id', 'left')->join('guage', 'guage.guage_id=production_operation.gauge_id', 'left')->join('size', 'size.size_id=production_operation.size_id', 'left')->join('measurement', 'measurement.measurement_id=production_operation.unitmeasur_id', 'left')->order_by('production_operation.operation_id', 'asc')->get('');
        return $query->result_array();
    }
    
    public function employeeProductionOperationData($employeeId)
    {
        $this->db->select('production.production_operation_id, product_section.product_section_name, season.season_name, buyer.buyer_name, style.style_name, guage.guage_size, size.size_name, production_operation.major_parts, measurement.measurement_name, production_operation.rate, production.production_quantity, production.operation_date');
        $this->db->from('production');
        $this->db->join('production_operation', 'production_operation.operation_id=production.production_operation_id', 'left');
        $this->db->join('product_section', 'product_section.product_section_id=production_operation.section_id', 'left');
        $this->db->join('season', 'season.season_id=production_operation.season_id', 'left');
        $this->db->join('buyer', 'buyer.buyer_id=production_operation.buyer_id', 'left');
        $this->db->join('style', 'style.style_id=production_operation.style_id', 'left');
        $this->db->join('guage', 'guage.guage_id=production_operation.gauge_id', 'left');
        $this->db->join('size', 'size.size_id=production_operation.size_id', 'left');
        $this->db->join('measurement', 'measurement.measurement_id=production_operation.unitmeasur_id', 'left');
        $this->db->order_by('production.operation_date', 'DESC');
        $this->db->where('employee_id', $employeeId);
        $query = $this->db->get();
        return $query->result_array();
    }
    
     public function employeeDataForBarcode() 
    {
        $this->db->select('employee_id');
        $this->db->from('employee');
        //$this->db->join('designation', 'designation.designation_id=employee.designation_id', 'left');
        $this->db->order_by('employee_id', 'asc');
        $query = $this->db->get();
        return $query->result_array(); 
    }
    public function employeeDataForAttendance($employeeId) 
    {
        $this->db->select('employee.employee_code,employee.employee_name,employee.employee_pre_code,designation.designation_name');
        $this->db->from('employee');
        $this->db->join('designation', 'designation.designation_id=employee.designation_id', 'left');
        $this->db->where('employee_id', $employeeId);
        $query = $this->db->get();
        return $query->result_array(); 
    }
    
    public function employeeAttendanceData($todate) 
    {
        $this->db->select('daily_attendance.daily_attendance_employee_id, daily_attendance.daily_attendance_intime, daily_attendance.daily_attendance_outtime, daily_attendance.daily_attendance_status, employee.employee_code, employee.employee_name, employee.employee_pre_code, designation.designation_name');
        $this->db->from('daily_attendance');
        $this->db->join('employee', 'employee.employee_id = daily_attendance.daily_attendance_employee_id', 'left');
        $this->db->join('designation', 'designation.designation_id = employee.designation_id', 'left');
        $this->db->where('daily_attendance.daily_attendance_date', $todate);
        $this->db->order_by('daily_attendance.daily_attendance_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array(); 
    }
    public function singleemployeeAttendanceData($empId,$todate) 
    {
        $this->db->select('daily_attendance.daily_attendance_employee_id, daily_attendance.daily_attendance_intime, daily_attendance.daily_attendance_outtime, daily_attendance.daily_attendance_status, employee.employee_code, employee.employee_name, employee.employee_pre_code, designation.designation_name');
        $this->db->from('daily_attendance');
        $this->db->join('employee', 'employee.employee_id = daily_attendance.daily_attendance_employee_id', 'left');
        $this->db->join('designation', 'designation.designation_id = employee.designation_id', 'left');
        $this->db->where('daily_attendance.daily_attendance_employee_id', $empId);
        $this->db->where('daily_attendance.daily_attendance_date', $todate);
        $this->db->order_by('daily_attendance.daily_attendance_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array(); 
    }
    
    public function checkEmployeeAttendance($eid,$tdate,$tblName) {
        
        $sql = $this->db->select('daily_attendance_employee_id')
                        ->where('daily_attendance_employee_id',$eid)
                        ->where('daily_attendance_date',$tdate)
                        ->limit(1)
                        ->get($tblName);        
        
        if($sql->num_rows()>0){
            return 1;
        }else{
            return 0;
        }
        
    }
    
    public function searchCurrentMonthSalaryData($month, $year)
    {
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, 
            designation.designation_name, designation.designation_id,
            salary_sheet.salary_sheet_amount,
            production_bonus.production_bonus_amount, 
            overtime_bonus.overtime_bonus_amount,
            attendance_bonus.attendance_bonus_amount
            ')
        ->join('salary_sheet', 'salary_sheet.employee_id=employee.employee_id', 'left')
        ->join('production_bonus', 'production_bonus.employee_id=employee.employee_id', 'left')
        ->join('designation','designation.designation_id=employee.designation_id','left')
        ->join('overtime_bonus','overtime_bonus.employee_id=employee.employee_id','left')
        ->join('attendance_bonus','attendance_bonus.employee_id=employee.employee_id','left')
        ->where("(salary_sheet.salary_sheet_month = '{$month}' AND salary_sheet.salary_sheet_year = '{$year}')")
        ->or_where("(production_bonus.production_bonus_month = '{$month}' AND production_bonus.production_bonus_year = '{$year}')")
        ->or_where("(overtime_bonus.overtime_bonus_month = '{$month}' AND overtime_bonus.overtime_bonus_year = '{$year}')")
        ->or_where("(attendance_bonus.attendance_bonus_month = '{$month}' AND attendance_bonus.attendance_bonus_year = '{$year}')")
        ->group_by('employee.employee_id')
        ->get('employee');
        // echo $month;
         //echo $this->db->last_query();
        return $sql->result_array();
    }

     public function searchLimitMonthSalaryData($monthBegin, $monthEnd, $year)
    {
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, 
            designation.designation_name, designation.designation_id,
            salary_sheet.salary_sheet_amount,
            production_bonus.production_bonus_amount, 
            overtime_bonus.overtime_bonus_amount,
            attendance_bonus.attendance_bonus_amount
            ')
        ->join('salary_sheet', 'salary_sheet.employee_id=employee.employee_id', 'left')
        ->join('production_bonus', 'production_bonus.employee_id=employee.employee_id', 'left')
        ->join('designation','designation.designation_id=employee.designation_id','left')
        ->join('overtime_bonus','overtime_bonus.employee_id=employee.employee_id','left')
        ->join('attendance_bonus','attendance_bonus.employee_id=employee.employee_id','left')
        ->where("((salary_sheet.salary_sheet_month >= '{$monthBegin}' AND salary_sheet.salary_sheet_month <= '{$monthEnd}') AND salary_sheet.salary_sheet_year = '{$year}')")
        ->or_where("((production_bonus.production_bonus_month >= '{$monthBegin}' AND production_bonus.production_bonus_month <= '{$monthEnd}') AND production_bonus.production_bonus_year = '{$year}')")
        ->or_where("((overtime_bonus.overtime_bonus_month >= '{$monthBegin}' AND overtime_bonus.overtime_bonus_month <= '{$monthEnd}') AND overtime_bonus.overtime_bonus_year = '{$year}')")
        ->or_where("((attendance_bonus.attendance_bonus_month = '{$monthBegin}' AND attendance_bonus.attendance_bonus_month = '{$monthEnd}') AND attendance_bonus.attendance_bonus_year = '{$year}')")
        ->group_by('employee.employee_id')
        ->get('employee');
        // echo $month;
         //echo $this->db->last_query();
        return $sql->result_array();
    }
    

    public function searchCurrentMonthProductionData($month, $year)
    {
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, 
            designation.designation_name, designation.designation_id,
            production.production_quantity,
            production_bonus.production_bonus_amount, 
            product_section.product_section_name
            ')
        ->join('production', 'production.employee_id=employee.employee_id', 'left')
        ->join('production_bonus', 'production_bonus.employee_id=employee.employee_id', 'left')
        ->join('designation','designation.designation_id=employee.designation_id','left')
        ->join('production_operation','production_operation.operation_id=production.production_operation_id','left')
        ->join('product_section','product_section.product_section_id=production_operation.section_id','left')
        ->where("(month(production.operation_date) = '{$month}' AND year(production.operation_date) = '{$year}')")
        ->or_where("(production_bonus.production_bonus_month = '{$month}' AND production_bonus.production_bonus_year = '{$year}')")
        ->group_by('employee.employee_id')
        ->get('employee');
        // echo $month;
         //echo $this->db->last_query();
        return $sql->result_array();
    }

    public function searchLimitMonthProductionData($monthBegin, $monthEnd, $year)
    {
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, 
            designation.designation_name, designation.designation_id,
            production.production_quantity,
            production_bonus.production_bonus_amount, 
            product_section.product_section_name
            ')
        ->join('production', 'production.employee_id=employee.employee_id', 'left')
        ->join('production_bonus', 'production_bonus.employee_id=employee.employee_id', 'left')
        ->join('designation','designation.designation_id=employee.designation_id','left')
        ->join('production_operation','production_operation.operation_id=production.production_operation_id','left')
        ->join('product_section','product_section.product_section_id=production_operation.section_id','left')
        ->where("((month(production.operation_date) >= '{$monthBegin}' AND month(production.operation_date) <= '{$monthEnd}') AND year(production.operation_date) = '{$year}')")
        ->or_where("((production_bonus.production_bonus_month >= '{$monthBegin}' AND production_bonus.production_bonus_month <= '{$monthEnd}') AND production_bonus.production_bonus_year = '{$year}')")
        ->group_by('employee.employee_id')
        ->get('employee');
        // echo $month;
        //echo $this->db->last_query();
        return $sql->result_array();
    }
    
    public function getProductionBonusSetupDataFromTable()
    {
        $this->db->select('production_bonus_setup.production_bonus_setup_id, production_bonus_setup.production_bonus_setup_title, production_bonus_setup.production_bonus_setup_start, production_bonus_setup.production_bonus_setup_end, production_bonus_setup.production_bonus_setup_percentage, designation.designation_name');
        $this->db->from('production_bonus_setup');
        $this->db->join('designation', 'designation.designation_id=production_bonus_setup.designation_id', 'left');
        $query = $this->db->get();
        return $query->result_array(); 
    }

    public function searchProductionViewData($unitId, $floorId, $sectionId, $subSectionId, $inchargeId, $supervisorId,$month)
    {
        //New Edit Start
        if($unitId == 0)
        {
           $unitId = ''; 
        }
        if($floorId == 0)
        {
           $floorId = ''; 
        }
        if($sectionId == 0)
        {
           $sectionId = ''; 
        }
        if($subSectionId == 0)
        {
           $subSectionId = ''; 
        }
        if($inchargeId == 0)
        {
           $inchargeId = ''; 
        }
        if($supervisorId == 0)
        {
           $supervisorId = ''; 
        }
        
        $sql=$this->db->select('employee.employee_id, employee.employee_pre_code, employee.employee_code, employee.employee_name, 
            designation.designation_name, designation.designation_id,
            production.production_operation_id, production.production_quantity as production_quantity,
            product_section.product_section_name as section_name, 
            ')
        ->like('employee.unit_id', $unitId)
        ->like('employee.floor_id', $floorId)
        ->like('employee.section_id', $sectionId)
        ->like('employee.subsection_id', $subSectionId)
        ->like('employee.incharge_id', $inchargeId)
        ->like('employee.supervisor_id', $supervisorId)
        ->join('employee', 'employee.employee_id=production.employee_id', 'left')
        ->join('production_operation', 'production.production_operation_id=production_operation.operation_id', 'left')
        ->join('designation','designation.designation_id=employee.designation_id','left')
        ->join('product_section','product_section.product_section_id=production_operation.section_id','left')
        ->where('month(production.operation_date)=',$month)
        ->get('production');
        //echo $this->db->last_query();
        return $sql->result_array(); 
    }
    public function getAttendanceBonusSetupDataFromTable()
    {
        $this->db->select('attendance_bonus_setup.attendance_bonus_setup_id, designation.designation_name, attendance_bonus_setup.attendance_bonus_setup_title, attendance_bonus_setup.attendance_bonus_setup_start, attendance_bonus_setup.attendance_bonus_setup_end, attendance_bonus_setup.attendance_bonus_setup_fixed, attendance_bonus_setup.attendance_bonus_setup_percentage');
        $this->db->from('attendance_bonus_setup');
        $this->db->join('designation', 'designation.designation_id=attendance_bonus_setup.designation_id', 'left');
        $query = $this->db->get();
        return $query->result_array(); 
    }
    //get attendance for the searched month
    public function searchempAttendanceData($empId,$salaryDays,$month)
    {
        $first_date = date('Y',time()).'-'.$month.'-01';
        $second_date = date('Y',time()).'-'.$month.'-'.$salaryDays;
                
        $this->db->select('daily_attendance_employee_id');
        $this->db->from('daily_attendance');
        $this->db->where('daily_attendance_employee_id = ',$empId);
        $this->db->where('daily_attendance_date >=', $first_date);
        $this->db->where('daily_attendance_date <=', $second_date);
        $query = $this->db->get();
        return $query->num_rows();
    }
}