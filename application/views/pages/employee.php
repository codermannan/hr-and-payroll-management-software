<?php $this->load->view('template/header');?>
<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/jquery.ui.timepicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ui.timepicker.js"></script>
<script type="text/javascript">
    $(function(){
        $('#search-panel').hide();
        
        /***************Show Search Panel******************/
        $("#view-list").click(function(){
            $('#information-panel').hide();
            $('#search-panel').show();
        });
        /*********************************/
        /***************Show Info Panel******************/
        $("#back-to-add").click(function(){
            $('#information-panel').show();
            $('#search-panel').hide();
        });
        /*********************************/
        /**************Save Recode Into database*******************/
        $( "#adddialog" ).dialog({
              autoOpen: false,
              show: {
                effect: "blind",
                duration: 500
              },
              hide: {
                effect: "explode",
                duration: 500
              },
              buttons: {
                Ok: function() {
                  $( this ).dialog( "close" );
                }
              }
            });
        $( "#editdialog" ).dialog({
              autoOpen: false,
              show: {
                effect: "blind",
                duration: 500
              },
              hide: {
                effect: "explode",
                duration: 500
              },
              buttons: {
                Ok: function() {
                  $( this ).dialog( "close" );
                }
              }
            });
        $('#submit').click(function(){
                    
                          
            var unit =  $('#unit').val();
            var floor =  $('#floor').val();
            var section =  $('#section').val();
            var subsection =  $('#subsection').val();
            var incharge =  $('#incharge').val();
            var supervisor =  $('#supervisor').val();
            var employee_type =  $('#employee_type').val();
            var designation =  $('#designation').val();
            var pre_code =  $('#unitShortCode').val()+$('#floorShortCode').val()+$('#sectionShortCode').val();
            var employeeCode =  $('#employeeCode').val();
            var fullName =  $('#fullName').val();
            var guardianName =  $('#guardianName').val();
            var educationQualification =  $('#educationQualification').val();
            var grade =  $('#grade').val();
            var dateOfBirth =  $('#dateOfBirth').val();
            var joiningDate =  $('#joiningDate').val();
            var permanentAddress =  $('#permanentAddress').val();
            var presentAddress =  $('#presentAddress').val();
            var phone =  $('#phone').val();
            
            if(unit === null)
            {
                alert("Please Select Unit");
            }
           
            else if(floor == 0)
            {
                alert("Please Select Floor");
            }
            else if(section == 0)
            {
                alert("Please Select Section");
            }
            else if(subsection == 0)
            {
                alert("Please Select Sub Section");
            }
            else if(incharge == 0)
            {
                alert("Please Select Incharge");
            }
            else if(supervisor == 0)
            {
                alert("Please Select Supervisor");
            }
            else if(employee_type === null)
            {
                alert("Please Select Employee Type");
            }
            else if(designation == 0)
            {
                alert("Please Select Designation");
            }
            else if(employeeCode == "")
            {
                alert("Please Enter Employee Code");
            }
            else if(fullName == "")
            {
                alert("Please Enter Full Name");
            }
            
            else
            {
                var qurl = '<?php echo base_url();?>employee/submitData';
                var qurl2 = '<?php echo base_url();?>employee/submitDataToSalary';
                $.ajax({
                    url:qurl,
                    type:"POST",
                    data:{
                        unitId:unit,
                        floorId:floor,
                        sectionId:section,
                        subsectionId:subsection,
                        inchargeId:incharge,
                        supervisorId:supervisor,
                        employee_typeId:employee_type,
                        designationId:designation,
                        pre_code:pre_code,
                        employeeCode:employeeCode,
                        fullName:fullName,
                        guardianName:guardianName,
                        educationQualification:educationQualification,
                        grade:grade,
                        dateOfBirth:dateOfBirth,
                        joiningDate:joiningDate,
                        permanentAddress:permanentAddress,
                        presentAddress:presentAddress,
                        phone:phone
                    },
                    success:function(data){
                       
                       <?php foreach ($salaryEarningHead as $key => $rows):?>
                        var fieldId_<?php echo $rows['salary_type_id'];?> = $('#amount_'+<?php echo $rows['salary_type_id'];?>).val();
                        $.ajax({
                            url:qurl2,
                            type:"POST",
                            data:{employee_id:data, salary_type_id:<?php echo $rows['salary_type_id'];?>, amount:fieldId_<?php echo $rows['salary_type_id'];?>},
                            success:function(data){
                                //alert(data);
                        }
                        });
                <?php endforeach;?>
                    }
                });
                 
                       
               $( "#adddialog" ).dialog( "open" );
            }
        });
        /*********************************/
        /**************Update Recode Into database*******************/
        $('#edit').click(function(){
            
            var pre_code = "";
            var editablePrecode = $('#pre_code').val();
            var unit =  $('#unit').val();
            var floor =  $('#floor').val();
            var section =  $('#section').val();
            var subsection =  $('#subsection').val();
            var incharge =  $('#incharge').val();
            var supervisor =  $('#supervisor').val();
            var employee_type =  $('#employee_type').val();
            var designation =  $('#designation').val();
            if(!$('#unitShortCode').val() || !$('#floorShortCode').val() || !$('#sectionShortCode').val())
                pre_code =  editablePrecode;
            else
                pre_code = $('#unitShortCode').val()+$('#floorShortCode').val()+$('#sectionShortCode').val();
            
            var employeeCode =  $('#employeeCode').val();
            var fullName =  $('#fullName').val();
            var guardianName =  $('#guardianName').val();
            var educationQualification =  $('#educationQualification').val();
            var grade =  $('#grade').val();
            var dateOfBirth =  $('#dateOfBirth').val();
            var joiningDate =  $('#joiningDate').val();
            var permanentAddress =  $('#permanentAddress').val();
            var presentAddress =  $('#presentAddress').val();
            var phone =  $('#phone').val();
            var employeeID = $('#employeeId').val();
            
            var qurl = '<?php echo base_url();?>employee/edit';
            var qurl2 = '<?php echo base_url();?>employee/editDataToSalary';
            $.ajax({
                url:qurl,
                type:"POST",
                data:{
                    unitId:unit,
                    floorId:floor,
                    sectionId:section,
                    subsectionId:subsection,
                    inchargeId:incharge,
                    supervisorId:supervisor,
                    employee_typeId:employee_type,
                    designationId:designation,
                    pre_code:pre_code,
                    employeeCode:employeeCode,
                    fullName:fullName,
                    guardianName:guardianName,
                    educationQualification:educationQualification,
                    grade:grade,
                    dateOfBirth:dateOfBirth,
                    joiningDate:joiningDate,
                    permanentAddress:permanentAddress,
                    presentAddress:presentAddress,
                    phone:phone,
                    employeeId: employeeID,
                },
                success:function(data){
                   
                   <?php foreach ($salaryEarningHead as $key => $rows):?>
                    var fieldId_<?php echo $rows['salary_type_id'];?> = $('#amount_'+<?php echo $rows['salary_type_id'];?>).val();
                    $.ajax({
                        url:qurl2,
                        type:"POST",
                        data:{employee_id:data, salary_type_id:<?php echo $rows['salary_type_id'];?>, amount:fieldId_<?php echo $rows['salary_type_id'];?>},
                        success:function(data){
                            
                    }
                    });
                    <?php endforeach;?>
                   
                }
            });
             $( "#editdialog" ).dialog( "open" );        

        });
        /*********************************/
        /***************Reset Value Info Panel******************/
        $("#reset").click(function(){
            $('#designation').val('');
            $('#fullName').val('');
            $('#guardianName').val('');
            $('#permanentAddress').val('');
            $('#presentAddress').val('');
            $('#educationQualification').val('');
            $('#dateOfBirth').val('');
            $('#joiningDate').val('');
            $('#grade').val('');
            $('#basicSalary').val('');
            $('#houseRent').val('');
            $('#medicalAllowance').val('');
            $('#transport').val('');
            $('#foodBeverage').val('');
            $('#totalSalary').val('');
        });
        /**************Calculate Salary*******************/
        $('.salary').keyup(function () {
            var sum = 0;
            $('.salary').each(function() {
                sum += Number($(this).val());
            });
     
            $('#totalSalary').val(sum);
     
        });
        /*********************************/
        
    });
    
