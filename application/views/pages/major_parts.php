<?php $this->load->view('template/header');?>
<script type="text/javascript">
var hn = '<?php echo base_url();?>major_parts/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchMajorParts").fadeIn(1000);        
    });
    $('input#searchMajorParts').keyup( function() {
        var msg = $('#searchMajorParts').val();
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
            var msg = $('#searchMajorParts').val();
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
            <h4>Major Parts Panel</h4>
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
                            Major Parts Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Type Code or Name" name="searchMajorParts" id="searchMajorParts" />
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
                            Major Parts Entry Panel
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-major_parts', 'id' => 'form-major_parts', 'class' => 'form-major_parts');
                            if(isset($majorParts_id))
                            {
                                echo form_open("major_parts/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("major_parts/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Major Parts Code</td>
                                    <td><input type="text" class="form-control" placeholder="Code" name="majorPartsCode" id="majorPartsCode" required readonly value="<?php if(isset($majorParts_id)) echo $majorParts_id; else echo $nextId;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Major Parts Name</td>
                                    <td><input type="text" placeholder="Type Name" name="majorPartsName" id="majorPartsName" value="<?php if(isset($majorParts_name)) echo $majorParts_name;?>" required /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <?php
                                    if(isset($majorParts_id))
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
                            <?php if(isset($majorParts_id)){?>
                                  <a href="<?php echo base_url();?>major_parts">New Entry</a>
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