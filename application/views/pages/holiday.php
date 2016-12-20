<?php $this->load->view('template/header');?>

<script type="text/javascript">
var hn = '<?php echo base_url();?>holiday/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchHoliday").fadeIn(1000);        
    });
    $('input#searchHoliday').keyup( function() {
        var msg = $('#searchHoliday').val();
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
            var msg = $('#searchHoliday').val();
            $.post(hn+'/ #content_barang', {descp_msg: msg,pageNumber:pageNumber}, function(data) {
                $("#content_barang").html(data);
            });
            $('#pp').pagination({loading:false});
        }
    });
});

</script>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Holiday Panel</h4>
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
                            Holiday Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Type Holiday Code or Name" name="searchHoliday" id="searchHoliday" />
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
                            Holiday Entry Panel 
                            
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-holiday', 'id' => 'form-holiday', 'class' => 'form-holiday');
                            if(isset($holiday_id))
                            {
                                echo form_open("holiday/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("holiday/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Holiday Code</td>
                                    <td><input type="text" class="form-control" placeholder="Holiday Code" name="holidayId" id="holidayId" required readonly value="<?php if(isset($holiday_id)) echo $holiday_id; else echo $nextId;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Holiday Name</td>
                                    <td><input type="text" placeholder="Type Holiday Name" name="holidayName" id="holidayName" value="<?php if(isset($holiday_name)) echo $holiday_name;?>" required /></td>
                                </tr>
                                <tr>
                                    <td>Holiday From</td>
                                    <td>
                                        <input type="text" placeholder="" name="dateOfBirth" id="dateOfBirth" value="<?php if(isset($employeeDateOfBirth)) foreach ($employeeDateOfBirth as $key => $row): echo $row['employee_dateOfBirth']; endforeach;?>" required />
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
                                </tr>
                                <tr>
                                     <td>Holiday To</td>
                                    <td>
                                        <input type="text" placeholder="dd.mm.yyyy" name="holidayTo" id="holidayTo" value="<?php if(isset($holiday_to)) echo $holiday_to;?>" required />
                                        <script type="text/javascript">
                                            <!--
                                            $(document).ready(

                                                /* This is the function that will get executed after the DOM is fully loaded */
                                                function () {
                                                  $( "#holidayTo" ).datepicker({
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
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <?php
                                    if(isset($holiday_id))
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
                            <?php if(isset($holiday_id)){?>
                                  <a href="<?php echo base_url();?>holiday">New Entry</a>
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