</script>
<script type="text/javascript">
var hn = '<?php echo base_url();?>employee/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchEmployee").fadeIn(1000);        
    });
    $('input#searchEmployee').keyup( function() {
        var msg = $('#searchEmployee').val();
        $.post(hn, {descp_msg: msg}, function(data) {
            $("#content_barang").html(data);
            $('#pp').pagination({
                pageNumber:1,
                total:$('#recNum').val(),
                //tentukan banyak rec yg mau ditampilkan disini
                pageList:[20],
                //sembunyikan pagelist pagintion easyui
                showPageList:false
            });
        });
    }).keyup();
});

$(function(){
    $('#pp').pagination({
        total:$('#recNum').val(),
        pageList:[20],
        showPageList:true,
        onSelectPage:function(pageNumber, pagesize){
            $('#pp').pagination({loading:true});
            var msg = $('#searchEmployee').val();
            $.post(hn+'/ #content_barang', {descp_msg: msg,pageNumber:pageNumber}, function(data) {
                $("#content_barang").html(data);
            });
            $('#pp').pagination({loading:false});
        }
    });
});
function setSalary()
{
    var employeeCodeId = $('#employee_type').val();
    
    var sum = 0;
    
            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>employee/loadSalary/",
            data: { 'employeeCodeId': employeeCodeId  },
            success: function(data){
                // Parse the returned json data

                   var opts = $.parseJSON(data);
                   $.each(JSON.parse(opts), function(idx, obj) {
                        //alert(obj.amount);
                        $('#amount_'+obj.id).val(obj.amount);
                        sum += Number($('#amount_'+obj.id).val());

                   });
                    $('#totalSalary').val(sum);
            }
        });
    
}

