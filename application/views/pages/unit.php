<?php $this->load->view('template/header');?>
<script type="text/javascript">
var hn = '<?php echo base_url();?>unit/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchUnit").fadeIn(1000);        
    });
    $('input#searchUnit').keyup( function() {
        var msg = $('#searchUnit').val();
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
            var msg = $('#searchUnit').val();
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
            <h4>Unit Panel</h4>
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
                            Unit Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Type Unit Code or Name" name="searchUnit" id="searchUnit" />
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
                            Unit Entry Panel 
                            
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-unit', 'id' => 'form-unit', 'class' => 'form-unit');
                            if(isset($unit_id))
                            {
                                echo form_open("unit/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("unit/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Unit Code</td>
                                    <td><input type="text" class="form-control" placeholder="Unit Code" name="unitCode" id="unitCode" required readonly value="<?php if(isset($unit_id)) echo $unit_id; else echo $nextId;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Unit Name</td>
                                    <td><input type="text" placeholder="Type Unit Name" name="unitName" id="unitName" value="<?php if(isset($unit_name)) echo $unit_name;?>" required /></td>
                                </tr>
                                <tr>
                                    <td>Unit Short Code</td>
                                    <td><input type="text" placeholder="Type Unit Code" name="unitShortCode" id="unitShortCode" value="<?php if(isset($unit_short_code)) echo $unit_short_code;?>" required /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php
                                        if(isset($unit_id))
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
                            <?php if(isset($unit_id)){?>
                                  <a href="<?php echo base_url();?>unit">New Entry</a>
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
