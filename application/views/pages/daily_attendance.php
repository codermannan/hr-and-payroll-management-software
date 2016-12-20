<?php $this->load->view('template/header');?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/table-css.css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ui.timepicker.js"></script>
<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/jquery.ui.timepicker.css" rel="stylesheet" />

<script type="text/javascript">

$(document).ready(function() {
    display_ct();
    
    $("#employeeId").keypress(function(e) {
        if(e.which == 13) {
            if($('#employeeId').val()!="" && isNaN($('#employeeId').val())==false){
                updateAttendance();
            }
        }
        
        function updateAttendance(){
            $("#searchTable tbody tr").remove();
            
            var employeeId = $('#employeeId').val();
            
            var now = new Date(); 
            var datetime = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds(); 
            document.getElementById("outTime").value = datetime;
            
            $.ajax({
                type : 'POST',
                dataType : 'JSON',
                url : "<?php echo base_url(); ?>Daily_Attendance/checkAttendance/",
                data : {'employeeId':employeeId},
                success:function(data){
                    if(data==1){
                        $.ajax({
                            type: "POST",
                            dataType: 'json',
                            url: "<?php echo base_url();?>Daily_Attendance/getsingleEmpDailyAttendanceData/",
                            data: { 'employeeId': employeeId },
                            success: function(data){  
                                //place data into attendence sheet
                                $.each(data, function(index, element) {
                                    
                                    if(element.daily_attendance_status == 0){
                                        var status = 'L';
                                    }else{
                                        var status = 'P';
                                    }
                                    
                                    $("#employeeCode").val(element.employee_pre_code+"-"+element.employee_code);
                                    $("#employeeName").val(element.employee_name);
                                    $("#Designation").val(element.designation_name);
                                    $("#inTime").val(element.daily_attendance_intime);
                                    $("#status").val(status);
                                });
                                
                                //update
                                
                                $.ajax({
                                    type : 'POST',
                                    dataType : 'JSON',
                                    url : "<?php echo base_url()?>Daily_Attendance/updateAttendance/",
                                    data : {'employeeId':employeeId,'outTime': $("#outTime").val()},
                                    success:function(data){
//                                        alert(214);
                                    }
                                });
                                
                                //remove data from box
                                $("#employeeId").val("");
                                $("#employeeCode").val("");
                                $("#employeeName").val("");
                                $("#Designation").val("");
                                $("#inTime").val("");
                                $("#outTime").val("");
                                $("#status").val("");
                                //show data
                                
                                $.ajax({
                                    type : 'POST',
                                    dataType : 'JSON',
                                    url : "<?php echo base_url()?>Daily_Attendance/getDailyAttendanceData/",
                                    data : {'employeeId':employeeId},
                                    success:function(data){
                                        $.each(data, function(index, element){
                                            if(element.daily_attendance_status == 0){
                                                var status = 'L';
                                            }else{
                                                var status = 'P';
                                            }
                                            $("#searchTable").append('<tr><td align="center">'+element.daily_attendance_employee_id+'</td><td align="center">'+element.employee_code+'-'+element.employee_pre_code+'</td><td align="center">'+element.employee_name+'</td><td align="center">'+element.designation_name+'</td><td align="center">'+element.daily_attendance_intime+'</td><td align="center">'+element.daily_attendance_outtime+'</td><td align="center">'+status+'</td></tr>');
                                           });
                                    }
                                });
                                
                            }
                        });
                        
                    }else{
                        takeAttendance();
                    }
                    
                }
            });
//            alert(1);
        }

        function takeAttendance(){ 
            $("#searchTable tbody tr").remove();
            var employeeId = $('#employeeId').val();

            var now = new Date(); 
            var datetime = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds(); 
            document.getElementById("inTime").value = datetime;
            
            var cyear = now.getFullYear();
            var cmonth = now.getMonth();
            var cday = now.getDay();
            
            var systemTime930 = new Date(cyear, cmonth, cday, now.getHours(), now.getMinutes(), now.getSeconds(), 0).getTime();
            var manualTime930 = new Date(cyear, cmonth, cday, 9, 30, 0, 0).getTime();

            if(systemTime930 < manualTime930){
                document.getElementById("status").value = 'P';
            }else{
                document.getElementById("status").value = 'L';
            }
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url();?>Daily_Attendance/getEmpInfo/",
                data: { 'employeeId': employeeId },
                success: function(data){  
                    //place data into search box
                    $.each(data, function(index, element) {
                        $("#employeeCode").val(element.employee_pre_code+"-"+element.employee_code);
                        $("#employeeName").val(element.employee_name);
                        $("#Designation").val(element.designation_name);
                    });   
                   
                   if(data!=""){
                    $.ajax({ // insert attendence
                        type: "POST",
                        dataType: 'json',
                        url: "<?php echo base_url();?>Daily_Attendance/insertAttInfo/",
                        data: { 'employeeId': $("#employeeId").val() , 
                                'inTime': $("#inTime").val() , 
                                'outTime': $("#outTime").val(),
                                'status': $("#status").val()},
                        success: function(data){
                            //get all data
                            $.each(data, function(index, element){
                                if(element.daily_attendance_status == 0){
                                    var status = 'L';
                                }else{
                                    var status = 'P';
                                }
                                $("#searchTable").append('<tr><td align="center">'+element.daily_attendance_employee_id+'</td><td align="center">'+element.employee_code+'-'+element.employee_pre_code+'</td><td align="center">'+element.employee_name+'</td><td align="center">'+element.designation_name+'</td><td align="center">'+element.daily_attendance_intime+'</td><td align="center">'+element.daily_attendance_outtime+'</td><td align="center">'+status+'</td></tr>');
                            });
                            
                            //remove all search filed data
                            //remove data from box
                            $("#employeeId").val("");
                            $("#employeeCode").val("");
                            $("#employeeName").val("");
                            $("#Designation").val("");
                            $("#inTime").val("");
                            $("#outTime").val("");
                            $("#status").val("");
                            
                        }
                     }); //closea jax
                   } //close if
                }
            });
        } //end take attendance
   
    });
    
});