<?php if(isset($employee_id)){?>
    
    employeeId = <?php echo $employee_id;?>;
    var sum = 0;
    $('document').ready(function(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>employee/loadEmployeeSalary/",
            data: { 'employeeId': employeeId  },
            success: function(data){
                // Parse the returned json data

                   var opts = $.parseJSON(data);
                   $.each(JSON.parse(opts), function(idx, obj) {
                        //alert(obj.amount);
                        $('#amount_'+obj.id).val(obj.amount);
                        sum += Number($('#amount_'+obj.id).val());

                   });
                    $('#totalSalary').val(sum);
            }
        });
    });
<?php }?>
function setFloorCode()
{
    $('#floor').empty()
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
    $('#section').empty()
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
    $('#subsection').empty()
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
    $('#incharge').empty()
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
    $('#supervisor').empty()
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
function setDesignationCode()
{
    $('#designation').empty()
    var employeeCodeId = $('#employee_type').val();
    
    $('#designation').append('<option value="0">Select Designation</option>');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>employee/loadDesignation/",
        data: { 'employeeCodeId': employeeCodeId  },
        success: function(data){
            // Parse the returned json data

               var opts = $.parseJSON(data);
               $.each(JSON.parse(opts), function(idx, obj) {

                    $('#designation').append('<option value="' + obj.value + '">' + obj.label + '</option>');
               });
        }
    });
}


