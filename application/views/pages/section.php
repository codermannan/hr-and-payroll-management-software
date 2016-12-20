<?php $this->load->view('template/header');?>
<script type="text/javascript">
var hn = '<?php echo base_url();?>section/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchSection").fadeIn(1000);        
    });
    $('input#searchSection').keyup( function() {
        var msg = $('#searchSection').val();
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
            var msg = $('#searchSection').val();
            $.post(hn+'/ #content_barang', {descp_msg: msg,pageNumber:pageNumber}, function(data) {
                $("#content_barang").html(data);
            });
            $('#pp').pagination({loading:false});
        }
    });
    
    
});
function setFloorCode()
    {
        $('#floor').empty()
        var unitId = $('#unit').val();
        $('#floor').append('<option disable selected>Select Floor</option>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>section/loadFloor/",
            data: { 'unitId': unitId  },
            success: function(data){
                // Parse the returned json data
                
                   var opts = $.parseJSON(data);
                   $.each(JSON.parse(opts), function(idx, obj) {

                       $('#floor').append('<option value="' + obj.value + '">' + obj.label + '</option>');
                   });
               
            }
        });
    }
</script>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Section Panel</h4>
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
                            Section Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Type Code or Name" name="searchSection" id="searchSection" />
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
                            Section Entry Panel
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-section', 'id' => 'form-section', 'class' => 'form-section');
                            
                            if(isset($section_id))
                            {
                                echo form_open("section/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("section/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Section Code</td>
                                    <td><input type="text" class="form-control" placeholder="Code" name="sectionCode" id="sectionCode" required readonly value="<?php if(isset($section_id)) echo $section_id; else echo $nextId;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Unit</td>
                                    <td>
                                        <select  name="unit" id="unit" onchange="setFloorCode()">
                                            <option disabled selected>Select Unit</option>
                                            <?php 
                                                if(isset($unit))
                                                {
                                                    if(isset($unit_id))
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
                                        <select  name="floor" id="floor" required>
                                            <?php if(isset($floor_edit)){?>
                                            <option value="<?php if(isset($floor_edit)) echo $floor_edit;?>" selected><?php echo $floor_name;?></option>
                                            <?php }else{?>
                                            <option value="0" disabled selected>Select Floor</option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Section Name</td>
                                    <td><input type="text" placeholder="Type  Name" name="sectionName" id="sectionName" value="<?php if(isset($section_name)) echo $section_name;?>" required /></td>
                                </tr>
                                <tr>
                                    <td>Section Short Code</td>
                                    <td><input type="text" placeholder="Type  Name" name="sectionShortCode" id="sectionShortCode" value="<?php if(isset($section_short_code)) echo $section_short_code;?>" required /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <?php
                                    if(isset($section_id))
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
                            <?php if(isset($section_id)){?>
                                  <a href="<?php echo base_url();?>section">New Entry</a>
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