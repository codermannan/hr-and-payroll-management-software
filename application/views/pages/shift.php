<?php $this->load->view('template/header');?>
<script type="text/javascript">
var hn = '<?php echo base_url();?>shift/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchShift").fadeIn(1000);        
    });
    $('input#searchShift').keyup( function() {
        var msg = $('#searchShift').val();
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
            var msg = $('#searchShift').val();
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
            <h4>Shift Panel</h4>
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
                            Shift Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Type Shift Code or Id" name="searchShift" id="searchShift" />
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
                            Shift Entry Panel 
                            
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-shift', 'id' => 'form-shift', 'class' => 'form-shift');
                            if(isset($shift_id))
                            {
                                echo form_open("shift/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("shift/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Shift Id</td>
                                    <td><input type="text" class="form-control" placeholder="Shift Id" name="shiftId" id="shiftId" required readonly value="<?php if(isset($shift_id)) echo $shift_id; else echo $nextId;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Shift Code</td>
                                    <td><input type="text" class="form-control" placeholder="Type Shift code" name="shiftCode" id="shiftCode" value="<?php if(isset($shift_code)) echo $shift_code;?>" required /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <?php
                                    if(isset($shift_id))
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
                            <?php if(isset($shift_id)){?>
                                  <a href="<?php echo base_url();?>shift">New Entry</a>
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