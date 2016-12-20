<?php $this->load->view('template/header');?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/table-css.css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ui.timepicker.js"></script>
<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/jquery.ui.timepicker.css" rel="stylesheet" />

<script type="text/javascript">

$(document).ready(function() {
//    $('#searchTable').dataTable( {
//        "pagingType": "full_numbers"
//    } );
    
    
     $('#form-product-entry').submit(function(event){
         
        if($('#month').val() == 0)
        {
            alert("Please Select The Month!");
            return false;
        }
        else
        {
            return true;
        }
     });
        
} );

function setFloorCode()
{
    $('#floor').empty();
    var unitId = $('#unit').val();
    $('#floor').append('<option value="0">Select Floor</option>');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>employee/loadFloor/",
        data: { 'unitId': unitId  },
        success: function(data){
            // Parse the returned json data

               var opts = $.parseJSON(data);
               $.each(JSON.parse(opts), function(idx, obj) {
                    
                    //$('#floor').append('<option>Select Section</option>');
                    $('#floor').append('<option value="' + obj.value + '">' + obj.label + '</option>');
               });

        }
    });
}
function setSectionCode()
{
    $('#section').empty();
    var floorId = $('#floor').val();
    $('#section').append('<option value="0">Select Section</option>');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>employee/loadSection/",
        data: { 'floorId': floorId  },
        success: function(data){
            // Parse the returned json data

               var opts = $.parseJSON(data);
               $.each(JSON.parse(opts), function(idx, obj) {

                    $('#section').append('<option value="' + obj.value + '">' + obj.label + '</option>');
               });

        }
    });
}
function setSubSectionCode()
{
    $('#subsection').empty();
    var sectionId = $('#section').val();
    $('#subsection').append('<option value="0">Select Section</option>');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>employee/loadSubcection/",
        data: { 'sectionId': sectionId  },
        success: function(data){
            // Parse the returned json data

               var opts = $.parseJSON(data);
               $.each(JSON.parse(opts), function(idx, obj) {

                    $('#subsection').append('<option value="' + obj.value + '">' + obj.label + '</option>');
               });

        }
    });
}
function setInchargeCode()
{
    $('#incharge').empty();
    var subsectionId = $('#subsection').val();
    $('#incharge').append('<option value="0">Select Incharge</option>');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>employee/loadIncharge/",
        data: { 'subsectionId': subsectionId  },
        success: function(data){
            // Parse the returned json data

               var opts = $.parseJSON(data);
               $.each(JSON.parse(opts), function(idx, obj) {

                    $('#incharge').append('<option value="' + obj.value + '">' + obj.label + '</option>');
               });
        }
    });
}

function setSupervisorCode()
{
    $('#supervisor').empty();
    var inchargeId = $('#incharge').val();
    
    $('#supervisor').append('<option value="0">Select Supervisor</option>');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>employee/loadSupervisor/",
        data: { 'inchargeId': inchargeId  },
        success: function(data){
            // Parse the returned json data

               var opts = $.parseJSON(data);
               $.each(JSON.parse(opts), function(idx, obj) {

                    $('#supervisor').append('<option value="' + obj.value + '">' + obj.label + '</option>');
               });
        }
    });
}


function loadBlockMajor()
{
    $('#blockLine').empty();
    $('#majorParts').empty();
    var supervisorId = $('#supervisor').val();
    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>attendance_bonus/loadBlockMajor/",
        data: { 'supervisorId': supervisorId  },
        success: function(data){
            // Parse the returned json data
                //alert(data);
               var opts = $.parseJSON(data);
               $.each(JSON.parse(opts), function(idx, obj) {

                    $('#blockLine').append(': '+obj.blockLine);
                    $('#majorParts').append(': '+obj.majorParts);
               });
        }
    });
}

