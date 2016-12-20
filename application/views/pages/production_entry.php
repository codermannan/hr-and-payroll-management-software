<?php $this->load->view('template/header');?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/table-css.css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ui.timepicker.js"></script>
<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/jquery.ui.timepicker.css" rel="stylesheet" />

<script type="text/javascript">

$(document).ready(function() {
    $('#searchTable').dataTable( {
        "pagingType": "full_numbers"
    } );
    
    
    $(".add").colorbox();
    $(".edit").colorbox(); 
    $(".view").colorbox();    
        
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
        url: "<?php echo base_url();?>production_entry/loadBlockMajor/",
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
    var qurl = '<?php echo base_url();?>production_entry/submitData';
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

</script>
<body>
   
    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Production Entry Panel</h4>
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
                            Production Entry Panel 
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-product-entry', 'id' => 'form-product-entry', 'class' => 'form-product-entry');
                            echo form_open("production_entry/searchEmployee", $attributes);
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
                                                'class' => 'btn btn-success'
                                            );

                                            echo form_submit($submitButton);
                                       
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                        <?php echo form_close();?>
                        <div id="searchPanel">
                            <table id="searchTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; width: 90px;">Employee Code</th>
                                        <th style="text-align: left; width: 90px;">Employee Name</th>
                                        <th style="text-align: left; width: 70px;">Designation</th>
                                        <th style="text-align: left; width: 400px;">Production Operation</th>
                                        <th style="text-align: left; width: 80px;">Date</th>
                                        <th style="text-align: left; width: 50px;">Action</th>
                                        <th style="text-align: left; width: 50px;">Detail</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php if(isset($employeeData)){ foreach ($employeeData as $key => $row):?>
                                        <tr>
                                            <td><?php echo $row['employee_pre_code']."-".$row['employee_code'];?></td>
                                            <td><?php echo $row['employee_name'];?></td>
                                            <td><?php echo $row['designation_name'];?></td>
                                            <td>
                                                <span id="productOperation_<?php echo $row['employee_id'];?>"><a class="add cboxElement" href="<?php echo base_url();?>product_operation_list/index/<?php echo $row['employee_id'];?>" title="Product Operation List">Click To Assign Operation</a></span>
                                                <span style="display:none;" id="hiddenOperationIdField_<?php echo $row['employee_id'];?>"></span>
                                                <span style="display:none;" id="hiddenQuantityField_<?php echo $row['employee_id'];?>"></span>
                                            </td>
                                            <td style="text-align: center;">
                                                <input style="width: 80px;" type="text" placeholder="" name="dateOfBirth_<?php echo $row['employee_id'];?>" id="dateOfBirth_<?php echo $row['employee_id'];?>" value="" required />
                                                    <script type="text/javascript">
                                                    <!--
                                                    $(document).ready(

                                                        /* This is the function that will get executed after the DOM is fully loaded */
                                                        function () {
                                                          $( "#dateOfBirth_<?php echo $row['employee_id'];?>").datepicker({
                                                            changeMonth: true,//this option for allowing user to select month
                                                            changeYear: true,
                                                            dateFormat: 'dd.mm.yy'//this option for allowing user to select from year range
                                                          });
                                                        }

                                                      );
                                                    //-->
                                                    </script>
                                            </td>
                                            <td>
                                                <table style="width: 100%; border: none;">
                                                    <tr>
                                                        <td style="text-align: left;"><a href="#" onclick="insertData(<?php echo $row['employee_id'];?>);"> Save </a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width: 100%; border: none;">
                                                    <tr>
                                                        <td style="text-align: left;"><a class="view cboxElement" href="<?php echo base_url();?>employee_operation_list/index/<?php echo $row['employee_id'];?>" title="Product Operation List"> Details </a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php endforeach;}?>
                                 </tbody>    
                            </table>
                        </div>
                        <div class="panel-footer" style="text-align: right;">
                            
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
<?php $this->load->view('template/footer');?>
