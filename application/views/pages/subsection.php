<?php $this->load->view('template/header');?>
<script type="text/javascript">
var hn = '<?php echo base_url();?>subsection/searchData';
$('document').ready(function(){

	$(".preload").fadeOut(6000, function() {
        $(".searchSubSection").fadeIn(1000);        
    });
    $('input#searchSubSection').keyup( function() {
        var msg = $('#searchSubSection').val();
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
            var msg = $('#searchSubSection').val();
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
        url: "<?php echo base_url();?>subsection/loadFloor/",
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
    $('#section').append('<option disable selected>Select Section</option>');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>subsection/loadSection/",
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
</script>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Subsection Panel</h4>
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
                            Sub Section Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Type Code or Name" name="searchSubSection" id="searchSubSection" />
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
                            Sub Section Entry Panel
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-subSection', 'id' => 'form-subSection', 'class' => 'form-subSection');
                            if(isset($subsection_id))
                            {
                                echo form_open("subsection/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("subsection/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Sub Section Code</td>
                                    <td><input type="text" class="form-control" placeholder="Code" name="subSectionCode" id="subSectionCode" required readonly value="<?php if(isset($subsection_id)) echo $subsection_id; else echo $nextId;?>" /></td>
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
                                        <select  name="floor" id="floor" onchange="setSectionCode();">
                                            <option>Select Floor</option>
                                            <?php if(isset($floor_id)){?>
                                            <option value="<?php echo $floor_id;?>" selected><?php echo $floor_name;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Section</td>
                                    <td>
                                        <select  name="section" id="section" required>
                                            <option>Select Section</option>
                                            <?php if(isset($section_edit)){?>
                                            <option value="<?php if(isset($section_edit)) echo $section_edit;?>" selected><?php echo $section_name;?></option>
                                            <?php }?>
                                            
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sub Section Name</td>
                                    <td><input type="text" placeholder="Type Name" name="subSectionName" id="sectionName" value="<?php if(isset($subsection_name)) echo $subsection_name;?>" required /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <?php
                                    if(isset($subsection_id))
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
                            <?php if(isset($subsection_id)){?>
                                  <a href="<?php echo base_url();?>subsection">New Entry</a>
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