function myPrint() {
    var printContents = document.getElementById('searchPanel').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<script type="text/javascript"> 
function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
var strcount
var currentTime = new Date();
var hours = currentTime.getHours();
var minutes = currentTime.getMinutes();
var second = currentTime.getSeconds();
var x = hours+ ":" + minutes + ":" + second;
//var x = new Date('hh:mm:ss');
document.getElementById('currentTime').value = x;
tt=display_c();
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
                            <h5>Daily Attendance System</h5> 
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-salary-view', 'id' => 'form-salary-view', 'class' => 'form-salary-view');
                            echo form_open("salary_sheet_view/searchLimitMonthData", $attributes);
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td style="font-size: 12px;font-weight: bold;">Date: </td>
                                    <td style="font-size: 12px;font-weight: bold;"><?php $toDate = date('d-m-Y'); echo $toDate;?></td>
                                    <td style="width: 50px;">&nbsp;</td>
                                    <td style="font-size: 12px;font-weight: bold;">Time:</td>
                                    <td style="font-size: 12px;font-weight: bold;"><input id="currentTime" name="currentTime" readonly /></span></td>
                                    <td style="width: 50px;">&nbsp;</td>
                                    <td style="width: 50px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="width: 50px;">&nbsp;</td>
                                    <td style="width: 50px;">&nbsp;</td>
                                    <td style="width: 50px;">&nbsp;</td>
                                    <td style="width: 50px;">&nbsp;</td>
                                    <td style="width: 50px;">&nbsp;</td>
                                    <td style="width: 50px;">&nbsp;</td>
                                    <td style="width: 50px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="employeeId" id="employeeId" style="width: 83px;" autofocus /></td>
                                    <td><input type="text" name="employeeCode" id="employeeCode" style="width: 90px;" readonly/></td>
                                    <td><input type="text" name="employeeName" id="employeeName" style="width: 150px;" readonly/></td>
                                    <td><input type="text" name="Designation" id="Designation" style="width: 150px;" readonly/></td>
                                    <td><input type="text" name="inTime" id="inTime" style="width: 150px;" readonly/></td>
                                    <td><input type="text" name="outTime" id="outTime" style="width: 150px;" readonly/></td>
                                    <td><input type="text" name="status" id="status" style="width: 50px;" readonly/></td>
                               </tr>
                            </table>
                        </div>
                        <div id="searchPanel" style="height: 450px;">
                            <table id="searchTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; width: 83px;">Employee ID</th>
                                        <th style="text-align: left; width: 90px;">Employee Code</th>
                                        <th style="text-align: left; width: 150px;">Employee Name</th>
                                        <th style="text-align: left; width: 100px;">Designation</th>
                                        <th style="text-align: left; width: 150px;">In Time</th>
                                        <th style="text-align: left; width: 150px;">Out Time</th>
                                        <th style="text-align: left; width: 50px;">Status</th>
                                        </tr>
                                 </thead>
                                 <tbody>
<!--                                        <tr>
                                            <td><input type="text" name="employeeId" id="employeeId" style="width: 83px;" autofocus /></td>
                                            <td><input type="text" name="employeeCode" id="employeeCode" style="width: 90px;" /></td>
                                            <td><input type="text" name="employeeName" id="employeeName" style="width: 150px;" /></td>
                                            <td><input type="text" name="Designation" id="Designation" style="width: 100px;" /></td>
                                            <td><input type="text" name="inTime" id="inTime" style="width: 150px;" /></td>
                                            <td><input type="text" name="outTime" id="outTime" style="width: 150px;" /></td>
                                            <td><input type="text" name="status" id="status" style="width: 50px;" /></td>
                                        </tr>-->
                                        
                                 </tbody>    
                            </table>
                        </div>
                        <div class="panel-footer" style="text-align: right;">
                        <a href="#" onclick="myPrint();">Print <span class="glyphicon glyphicon-print"></span></a>    
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