function setUnitShortCode()
{
   $('#pre_code').val('');
            $('#pre_code').hide();
    var unit_code = $('#unit').val();
    //alert(unit_code);
    if(!!unit_code)
    {  
            
            
            $.ajax({    //create an ajax request to load_page.php
            type: "POST",
            url: "<?php echo base_url();?>employee/getCode/unit/unit_short_code/unit_id/"+unit_code,             
            dataType: "text",   //expect html to be returned                
            success: function(response){ 
                //alert(response);
                //
//
                document.getElementById('unitShortCode').value = response;
                //alert(unit_code);
            }
       });
        
    }
    
   
}
function setFloorShortCode()
{
    
    var floor_code = $('#floor').val();
    
    if(!!floor_code)
    {  
         $.ajax({    //create an ajax request to load_page.php
            type: "POST",
            url: "<?php echo base_url();?>employee/getCode/floor/floor_short_code/floor_id/"+floor_code,             
            dataType: "text",   //expect html to be returned                
            success: function(response){                    
                 document.getElementById('floorShortCode').value = response;
                //alert(unit_code);
            }
       });
    }
}
function setSectionShortCode()
{
    
    var section_code = $('#section').val();
    
   if(!!section_code)
    {  
        $.ajax({    //create an ajax request to load_page.php
            type: "POST",
            url: "<?php echo base_url();?>employee/getCode/section/section_short_code/section_id/"+section_code,             
            dataType: "text",   //expect html to be returned                
            success: function(response){                    
                 document.getElementById('sectionShortCode').value = response;
                //alert(unit_code);
            }
       });
    }

}
</script>

<body>
<div id="adddialog" title="Add Employee">
  <p>Employee Record Has Been Saved Successfully!</p>
</div>
<div id="editdialog" title="Edit Employee">
  <p>Employee Record Has Been Successfully Update!</p>
