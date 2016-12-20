<?php $this->load->view('template/header');?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/table-css.css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" />

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
        url: "<?php echo base_url();?>production_bonus/loadBlockMajor/",
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
    var qurl = '<?php echo base_url();?>production_bonus/submitData';
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
                            <h5>Production Bonus Entry Panel</h5> 
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-product-entry', 'id' => 'form-product-entry', 'class' => 'form-product-entry');
                            echo form_open("production_bonus/searchEmployee", $attributes);
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
                            echo form_open("production_bonus/submitData", $attributes);
                        ?>
                        <div id="searchPanel" style="height: 300px;">
                            <table id="searchTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; width: 90px;">Employee Code</th>
                                        <th style="text-align: left; width: 90px;">Employee Name</th>
                                        <th style="text-align: left; width: 70px;">Designation</th>
                                        <th style="text-align: center; width: 80px;">Quantity</th>
                                        <th style="text-align: center; width: 80px;">Rate</th>
                                        <th style="text-align: center; width: 100px;">Bonus Amount</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php 

                                        
                                        $loopCount = 1; if(isset($productionData)){ 
                                            //print_r($productionData);
                                            //$productionData = array_unique($productionData, SORT_REGULAR);
                                            //$productionData = array_map("unserialize", array_unique(array_map("serialize", $productionData)));
                                            /*$one_dimension = array_map(serialize($productionData));
                                            $unique_one_dimension = array_unique($one_dimension);
                                            $unique_multi_dimension = array_map(unserialize($unique_one_dimension));*/

                                            foreach ($productionData as $key => $row): ?>
                                
                                            <td><?php echo $row['employee_pre_code']."-".$row['employee_code'];?></td>
                                            <td><?php echo $row['employee_name'];?></td>
                                            <td><?php echo $row['designation_name'];?></td>
                                            <td style="text-align: center;">
                                            <input type="text" name="productionQuantity_<?php echo $loopCount;?>" readonly id="productionQuantity_<?php echo $loopCount;?>" style="width:80px;" value="<?php echo $row['production_quantity']; ?>" />
                                            </td>
                                            <td style="text-align: center;">
                                            <input type="text" name="productionRates_<?php echo $loopCount;?>" readonly id="productionRates_<?php echo $loopCount;?>" style="width:80px;" value="<?php echo  $row['rate']; ?>" />
                                            </td>
                                            <td style="text-align: center;">
                                                 <?php 
                                                    $totalAmmount = 0;
                                                    foreach ($productionBonusSetupData as $keyBonusSetup => $valueBonusSetup):
                                                        if(($valueBonusSetup['designation_id'] == $row['designation_id']) and ($row['rate']>=$valueBonusSetup['production_bonus_setup_start']) and ($row['rate']<=$valueBonusSetup['production_bonus_setup_end']) )
                                                        {
                                                            $totalAmmount = ($row['rate'] * $valueBonusSetup['production_bonus_setup_percentage'])/100; 
                                                        }
                                                    endforeach;
                                                ?>
                                                <input type="text" name="calculateSalary_<?php echo $loopCount;?>" id="calculateSalary_<?php echo $loopCount;?>" style="width:80px;" value="<?php echo $totalAmmount; ?>" /> BDT
                                            </td>
                                        </tr>
                                        <input hidden id="employeeId_<?php echo $loopCount;?>" name="employeeId_<?php echo $loopCount;?>" value="<?php echo $row['employee_id'];?>" />
                                        <?php $loopCount++; 
                                        // }
                                          //end of production data check for non-zero rate 
                                                        
                                        
                                        endforeach;
                                        }  // end of employee data, data for all employee

                                         ?>
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
