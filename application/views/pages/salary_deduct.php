<?php $this->load->view('template/header');?>
<script type="text/javascript">
var hn = '<?php echo base_url();?>salary_deduct/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchSalaryDeduct").fadeIn(1000);        
    });
    $('input#searchSalaryDeduct').keyup( function() {
        var msg = $('#searchSalaryDeduct').val();
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
            var msg = $('#searchSalaryDeduct').val();
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
</script>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Salary Deduction Head Panel</h4>
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
                            Salary Deduction Head Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Code/Advance/PF Fund/Other Deduction" name="searchSalaryDeduct" id="searchSalaryDeduct" />
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
                            Salary Deduction Head Entry Panel 
                            
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-salaryDeduct', 'id' => 'form-salaryDeduct', 'class' => 'form-salaryDeduct');
                            if(isset($salary_deduct_id))
                            {
                                echo form_open("salary_deduct/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("salary_deduct/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                    <tr>
                                        <td>Deduction Id</td>
                                        <td><input type="text" class="form-control" name="salaryDeductId" id="salaryDeductId" required readonly value="<?php if(isset($salary_deduct_id)) echo $salary_deduct_id; else echo $nextId;?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Advance</td>
                                        <td><input type="text" placeholder="Only numbers" name="salaryAdvance" id="salaryAdvance" onkeypress="return isFloatNumber(this,event);" id="salaryBasic" value="<?php if(isset($salary_deduct_advance)) echo $salary_deduct_advance;?>" setp="any" required /></td>
                                    </tr>
                                    <tr>
                                        <td>PF fund</td>
                                        <td><input type="text" placeholder="Only numbers" name="salaryPFfund" id="salaryPFfund" onkeypress="return isFloatNumber(this,event);" id="salaryHouserent" value="<?php if(isset($salary_deduct_pf)) echo $salary_deduct_pf;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Other Deduction</td>
                                        <td><input type="text" placeholder="Only numbers" name="salaryOtherDeduct" id="salaryOtherDeduct" onkeypress="return isFloatNumber(this,event);" id="salaryMedical" value="<?php if(isset($salary_deduct_other)) echo $salary_deduct_other;?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                        <?php
                                        if(isset($salary_deduct_id))
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
                            <?php if(isset($salary_id)){?>
                                  <a href="<?php echo base_url();?>salary_deduct">New Entry</a>
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