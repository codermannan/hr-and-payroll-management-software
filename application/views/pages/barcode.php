<?php $this->load->view('template/header');?>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php $this->load->view('template/menu');?>
        <!---------------->
        
        <div id="page-wrapper">
            <h4>Product Operation Panel</h4>
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
                            
                        </div>
                        
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                            <?php //foreach ($employeeData as $values):?>
                                    <td>
                                        <img src="<?php echo base_url();?>barcode/generateBarcode/2896/200/70/gif" />
                                    </td>
                            <?php //endforeach;?>
                                 </tr>   
                            </table>
                        </div>
                        <div class="panel-footer" style="text-align: right;">
                           
                        </div>
                    </div>
                </div>
            </div>
        <!-- /#page-wrapper -->

    </div>
<?php $this->load->view('template/footer');?>