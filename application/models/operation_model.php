<?php
class Operation_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    /***************Get Next ID of The Table*******************/
    public function getNextId($tableName)
    {
       /* $cq = "SHOW TABLE STATUS LIKE '{$tableName}'";
        $cqres = mysql_query($cq) or die(mysql_error());
        $cqr = mysql_fetch_assoc($cqres); or die(mysql_error());
        $nid = $cqr['Auto_increment'];*/
        return 122;
    }
    /**********************************/
    /***************Insert Data Into A Table*******************/
    public function insertInToTable($tableName, $insertedData)
    {
        $this->db->insert($tableName, $insertedData);
        $is_inserted = $this->db->affected_rows() > 0;
        if($is_inserted)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function insertDataInToTable($tableName, $insertedData)
    {
        $this->db->insert($tableName, $insertedData);
        $databaseError = $this->db->_error_message(); 
        return $databaseError;
    }
    public function updateDataInToTable($tableName, $upadateData, $employeeId, $productionOperationId)
    {
        $this->db->where('employee_id', $employeeId);
        $this->db->where('production_operation_id', $productionOperationId);
        $this->db->update($tableName, $upadateData);
        $databaseError = $this->db->_error_message(); 
        //echo $this->db->last_query();
        return $databaseError;
    }
    /**********************************/
    /****************Check Child Of The Setup Section******************/
    public function checkChild($tableName, $checkField, $matchField)
    {
        $this -> db -> select($checkField);
        $this -> db -> from($tableName);
        $this -> db -> where($checkField, $matchField);
        $this -> db -> limit(1);
        $query = $this -> db -> get();
        $queryResult = $query->result();
        if($query -> num_rows() == 1)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    /**********************************/
    /**********************************/
     public function insertDataGetId($tableName, $insertedData)
    {
        $this->db->insert($tableName, $insertedData);
        $insertedId = $this->db->insert_id(); 
        $is_inserted = $this->db->affected_rows() > 0;
         
        if($is_inserted)
        {
            return $insertedId;
        }
        else 
        {
            return FALSE;
        }
    }
    /**********************************/
    /**********************************/
    public function insertGetId($tableName)
    {
        $insertedId = $this->db->insert_id(); 
        $is_inserted = $this->db->affected_rows() > 0;
         
        if($is_inserted)
        {
            return $insertedId;
        }
        else 
        {
            return FALSE;
        }
    }
    /**********************************/
    /****************Get Table ID & Name Field Data Of A Table******************/
    
    public function getParentTable($tableFieldId, $tableFieldName, $tableName)
    {
        $sql = "SELECT $tableFieldId, $tableFieldName FROM $tableName";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }
    /**********************************/
    /***************Get Specific Field Data From A Table*******************/
    public function getTableData($tableField, $matchId, $idField, $tableName)
    {
        $sql = "SELECT $tableField FROM $tableName WHERE $idField = $matchId";
        $query = mysql_query($sql) or die(mysql_error());
        $data = mysql_fetch_assoc($query) or die(mysql_error());
        $returnData = $data[$tableField]; 
        return $returnData;
    }
    
    public function getSingleDataOfTable($tableField, $selectField, $matchField, $tableName)
    {
        $this->db->select($tableField);
        $this->db->from($tableName);
        $this->db->where($selectField, $matchField);
        $query = $this->db->get();
        $row = $query->row_array();
        $your_variable = $row[$tableField];
        return $your_variable;
    }
    /**********************************/
    /***************Get The Short Code OF Some Table Data*******************/
    public function getShortCodeData($tableName, $selectField, $compareField, $compareBy)
    {
        $sql = "SELECT $selectField FROM $tableName WHERE $compareField = $compareBy";
        $query = mysql_query($sql) or die(mysql_error());
        $data = mysql_fetch_assoc($query) or die(mysql_error());
        $returnData = $data[$selectField]; 
        return $returnData;
    }
    /**********************************/
    /****************Update Of A Table******************/
    public function updateTable($fieldId, $matchId, $tableName, $data)
    {
        $this->db->where($fieldId, $matchId);
        $this->db->update($tableName, $data); 
        $is_updated = $this->db->affected_rows() > 0;
         if($is_updated)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    /**********************************/
    /****************Update The Salary Earning Table******************/
    public function updateSalaryEarningTable($fieldId1, $fieldId2, $matchId1, $matchId2, $tableName, $data)
    {
        $this->db->where($fieldId1, $matchId1);
        $this->db->where($fieldId2, $matchId2);
        $this->db->update($tableName, $data); 
        $is_updated = $this->db->affected_rows() > 0;
         if($is_updated)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    /**********************************/
    /**************Delete Data From A Table********************/
    public function deleteTableData($fieldId, $matchId, $tableName)
    {
        $this->db->delete($tableName, array($fieldId => $matchId)); 
        $is_deleted = $this->db->affected_rows() > 0;
        if($is_deleted)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    /**********************************/
    /**************LOOK UP Table Function********************/
    public function nameFloor($unitId)
    {
        $query=mysql_query("SELECT floor_id, floor_name FROM floor WHERE unit_id=$unitId");
        $json=array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'value'=> $agent['floor_id'],
                    'label'=>$agent['floor_name'],
                        );
        }
 
        return json_encode($json);
    }
    public function nameSection($floorId)
    {
        $query = mysql_query("SELECT section_id, section_name FROM section WHERE floor_id=$floorId");
        $json = array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'value'=> $agent['section_id'],
                    'label'=>$agent['section_name'],
                        );
        }
 
        return json_encode($json);
    }
    public function nameSubSection($sectionId)
    {
        $query = mysql_query("SELECT subsection_id, subsection_name FROM subsection WHERE section_id=$sectionId");
        $json = array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'value'=> $agent['subsection_id'],
                    'label'=>$agent['subsection_name'],
                        );
        }
 
        return json_encode($json);
    }
    
    public function nameIncharge($subsectionId)
    {
        $query = mysql_query("SELECT incharge_id, incharge_name FROM incharge WHERE subsection_id=$subsectionId");
        $json = array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'value'=> $agent['incharge_id'],
                    'label'=>$agent['incharge_name'],
                    );
        }
 
        return json_encode($json);
    }
    
    public function nameSupervisor($inchargeId)
    {
        $query = mysql_query("SELECT supervisor_id, supervisor_name FROM supervisor WHERE incharge_id=$inchargeId");
        $json = array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'value'=> $agent['supervisor_id'],
                    'label'=>$agent['supervisor_name'],
                    );
        }
 
        return json_encode($json);
    }
    public function nameDesignation($employeeCodeId)
    {
        $query = mysql_query("SELECT designation_id, designation_name FROM designation WHERE employee_type_id=$employeeCodeId");
        $json = array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'value'=> $agent['designation_id'],
                    'label'=>$agent['designation_name'],
                    );
        }
 
        return json_encode($json);
    }
    public function nameSalary($employeeCodeId)
    {
        $query = mysql_query("SELECT salary_head_id, salary_head_amount FROM salaryearning WHERE employee_type_id=$employeeCodeId");
        $json = array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'id'=> $agent['salary_head_id'],
                    'amount'=>$agent['salary_head_amount'],
                    );
        }
 
        return json_encode($json);
    }
    
    
    public function blockMajor($supervisorId)
    {
        $query = mysql_query("SELECT blockline_name, majorpart_name FROM supervisor WHERE supervisor_id=$supervisorId");
        $json = array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'blockLine'=> $agent['blockline_name'],
                    'majorParts'=>$agent['majorpart_name'],
                    );
        }
 
        return json_encode($json);
    }
    /**********************************/
     public function getParentTableData($matchingId, $WhereId)
    {
        $sql = "SELECT salaryearning.salary_head_id, salaryearning.salary_head_amount, salarytype.salary_type_name FROM salaryearning left join salarytype on salarytype.salary_type_id=salaryearning.salary_head_id WHERE $matchingId = $WhereId";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }
    
    public function getEmployeeData($fieldName, $tableName, $employeeId)
    {
        $sql = "SELECT $fieldName FROM $tableName WHERE employee_id=$employeeId";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }
    
    public function EmployeeSalary($employeeId)
    {
        $query = mysql_query("SELECT salary_head_id, salary_head_amount FROM salary WHERE employee_id=$employeeId");
        $json = array();
 
        while($agent=mysql_fetch_array($query)){
         $json[]=array(
                    'id' => $agent['salary_head_id'],
                    'amount' =>$agent['salary_head_amount'],
                    );
        }
 
        return json_encode($json);
    }
    
    public function updateSalary($fieldId, $matchId, $fieldId1, $matchId1, $tableName, $data)
    {
        $this->db->where($fieldId, $matchId);
         $this->db->where($fieldId1, $matchId1);
        $this->db->update($tableName, $data); 
    }
    
    
    public function checkDuplicacy($fieldName, $matchId, $tableName)
    {
        $this -> db -> select($fieldName);
        $this -> db -> from($tableName);
        $this -> db -> where($fieldName, $matchId);
        $this -> db -> limit(1);
        $query = $this -> db -> get();
        $queryResult = $query->result();
        if($query -> num_rows() == 1)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    public function getAllDataFromTable($tableName)
    {
        $this->db->select('*');
        $this->db->from($tableName);
        $query = $this->db->get();
        return $query->result_array(); 
    }



    function deleteProductionTableData($employeeId, $operationId, $tableName)
    {
        // $this->db->where('employee_id', $employeeId);
        // $this->db->where('production_operation_id', $operationId);
        //$this->db->from($tableName);
        $this->db->delete($tableName,array("employee_id"=>$employeeId,"production_operation_id"=>$operationId));
        $this->session->set_flashdata('success_message','Data Deleted Successfully!');
        redirect('production_view');
        //echo $this->db->last_query();
    }  //end of deleteProductionTableData
    
}