<?php $this->load->view('template/header');?>
<script type="text/javascript">
var hn = '<?php echo base_url();?>salary_earning/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchSalaryEarning").fadeIn(1000);        
    });
    $('input#searchSalaryEarning').keyup( function() {
        var msg = $('#searchSalaryEarning').val();
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
        onSelectPage:function(pageNumber, pageSize){
            $('#pp').pagination({loading:true});
            var msg = $('#searchSalaryEarning').val();
            $.post(hn+'/ #content_barang', {descp_msg: msg,pageNumber:pageNumber}, function(data) {
                $("#content_barang").html(data);
            });
            $('#pp').pagination({loading:false});
        }
    });
  
    
});
function isFloatNumber(item,evt) 
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode==46)
    {
        var regex = new RegExp(/\./g)
        var count = $(item).val().match(regex).length;
        if (count > 1)
        {
            return false;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function updateInput(val, fieldName, spanName) 
{
      
    var basicSalary = $('#amount_1').val();
    var amount = Math.round(((val/100) * basicSalary)); 
   
    document.getElementById(spanName).innerHTML = val;
    document.getElementById(fieldName).value = amount;
}
</script>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Salary Earning Settings Panel</h4>
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
                <!-- /.col-lg-4 -->
                <div class="col-lg-8">
                    <div class="panel panel-info">
                        <div class="panel-heading ">
                            Salary Earning head Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Employee Type" name="searchSalaryEarning" id="searchSalaryEarning" />
                            </div>
                            <br />
                            <div id="content_barang"></div>
                        </div>
                        <div class="panel-footer">
                            <div id="pp"></div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
               
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Salary Earning Entry Panel 
                            
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-salaryearning', 'id' => 'form-salaryearning', 'class' => 'form-salaryearning');
                            if(isset($employee_type_id))
                            {
                                echo form_open("salary_earning/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("salary_earning/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Employee Type</td>
                                    <td>
                                        <select  name="employee_type" id="employee_type" required>
                                            
                                            <?php if(isset($employee_type_id)){?>
                                                <option value="<?php echo $employee_type_id;?>" selected><?php echo $employee_type_name;?></option>
                                            <?php } else{?>
                                                <option disabled selected>Select Type</option>
                                            <?php }?>
                                            <?php 
                                                if(isset($employeeType))
                                                {
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
                                <?php 
                                    if(isset($salaryEarningHead))
                                    {
                                    foreach ($salaryEarningHead as $key => $rows): 
                                        $salarayHead = $rows['salary_type_name'];
                                        $salaryId = $rows['salary_type_id']; 
                                ?>
                                <tr>
                                    <td><?php echo $salarayHead;?></td>
                                    <td><input type="text" name="amount_<?php echo $salaryId;?>" id="amount_<?php echo $salaryId;?>" placeholder="Amount" /><br />
                                   
                                        <?php if($salarayHead != 'Basic'){?>
                                        or <span id="percentage_<?php echo $salaryId;?>">0</span>%<input type="range" min="0" max="100" step="1" value="0" onchange="updateInput(this.value, 'amount_<?php echo $salaryId;?>', 'percentage_<?php echo $salaryId;?>');" />
                                        <?php }?>
                                    </td>
                                </tr>
                                <input type="hidden" name="salaryHeadId[]" value="<?php echo $salaryId; ?>">
                                    <?php endforeach;}?>
                                <?php 
                                    if(isset($salary_head_amount))
                                    {
                                    foreach ($salary_head_amount as $key => $rows): 
                                        $salarayHead = $rows['salary_type_name'];
                                        $salaryId = $rows['salary_head_id']; 
                                ?>
                                <tr>
                                    <td><?php echo $salarayHead;?></td>
                                    <td><input type="text" name="amount_<?php echo $salaryId;?>" id="amount_<?php echo $salaryId;?>" placeholder="Amount" value="<?php echo $rows['salary_head_amount'];?>" /><br />
                                   
                                        <?php if($salarayHead != 'Basic'){?>
                                        or <span id="percentage_<?php echo $salaryId;?>">0</span>%<input type="range" min="0" max="100" step="1" value="0" onchange="updateInput(this.value, 'amount_<?php echo $salaryId;?>', 'percentage_<?php echo $salaryId;?>');" />
                                        <?php }?>
                                    </td>
                                </tr>
                                <input type="hidden" name="salaryHeadId[]" value="<?php echo $salaryId; ?>">
                                    <?php endforeach;}?>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <?php
                                    if(isset($employee_type_id))
                                    {
                                        $submitButton = array(
                                            'name' => 'submit',
                                            'id' => 'submit',
                                            'value' => 'Update',
                                            'type' => 'submit',
                                            'class' => 'btn btn-success'
                                        );

                                        echo form_submit($submitButton);
                                    }
                                    else 
                                    {
                                        $submitButton = array(
                                            'name' => 'submit',
                                            'id' => 'submit',
                                            'value' => 'Submit',
                                            'type' => 'submit',
                                            'class' => 'btn btn-success'
                                        );

                                        echo form_submit($submitButton);
                                    }
                                    ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php echo form_close();?>
                        <div class="panel-footer" style="text-align: right;">
                            <?php if(isset($employee_type_id)){?>
                                  <a href="<?php echo base_url();?>salary_earning">New Entry</a>
                            <?php }?>
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