</div>
    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Employee Entry panel</h4>
            <div class="row">
                <div class="col-lg-12">
                    <?php if(isset($successInsered)){?>
                        <div class="alert alert-success" role="alert"><?php echo $successInsered;?></div>
                    <?php 
                        }
                        if(isset($errorInsered))
                        {
                    ?>
                        <div class="alert alert-danger" role="alert"><?php echo errorInsered;?></div>
                    <?php }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <!-- /.col-lg-4 -->
                <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                <?php
                    $attributes = array('name' => 'form-employee', 'id' => 'form-employee', 'class' => 'form-employee');
                    echo form_open("", $attributes);
                ?>
                <div class="col-lg-4" id="selection-panel">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             Selection Panel
                        </div>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Unit</td>
                                    <td>
                                        <select  name="unit" id="unit" onchange="setFloorCode();setUnitShortCode();" required>
                                            <option disabled selected>Select Unit</option>
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
                                </tr>
                                <tr>
                                    <td>Floor</td>
                                    <td>
                                        <select  name="floor" id="floor" onchange="setSectionCode();setFloorShortCode();" required>
                                            <option disabled selected value="0">Select Floor</option>
                                            <?php if($floor_id != 0){?>
                                                <option value="<?php echo $floor_id;?>" selected><?php echo $floor_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Section</td>
                                    <td>
                                        <select  name="section" id="section" onchange="setSubSectionCode();setSectionShortCode();" required>
                                            <option>Select Section</option>
                                            <?php if($section_id != 0){?>
                                                <option value="<?php echo $section_id;?>" selected><?php echo $section_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sub Section</td>
                                    <td>
                                        <select  name="subsection" id="subsection" onchange="setInchargeCode();" required>
                                            <option>Select Sub Section</option>
                                            <?php if($subsection_id != 0){?>
                                                <option value="<?php echo $subsection_id;?>" selected><?php echo $subsection_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                <tr>
                                    <td>Incharge</td>
                                    <td>
                                        <select  name="incharge" id="incharge" onchange="setSupervisorCode();">
                                            <option>Select Incharge</option>
                                            <?php if($incharge_id != 0){?>
                                                <option value="<?php echo $incharge_id;?>" selected><?php echo $incharge_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supervisor</td>
                                    <td>
                                        <select  name="supervisor" id="supervisor" required>
                                            <option>Select Supervisor</option>
                                            <?php if($supervisor_id != 0){?>
                                                <option value="<?php echo $supervisor_id;?>" selected><?php echo $supervisor_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Employee Type</td>
                                    <td>
                                        <select  name="employee_type" id="employee_type" onchange="setDesignationCode();setSalary();" required>
                                            <option disabled selected>Select Type</option>
                                            <?php 
                                                if(isset($employeeType))
                                                {
                                                    
                                                    if($employee_type_id != 0)
                                                    {
                                                        
                                            ?>
                                                        <option value="<?php echo $employee_type_id;?>" selected><?php echo $employee_type_name;?></option>
                                            <?php
                                                    }
                                                    foreach ($employeeType as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['employee_type_id'];?>"><?php echo $row['employee_type_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Employee Type Not Found</option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Designation</td>
                                    <td>
                                        <select name="designation" id="designation" required>
                                            <option> Select Designation</option>
                                            <?php if($designation_id != 0){?>
                                                <option value="<?php echo $designation_id;?>" selected><?php echo $designation_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <nav>
                                <ul class="pager">
<!--                                    <li class="previous"><a href="#" id="reset">View List</a></li>-->
                                    <li class="next"><a href="#" id="view-list">View List</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-8" id="information-panel">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             Information Panel
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php if(isset($employee_id)){?>
                            <a href="<?php echo base_url();?>employee" style="color: #ffffff">Add New Employee</a>
                            <?php }?>
                        </div>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Employee Code</td>
                                    <td colspan="2" style="text-align: left;">
                                        <?php if(isset($employee_pre_code)){ ?>
                                        <input name="pre_code" id="pre_code" value="<?php echo $employee_pre_code;?>" style="width: 60px; border: none; font-size: 10px;" />
                                        <?php }?>
                                        <input style="width: 20px; border: none; font-size: 10px;" value="<?php if(isset($unit_short_code)) echo $unit_short_code;?>" readonly name="unitShortCode" id="unitShortCode"  />
                                        <input style="width: 20px; border: none; font-size: 10px;" value="<?php if(isset($floor_short_code)) echo $floor_short_code;?>" readonly name="floorShortCode" id="floorShortCode"  />
                                        <input style="width: 20px; border: none; font-size: 10px;" value="<?php if(isset($section_short_code)) echo $section_short_code;?>" readonly name="sectionShortCode" id="sectionShortCode" />-
                                        
                                        <input type="text" style="width: 60px; font-size: 10px;" placeholder="" name="employeeCode" id="employeeCode" value="<?php if(isset($employee_code)) echo $employee_code;?>" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Full Name</td>
                                    <td><input type="text" placeholder="" name="fullName" id="fullName" value="<?php if(isset($employee_name)) echo $employee_name;?>" required /></td>
                                    <td> Guardian's Name</td>
                                    <td><input type="text" placeholder="" name="guardianName" id="guardianName" value="<?php if(isset($employee_guardian)) echo $employee_guardian;?>" required /></td>
                                </tr>
                                <tr>
                                    <td>Education Qualification</td>
                                    <td><input type="text" placeholder="" name="educationQualification" id="educationQualification" value="<?php if(isset($employee_education)) echo $employee_education;?>" required /></td>
                                    <td>Grade</td>
                                    <td><input type="text" placeholder="" name="grade" id="grade" value="<?php if(isset($employee_grade)) echo $employee_grade;?>" required /></td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>
                                        <input type="text" placeholder="" name="dateOfBirth" id="dateOfBirth" value="<?php if(isset($employee_dateOfBirth)) echo $employee_dateOfBirth;?>" required />
                                        <script type="text/javascript">
                                            <!--
                                            $(document).ready(

                                                /* This is the function that will get executed after the DOM is fully loaded */
                                                function () {
                                                  $( "#dateOfBirth" ).datepicker({
                                                    changeMonth: true,//this option for allowing user to select month
                                                    changeYear: true,
                                                    dateFormat: 'dd.mm.yy'//this option for allowing user to select from year range
                                                  });
                                                }

                                              );
                                            //-->
                                        </script>
                                    </td>
                                    <td>Joining Date</td>
                                    <td>
                                        <input type="text" placeholder="" name="joiningDate" id="joiningDate" value="<?php if(isset($employee_joiningDate)) echo $employee_joiningDate;?>" required />
                                        <script type="text/javascript">
                                            <!--
                                            $(document).ready(

                                                /* This is the function that will get executed after the DOM is fully loaded */
                                                function () {
                                                  $( "#joiningDate" ).datepicker({
                                                    changeMonth: true,//this option for allowing user to select month
                                                    changeYear: true, //this option for allowing user to select from year range
                                                    dateFormat: 'dd.mm.yy'
                                                    });
                                                }

                                              );
                                            //-->
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:top;">Permanent Address</td>
                                    <td><textarea placeholder="" name="permanentAddress" id="permanentAddress" required ><?php if(isset($employee_permanentAddress)) echo $employee_permanentAddress;?></textarea></td>
                                    <td style="vertical-align:top;">Present Address</td>
                                    <td><textarea placeholder="" name="presentAddress" id="presentAddress" required ><?php if(isset($employee_presentAddress)) echo $employee_presentAddress;?></textarea></td>
                                </tr>
                                <tr>
                                    <td>
                                        Phone Number
                                    </td>
                                    <td>
                                        <input type="text" placeholder="" name="phone" id="phone" required value="<?php if(isset($employee_phone)) echo $employee_phone;?>" />
                                    </td>
                                    
                                </tr>
                                <tr>
                                <?php $counter = 0; foreach ($salaryEarningHead as $key => $rows): $salarayHead = $rows['salary_type_name'];$salaryId = $rows['salary_type_id']; ?>
                                    <?php if($counter == 2){?>
                                    </tr>
                                    <tr>
                                    <?php $counter = 0;}?>
                                    <td><?php echo $salarayHead;?></td>
                                    <td><input class="salary" type="text" name="amount_<?php echo $salaryId?>" id="amount_<?php echo $salaryId?>" placeholder="Amount" /><br />
                                    <input type="hidden" name="salaryHeadId" value="<?php echo $salaryId; ?>">
                                    
                                <?php $counter++;endforeach;?>
                                <tr>
                                    <td>Total Salary</td>
                                    <td><input type="text" placeholder="" name="totalSalary" id="totalSalary" required value="<?php if(isset($employeeTotalSalary)) foreach ($employeeTotalSalary as $key => $row): echo $row['salary_total']; endforeach;?>" readonly="readonly" /></td>
                                </tr>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <nav>
                                <ul class="pager">
                                    <li class="previous"><a href="#" id="reset">Reset</a></li>
                                    <?php if(isset($employee_id)){?>
                                    <input type="text" hidden="hidden" value="<?php echo $employee_id;?>" name="employeeId" id="employeeId" />
                                        <li class="next"><a href="#" id="edit">Edit</a></li>
                                    <?php }else{?>
                                    <li class="next"><a href="#" id="submit">Add</a></li>
                                    <?php }?>
                                </ul>
                            </nav>
                                    
                        </div>
                    </div>
                </div>
                <?php echo form_close();?>
                <!-- /.col-lg-4 -->
                <div class="col-lg-8" id="search-panel">
                    <div class="panel panel-info">
                        <div class="panel-heading ">
                            Employee Search Panel
                            
                           
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo base_url();?>employee" id="back-to-add">Add New Employee</a>
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Type Employee ID or Name or Designation" name="searchEmployee" id="searchEmployee" />
                            </div>
                            <br />
                            <div id="content_barang"></div>
                        </div>
                        <div class="panel-footer">
                            <div id="pp"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
<?php $this->load->view('template/footer');?>