function insertData(employeeId)
{
    var operationId = document.getElementById('hiddenOperationIdField_'+employeeId).innerHTML;
    var quantityId = document.getElementById('hiddenQuantityField_'+employeeId).innerHTML;
   
    var dateId = $('#dateOfBirth_'+employeeId).val();
    var operationIdArray = operationId.split(" ");
    var quantityIdArray = quantityId.split(" ");
    var qurl = '<?php echo base_url();?>attendance_bonus/submitData';
    //alert(dateId);
    if(operationIdArray.length > 1)
    {        
        if(dateId != "")
        {
            for(var i = 0; i<operationIdArray.length-1; i++)
            {
                $.ajax({
                        url:qurl,
                        type:"POST",
                        data:{employee_id:employeeId, operationId:operationIdArray[i], quantity:quantityIdArray[i], operationDate:dateId},
                        success:function(data){}
                });
            }
            document.getElementById('hiddenOperationIdField_'+employeeId).innerHTML = "";
            document.getElementById('hiddenQuantityField_'+employeeId).innerHTML = "";
            document.getElementById('productOperation_'+employeeId).innerHTML = "<a class='add cboxElement' href='<?php echo base_url();?>product_operation_list/index/"+employeeId+"' title='Product Operation List'>Click To Assign Operation</a>";

            alert("Assigned Successfully!");
        }
        else
        {
            alert("Date Field Can't Be Empty!");
        }
    }
    else
    {
        alert('Please Select Operation By Click Left Side Links!');
    }
}
//fucntion cal()
//{
//    document.getElectmentById('').value;
//}
function cal(loopCount)
{
   var totalSalary = $('#totalSalary_'+loopCount).val();
   var daysOfMonth = $('#daysOfMonth_'+loopCount).val();
   var daysOfAttand = $('#daysOfAttand_'+loopCount).val();
   var salaryPerDay = Math.round(totalSalary / daysOfMonth);
   var calculateSalary = salaryPerDay * daysOfAttand;
   $('#calculateSalary_'+loopCount).val(calculateSalary);
}
</script>
<body>
   
    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <?php if(isset($successInsered)){?>
                        <div class="alert alert-success" role="alert"><?php echo $successInsered;?></div>
                    <?php 
                        }
                        if(isset($errorInsered))
                        {
                    ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errorInsered;?></div>
                    <?php }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
               
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h5>Employee Attendance Bonus Entry Panel</h5> 
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-product-entry', 'id' => 'form-product-entry', 'class' => 'form-product-entry');
                            echo form_open("attendance_bonus/searchEmployee", $attributes);
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Unit</td>
                                    <td>
                                        <select  name="unit" id="unit" onchange="setFloorCode();" required>
                                            <option value="0">Select Unit</option>
                                            <?php 
                                                if(isset($unit))
                                                {
                                                    if($unit_id != 0)
                                                    {
                                                        
                                            ?>            
                                                        <option value="<?php echo $unit_id;?>" selected><?php echo $unit_name;?></option>
                                            <?php        
                                                        
                                                    }
                                                    foreach ($unit as $key => $row):
                                            ?>
                                                    
                                                    <option value="<?php echo $row['unit_id'];?>"><?php echo $row['unit_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Unit Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                                    <td>Floor</td>
                                    <td>
                                        <select  name="floor" id="floor" onchange="setSectionCode();setFloorShortCode();" required>
                                            <option value="0">Select Floor</option>
                                            <?php if($floor_id != 0){?>
                                                <option value="<?php echo $floor_id;?>" selected><?php echo $floor_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td>Section</td>
                                    <td>
                                         <select  name="section" id="section" onchange="setSubSectionCode();setSectionShortCode();" required>
                                            <option value="0">Select Section</option>
                                            <?php if($section_id != 0){?>
                                                <option value="<?php echo $section_id;?>" selected><?php echo $section_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td>Sub Section</td>
                                    <td>
                                        <select  name="subsection" id="subsection" onchange="setInchargeCode();" required>
                                            <option value="0">Select Sub Section</option>
                                            <?php if($subsection_id != 0){?>
                                                <option value="<?php echo $subsection_id;?>" selected><?php echo $subsection_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Incharge</td>
                                    <td>
                                        <select  name="incharge" id="incharge" onchange="setSupervisorCode();">
                                            <option value="0">Select Incharge</option>
                                            <?php if($incharge_id != 0){?>
                                                <option value="<?php echo $incharge_id;?>" selected><?php echo $incharge_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td>Supervisor</td>
                                    <td>
                                        <select  name="supervisor" id="supervisor" onchange="loadBlockMajor();" required>
                                            <option value="0">Select Supervisor</option>
                                            <?php if($supervisor_id != 0){?>
                                                <option value="<?php echo $supervisor_id;?>" selected><?php echo $supervisor_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td>Block Line</td>
                                    <td>
                                        <span id="blockLine"></span>
                                    </td>
                                    <td>Major Parts</td>
                                    <td>
                                        <span id="majorParts"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Select Month</td>
                                    <td>
                                        <select id="month" name="month">
                                            <option value="0">Select Month</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">September</option>
                                            <option value="11">October</option>
                                            <option value="12">December</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <?php
                                        
                                            $submitButton = array(
                                                'name' => 'submit',
                                                'id' => 'submit',
                                                'value' => 'Search',
                                                'type' => 'submit',
                                                'class' => 'btn btn-primary'
                                            );

                                            echo form_submit($submitButton);
                                       
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                        <?php echo form_close();?>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-salary-entry', 'id' => 'form-salary-entry', 'class' => 'form-salary-entry');
                            echo form_open("attendance_bonus/submitData", $attributes);
                        ?>
                        <div id="searchPanel" style="height: 300px;">
                            <table id="searchTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; width: 90px;">Employee Code</th>
                                        <th style="text-align: left; width: 90px;">Employee Name</th>
                                        <th style="text-align: left; width: 70px;">Designation</th>
                                        <th style="text-align: left; width: 60px;">Attendance Days</th>
                                        <th style="text-align: center; width: 80px;">Gross Salary</th>
                                        <!-- <th style="text-align: center; width: 80px;">Attendance Days</th> -->
                                        <th style="text-align: center; width: 100px;">Bonus Amount</th>
                                    </tr>
                                 </thead>
                                 <tbody>

                                        <?php $loopCount = 1; if(isset($attendanceBonusData)){ foreach ($attendanceBonusData as $key => $row):?>
                                        <tr>
                                            <td><?php echo $row['employee_pre_code']."-".$row['employee_code'];?></td>
                                            <td><?php echo $row['employee_name'];?></td>
                                            <td><?php echo $row['designation_name'];?></td>
                                            <!-- <td style="text-align: center;">
                                                <input type="text" readonly name="daysOfMonth_<?php $loopCount;?>" id="daysOfMonth_<?php echo $loopCount;?>" style="width:80px;" value="<?php if(isset($month)){if($month == 1) echo 31;elseif($month == 2) echo 28;elseif($month == 3) echo 31;elseif($month == 4) echo 30;elseif($month == 5) echo 31;elseif($month == 6) echo 30;elseif($month == 7) echo 31;elseif($month == 8) echo 31;elseif($month == 9) echo 30;elseif($month == 10) echo 31;elseif($month == 11) echo 31;elseif($month == 12) echo 30;};?>" />
                                            </td>
                                            <td style="text-align: center;">
                                        <input type="text" name="daysOfAttand_<?php echo $loopCount;?>" id="daysOfAttand_<?php echo $loopCount;?>" style="width:80px;" onkeyup="cal(<?php echo $loopCount;?>);" value="<?php if(isset($month)){if($month == 1) echo 31;elseif($month == 2) echo 28;elseif($month == 3) echo 31;elseif($month == 4) echo 30;elseif($month == 5) echo 31;elseif($month == 6) echo 30;elseif($month == 7) echo 31;elseif($month == 8) echo 31;elseif($month == 9) echo 30;elseif($month == 10) echo 31;elseif($month == 11) echo 31;elseif($month == 12) echo 30;};?>" />
                                            </td> -->
                                            <?php if(isset($month)){if($month == 1) $daysOfMonthF=31;elseif($month == 2) $daysOfMonthF=28;elseif($month == 3) $daysOfMonthF=31;elseif($month == 4) $daysOfMonthF=30;elseif($month == 5) $daysOfMonthF=31;elseif($month == 6) $daysOfMonthF=30;elseif($month == 7) $daysOfMonthF=31;elseif($month == 8) $daysOfMonthF=31;elseif($month == 9) $daysOfMonthF=30;elseif($month == 10) $daysOfMonthF= 31;elseif($month == 11) $daysOfMonthF=31;elseif($month == 12) $daysOfMonthF=30;};?>
                                            <td style="text-align: center;">
                                                <input type="text" readonly name="daysOfMonth_<?php $loopCount;?>" id="daysOfMonth_<?php echo $loopCount;?>" style="width:80px;" value="<?php echo $daysOfMonthF; ?>" />
                                            </td>
                                            <td style="text-align: center;">
                                               
                                                <input type="text" name="grossSalary_<?php echo $loopCount;?>" id="grossSalary_<?php echo $loopCount;?>" style="width:80px;" readonly value="<?php echo $row['grossSalary'];?>" /> BDT
                                            </td>
                                            <td style="text-align: center;">
                                               <?php 
                                                    $bonusAmmount = 0;
                                                     foreach ($attendanceBonusSetupData as $keyBonusSetup => $valueBonusSetup):
                                                         if(($valueBonusSetup['designation_id'] == $row['designation_id']) and ($row['grossSalary']>=$valueBonusSetup['attendance_bonus_setup_start']) and ($row['grossSalary']<=$valueBonusSetup['attendance_bonus_setup_end']) )
                                                         {
                                                            if($valueBonusSetup['attendance_bonus_setup_fixed']>0 AND $valueBonusSetup['attendance_bonus_setup_percentage']==0 ){
                                                                $bonusAmmount = $valueBonusSetup['attendance_bonus_setup_fixed'];
                                                                } 
                                                            else if($valueBonusSetup['attendance_bonus_setup_fixed']==0 AND $valueBonusSetup['attendance_bonus_setup_percentage']>0 ){
                                                                $bonusAmmount = $valueBonusSetup['attendance_bonus_setup_percentage']*$row['grossSalary']/100;
                                                                $bonusAmmount = round($bonusAmmount);
                                                                } 
                                                         }
                                                     endforeach;
                                                ?>
                                                <input type="text" name="bonusAmmount_<?php echo $loopCount;?>" id="bonusAmmount_<?php echo $loopCount;?>" style="width:80px;" readonly value="<?php echo $bonusAmmount;?>" /> BDT
                                            </td>
                                        </tr>
                                        <input hidden id="employeeId_<?php echo $loopCount;?>" name="employeeId_<?php echo $loopCount;?>" value="<?php echo $row['employee_id'];?>" />
                                        <?php $loopCount++; endforeach;}?>
                                 </tbody>    
                            </table>
                        </div>
                        <input hidden id="loopCount" name="loopCount" value="<?php echo $loopCount;?>" /> 
                        <input hidden id="monthField" name="monthField" value="<?php if(isset($month)) echo $month;?>" /> 
                        <div class="panel-footer" style="text-align: right;">
                            <?php

                                $submitButton = array(
                                    'name' => 'submit',
                                    'id' => 'submit',
                                    'value' => 'SAVE',
                                    'type' => 'submit',
                                    'class' => 'btn btn-success'
                                );

                                echo form_submit($submitButton);

                            ?>
                        </div>
                         <?php echo form_close();?>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
<?php $this->load->view('template/footer');?>
