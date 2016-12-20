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
    
    
     $('#form-salary-view').submit(function(event){
         
        if($('#FromMonth').val() == 0)
        {
            alert("Please Select From Month!");
            return false;
        }
        else if($('#toMonth').val() == 0)
        {
            alert("Please Select To Month!");
            return false;
        }
        else if($('#year').val() == 0)
        {
            alert("Please Select Year!");
            return false;
        }
        else
        {
            return true;
        }
     });
        
} );
function myPrint() {
    var printContents = document.getElementById('searchPanel').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
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
                            <h5>Employee Salary Entry Panel</h5> 
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-salary-view', 'id' => 'form-salary-view', 'class' => 'form-salary-view');
                            echo form_open("production_view/searchLimitMonthData", $attributes);
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>From Month</td>
                                    <td>
                                        <select id="fromMonth" name="fromMonth">
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
                                    <td>To Month</td>
                                    <td>
                                        <select id="toMonth" name="toMonth">
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
                                    <td>Year</td>
                                    <td>
                                        <select id="year" name="year">
                                            <option value="0">Select Year</option>
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
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
                                    <td>Or</td>
                                    <td><h5><a href="<?php echo base_url();?>production_view/searchCurrent" style="font-weight:bold; color: #00ee00;">Current Month</a></h5></td>
                                </tr>
                            </table>
                            
                        </div>
                        <div id="searchPanel" style="height: 380px;">
                            <table id="searchTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; width: 90px;">Employee Code</th>
                                        <th style="text-align: left; width: 90px;">Employee Name</th>
                                        <th style="text-align: left; width: 90px;">Designation</th>
                                        <th style="text-align: left; width: 90px;">Production Operation</th>
                                        <th style="text-align: left; width: 90px;">Quantity</th>
                                        <th style="text-align: left; width: 90px;">Production Bonus</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php 
                                            if(isset($productionData))
                                            { 
                                               // var_dump($salaryData);
                                                foreach ($productionData as $key => $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $row['employee_pre_code']."-".$row['employee_code'];?></td>
                                            <td><?php echo $row['employee_name'];?></td>
                                            <td><?php echo $row['designation_name'];?></td>
                                            <td><?php echo $row['product_section_name'];?></td>
                                            <td><?php echo $row['production_quantity'];?></td>
                                            <td style="text-align: right;"><?php echo $row['production_bonus_amount'];?></td> 
                                        </tr>
                                        <?php endforeach;}?>
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
