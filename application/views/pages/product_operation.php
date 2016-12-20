<?php $this->load->view('template/header');?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<style>
    #searchPanel
    {
        margin: 10px;
        padding: 5px; 
        border: 1px solid #269abc; 
        border-radius: 9px;
        height: 300px;
        overflow: auto;
    }
    #searchTable{
        width: 100%;
    }
    
    #searchTable th {
        border: 1px solid #c4c4c4; 
        height: 25px; 
        font-size: 11px;
        font-family: verdana;
        padding: 4px 4px 4px 4px; 
        border-radius: 4px; 
        -moz-border-radius: 4px; 
        -webkit-border-radius: 4px; 
        box-shadow: 0px 0px 8px #d9d9d9; 
        -moz-box-shadow: 0px 0px 8px #d9d9d9; 
        -webkit-box-shadow: 0px 0px 8px #d9d9d9; 
    }
    #searchTable td {
        border: 1px solid #7bc1f7; 
         //height: 10px; 
        font-size: 11px;
        font-family: verdana;
        padding: 0px 5px 0px 5px; 
        border-radius: 4px; 
        -moz-border-radius: 4px; 
        -webkit-border-radius: 4px; 
        box-shadow: 0px 0px 8px #d9d9d9; 
        -moz-box-shadow: 0px 0px 8px #d9d9d9; 
        -webkit-box-shadow: 0px 0px 8px #d9d9d9; 
    }
    #searchTable input[type="text"]
    {
        border: 1px solid #c4c4c4; 
        height: 22px; 
        width: 60px; 
        font-size: 11px;
        font-family: verdana;
        padding: 4px 4px 4px 4px; 
        border-radius: 4px; 
        -moz-border-radius: 4px; 
        -webkit-border-radius: 4px; 
        box-shadow: 0px 0px 8px #d9d9d9; 
        -moz-box-shadow: 0px 0px 8px #d9d9d9; 
        -webkit-box-shadow: 0px 0px 8px #d9d9d9; 
    }
    #searchTable input[type="text"]:focus
    {
        outline: none; 
        border: 1px solid #7bc1f7; 
        box-shadow: 0px 0px 8px #7bc1f7; 
        -moz-box-shadow: 0px 0px 8px #7bc1f7; 
        -webkit-box-shadow: 0px 0px 8px #7bc1f7; 
    }
    
    /*
 * Table styles
 */
table.dataTable {
  width: 100%;
  margin: 0 auto;
  clear: both;
  border-collapse: separate;
  border-spacing: 0;
  /*
   * Header and footer styles
   */
  /*
   * Body styles
   */
}
table.dataTable thead th,
table.dataTable tfoot th {
  font-weight: bold;
}
table.dataTable thead th,
table.dataTable thead td {
  padding: 10px 18px;
  border-bottom: 1px solid #111111;
}
table.dataTable thead th:active,
table.dataTable thead td:active {
  outline: none;
}
table.dataTable tfoot th,
table.dataTable tfoot td {
  padding: 10px 18px 6px 18px;
  border-top: 1px solid #111111;
}
table.dataTable thead .sorting_asc,
table.dataTable thead .sorting_desc,
table.dataTable thead .sorting {
  cursor: pointer;
  *cursor: hand;
}
table.dataTable thead .sorting {
  background: url("../images/sort_both.png") no-repeat center right;
}
table.dataTable thead .sorting_asc {
  background: url("../images/sort_asc.png") no-repeat center right;
}
table.dataTable thead .sorting_desc {
  background: url("../images/sort_desc.png") no-repeat center right;
}
table.dataTable thead .sorting_asc_disabled {
  background: url("../images/sort_asc_disabled.png") no-repeat center right;
}
table.dataTable thead .sorting_desc_disabled {
  background: url("../images/sort_desc_disabled.png") no-repeat center right;
}
table.dataTable tbody tr {
  background-color: white;
}
table.dataTable tbody tr.selected {
  background-color: #b0bed9;
}
table.dataTable tbody th,
table.dataTable tbody td {
  padding: 8px 10px;
}
table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
  border-top: 1px solid #dddddd;
}
table.dataTable.row-border tbody tr:first-child th,
table.dataTable.row-border tbody tr:first-child td, table.dataTable.display tbody tr:first-child th,
table.dataTable.display tbody tr:first-child td {
  border-top: none;
}
table.dataTable.cell-border tbody th, table.dataTable.cell-border tbody td {
  border-top: 1px solid #dddddd;
  border-right: 1px solid #dddddd;
}
table.dataTable.cell-border tbody tr th:first-child,
table.dataTable.cell-border tbody tr td:first-child {
  border-left: 1px solid #dddddd;
}
table.dataTable.cell-border tbody tr:first-child th,
table.dataTable.cell-border tbody tr:first-child td {
  border-top: none;
}
table.dataTable.stripe tbody tr.odd, table.dataTable.display tbody tr.odd {
  background-color: #f9f9f9;
}
table.dataTable.stripe tbody tr.odd.selected, table.dataTable.display tbody tr.odd.selected {
  background-color: #abb9d3;
}
table.dataTable.hover tbody tr:hover,
table.dataTable.hover tbody tr.odd:hover,
table.dataTable.hover tbody tr.even:hover, table.dataTable.display tbody tr:hover,
table.dataTable.display tbody tr.odd:hover,
table.dataTable.display tbody tr.even:hover {
  background-color: whitesmoke;
}
table.dataTable.hover tbody tr:hover.selected,
table.dataTable.hover tbody tr.odd:hover.selected,
table.dataTable.hover tbody tr.even:hover.selected, table.dataTable.display tbody tr:hover.selected,
table.dataTable.display tbody tr.odd:hover.selected,
table.dataTable.display tbody tr.even:hover.selected {
  background-color: #a9b7d1;
}
table.dataTable.order-column tbody tr > .sorting_1,
table.dataTable.order-column tbody tr > .sorting_2,
table.dataTable.order-column tbody tr > .sorting_3, table.dataTable.display tbody tr > .sorting_1,
table.dataTable.display tbody tr > .sorting_2,
table.dataTable.display tbody tr > .sorting_3 {
  background-color: #f9f9f9;
}
table.dataTable.order-column tbody tr.selected > .sorting_1,
table.dataTable.order-column tbody tr.selected > .sorting_2,
table.dataTable.order-column tbody tr.selected > .sorting_3, table.dataTable.display tbody tr.selected > .sorting_1,
table.dataTable.display tbody tr.selected > .sorting_2,
table.dataTable.display tbody tr.selected > .sorting_3 {
  background-color: #acbad4;
}
table.dataTable.display tbody tr.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd > .sorting_1 {
  background-color: #f1f1f1;
}
table.dataTable.display tbody tr.odd > .sorting_2, table.dataTable.order-column.stripe tbody tr.odd > .sorting_2 {
  background-color: #f3f3f3;
}
table.dataTable.display tbody tr.odd > .sorting_3, table.dataTable.order-column.stripe tbody tr.odd > .sorting_3 {
  background-color: whitesmoke;
}
table.dataTable.display tbody tr.odd.selected > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_1 {
  background-color: #a6b3cd;
}
table.dataTable.display tbody tr.odd.selected > .sorting_2, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_2 {
  background-color: #a7b5ce;
}
table.dataTable.display tbody tr.odd.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_3 {
  background-color: #a9b6d0;
}
table.dataTable.display tbody tr.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.even > .sorting_1 {
  background-color: #f9f9f9;
}
table.dataTable.display tbody tr.even > .sorting_2, table.dataTable.order-column.stripe tbody tr.even > .sorting_2 {
  background-color: #fbfbfb;
}
table.dataTable.display tbody tr.even > .sorting_3, table.dataTable.order-column.stripe tbody tr.even > .sorting_3 {
  background-color: #fdfdfd;
}
table.dataTable.display tbody tr.even.selected > .sorting_1, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_1 {
  background-color: #acbad4;
}
table.dataTable.display tbody tr.even.selected > .sorting_2, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_2 {
  background-color: #adbbd6;
}
table.dataTable.display tbody tr.even.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_3 {
  background-color: #afbdd8;
}
table.dataTable.display tbody tr:hover > .sorting_1,
table.dataTable.display tbody tr.odd:hover > .sorting_1,
table.dataTable.display tbody tr.even:hover > .sorting_1, table.dataTable.order-column.hover tbody tr:hover > .sorting_1,
table.dataTable.order-column.hover tbody tr.odd:hover > .sorting_1,
table.dataTable.order-column.hover tbody tr.even:hover > .sorting_1 {
  background-color: #eaeaea;
}
table.dataTable.display tbody tr:hover > .sorting_2,
table.dataTable.display tbody tr.odd:hover > .sorting_2,
table.dataTable.display tbody tr.even:hover > .sorting_2, table.dataTable.order-column.hover tbody tr:hover > .sorting_2,
table.dataTable.order-column.hover tbody tr.odd:hover > .sorting_2,
table.dataTable.order-column.hover tbody tr.even:hover > .sorting_2 {
  background-color: #ebebeb;
}
table.dataTable.display tbody tr:hover > .sorting_3,
table.dataTable.display tbody tr.odd:hover > .sorting_3,
table.dataTable.display tbody tr.even:hover > .sorting_3, table.dataTable.order-column.hover tbody tr:hover > .sorting_3,
table.dataTable.order-column.hover tbody tr.odd:hover > .sorting_3,
table.dataTable.order-column.hover tbody tr.even:hover > .sorting_3 {
  background-color: #eeeeee;
}
table.dataTable.display tbody tr:hover.selected > .sorting_1,
table.dataTable.display tbody tr.odd:hover.selected > .sorting_1,
table.dataTable.display tbody tr.even:hover.selected > .sorting_1, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_1,
table.dataTable.order-column.hover tbody tr.odd:hover.selected > .sorting_1,
table.dataTable.order-column.hover tbody tr.even:hover.selected > .sorting_1 {
  background-color: #a1aec7;
}
table.dataTable.display tbody tr:hover.selected > .sorting_2,
table.dataTable.display tbody tr.odd:hover.selected > .sorting_2,
table.dataTable.display tbody tr.even:hover.selected > .sorting_2, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_2,
table.dataTable.order-column.hover tbody tr.odd:hover.selected > .sorting_2,
table.dataTable.order-column.hover tbody tr.even:hover.selected > .sorting_2 {
  background-color: #a2afc8;
}
table.dataTable.display tbody tr:hover.selected > .sorting_3,
table.dataTable.display tbody tr.odd:hover.selected > .sorting_3,
table.dataTable.display tbody tr.even:hover.selected > .sorting_3, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_3,
table.dataTable.order-column.hover tbody tr.odd:hover.selected > .sorting_3,
table.dataTable.order-column.hover tbody tr.even:hover.selected > .sorting_3 {
  background-color: #a4b2cb;
}
table.dataTable.no-footer {
  border-bottom: 1px solid #111111;
}
table.dataTable.nowrap th, table.dataTable.nowrap td {
  white-space: nowrap;
}
table.dataTable.compact thead th,
table.dataTable.compact thead td {
  padding: 5px 9px;
}
table.dataTable.compact tfoot th,
table.dataTable.compact tfoot td {
  padding: 5px 9px 3px 9px;
}
table.dataTable.compact tbody th,
table.dataTable.compact tbody td {
  padding: 4px 5px;
}
table.dataTable th.dt-left,
table.dataTable td.dt-left {
  text-align: left;
}
table.dataTable th.dt-center,
table.dataTable td.dt-center,
table.dataTable td.dataTables_empty {
  text-align: center;
}
table.dataTable th.dt-right,
table.dataTable td.dt-right {
  text-align: right;
}
table.dataTable th.dt-justify,
table.dataTable td.dt-justify {
  text-align: justify;
}
table.dataTable th.dt-nowrap,
table.dataTable td.dt-nowrap {
  white-space: nowrap;
}
table.dataTable thead th.dt-head-left,
table.dataTable thead td.dt-head-left,
table.dataTable tfoot th.dt-head-left,
table.dataTable tfoot td.dt-head-left {
  text-align: left;
}
table.dataTable thead th.dt-head-center,
table.dataTable thead td.dt-head-center,
table.dataTable tfoot th.dt-head-center,
table.dataTable tfoot td.dt-head-center {
  text-align: center;
}
table.dataTable thead th.dt-head-right,
table.dataTable thead td.dt-head-right,
table.dataTable tfoot th.dt-head-right,
table.dataTable tfoot td.dt-head-right {
  text-align: right;
}
table.dataTable thead th.dt-head-justify,
table.dataTable thead td.dt-head-justify,
table.dataTable tfoot th.dt-head-justify,
table.dataTable tfoot td.dt-head-justify {
  text-align: justify;
}
table.dataTable thead th.dt-head-nowrap,
table.dataTable thead td.dt-head-nowrap,
table.dataTable tfoot th.dt-head-nowrap,
table.dataTable tfoot td.dt-head-nowrap {
  white-space: nowrap;
}
table.dataTable tbody th.dt-body-left,
table.dataTable tbody td.dt-body-left {
  text-align: left;
}
table.dataTable tbody th.dt-body-center,
table.dataTable tbody td.dt-body-center {
  text-align: center;
}
table.dataTable tbody th.dt-body-right,
table.dataTable tbody td.dt-body-right {
  text-align: right;
}
table.dataTable tbody th.dt-body-justify,
table.dataTable tbody td.dt-body-justify {
  text-align: justify;
}
table.dataTable tbody th.dt-body-nowrap,
table.dataTable tbody td.dt-body-nowrap {
  white-space: nowrap;
}

table.dataTable,
table.dataTable th,
table.dataTable td {
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
}

/*
 * Control feature layout
 */
.dataTables_wrapper {
  position: relative;
  clear: both;
  *zoom: 1;
  zoom: 1;
}
.dataTables_wrapper .dataTables_length {
  float: right;
}
.dataTables_wrapper .dataTables_filter {
  float: left;
  text-align: right;
}
.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5em;
    width: 450px;
    border: 1px solid #c4c4c4; 
    height: 25px; 
    font-size: 11px;
    font-family: verdana;
    padding: 4px 4px 4px 4px; 
    border-radius: 4px; 
    -moz-border-radius: 4px; 
    -webkit-border-radius: 4px; 
    box-shadow: 0px 0px 8px #d9d9d9; 
    -moz-box-shadow: 0px 0px 8px #d9d9d9; 
    -webkit-box-shadow: 0px 0px 8px #d9d9d9; 
  
}
.dataTables_wrapper .dataTables_info {
  clear: both;
  float: left;
  padding-top: 0.755em;
}
.dataTables_wrapper .dataTables_paginate {
  float: right;
  text-align: right;
  padding-top: 0.25em;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  box-sizing: border-box;
  display: inline-block;
  min-width: 1.5em;
  padding: 0.5em 1em;
  margin-left: 2px;
  text-align: center;
  text-decoration: none !important;
  cursor: pointer;
  *cursor: hand;
  color: #333333 !important;
  border: 1px solid transparent;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
  color: #333333 !important;
  border: 1px solid #cacaca;
  background-color: white;
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, gainsboro));
  /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top, white 0%, gainsboro 100%);
  /* Chrome10+,Safari5.1+ */
  background: -moz-linear-gradient(top, white 0%, gainsboro 100%);
  /* FF3.6+ */
  background: -ms-linear-gradient(top, white 0%, gainsboro 100%);
  /* IE10+ */
  background: -o-linear-gradient(top, white 0%, gainsboro 100%);
  /* Opera 11.10+ */
  background: linear-gradient(to bottom, white 0%, gainsboro 100%);
  /* W3C */
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
  cursor: default;
  color: #666 !important;
  border: 1px solid transparent;
  background: transparent;
  box-shadow: none;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  color: white !important;
  border: 1px solid #111111;
  background-color: #585858;
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #585858), color-stop(100%, #111111));
  /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top, #585858 0%, #111111 100%);
  /* Chrome10+,Safari5.1+ */
  background: -moz-linear-gradient(top, #585858 0%, #111111 100%);
  /* FF3.6+ */
  background: -ms-linear-gradient(top, #585858 0%, #111111 100%);
  /* IE10+ */
  background: -o-linear-gradient(top, #585858 0%, #111111 100%);
  /* Opera 11.10+ */
  background: linear-gradient(to bottom, #585858 0%, #111111 100%);
  /* W3C */
}
.dataTables_wrapper .dataTables_paginate .paginate_button:active {
  outline: none;
  background-color: #2b2b2b;
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2b2b2b), color-stop(100%, #0c0c0c));
  /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
  /* Chrome10+,Safari5.1+ */
  background: -moz-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
  /* FF3.6+ */
  background: -ms-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
  /* IE10+ */
  background: -o-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
  /* Opera 11.10+ */
  background: linear-gradient(to bottom, #2b2b2b 0%, #0c0c0c 100%);
  /* W3C */
  box-shadow: inset 0 0 3px #111;
}
.dataTables_wrapper .dataTables_processing {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 100%;
  height: 40px;
  margin-left: -50%;
  margin-top: -25px;
  padding-top: 20px;
  text-align: center;
  font-size: 1.2em;
  background-color: white;
  background: -webkit-gradient(linear, left top, right top, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, 0.9)), color-stop(75%, rgba(255, 255, 255, 0.9)), color-stop(100%, rgba(255, 255, 255, 0)));
  /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
  /* Chrome10+,Safari5.1+ */
  background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
  /* FF3.6+ */
  background: -ms-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
  /* IE10+ */
  background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
  /* Opera 11.10+ */
  background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
  /* W3C */
}
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_processing,
.dataTables_wrapper .dataTables_paginate {
  color: #333333;
}
.dataTables_wrapper .dataTables_scroll {
  clear: both;
}
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
  *margin-top: -1px;
  -webkit-overflow-scrolling: touch;
}
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody th > div.dataTables_sizing,
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody td > div.dataTables_sizing {
  height: 0;
  overflow: hidden;
  margin: 0 !important;
  padding: 0 !important;
}
.dataTables_wrapper.no-footer .dataTables_scrollBody {
  border-bottom: 1px solid #111111;
}
.dataTables_wrapper.no-footer div.dataTables_scrollHead table,
.dataTables_wrapper.no-footer div.dataTables_scrollBody table {
  border-bottom: none;
}
.dataTables_wrapper:after {
  visibility: hidden;
  display: block;
  content: "";
  clear: both;
  height: 0;
}

@media screen and (max-width: 767px) {
  .dataTables_wrapper .dataTables_info,
  .dataTables_wrapper .dataTables_paginate {
    float: none;
    text-align: center;
  }
  .dataTables_wrapper .dataTables_paginate {
    margin-top: 0.5em;
  }
}
@media screen and (max-width: 640px) {
  .dataTables_wrapper .dataTables_length,
  .dataTables_wrapper .dataTables_filter {
    float: none;
    text-align: center;
  }
  .dataTables_wrapper .dataTables_filter {
    margin-top: 0.5em;
  }
}
    
</style>
<script type="text/javascript">
$(document).ready(function() {
    $('#searchTable').dataTable( {
        "pagingType": "full_numbers"
    } );
} );
</script>
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
                            Operation Entry Panel
                        </div>
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-operation', 'id' => 'form-operation', 'class' => 'form-operation');
                            if(isset($operation_id))
                            {
                                echo form_open("product_operation/edit", $attributes);
                            }
                            else
                            {
                                echo form_open("product_operation/submitData", $attributes);
                            }
                        ?>
                        <div class="panel-body">
                            <table id="entry-panel">
                                <tr>
                                    <td>Operation Id</td>
                                    <td><input class="form-control" type="text" id="operationId" name="operationId" value="<?php if(isset($nextId)) echo $nextId; if(isset($operation_id)) echo $operation_id;?>" readonly style="width: 70px" /></td>
                                    <td>Product Section</td>
                                    <td>
                                        <select  name="section" id="section" required>
                                            <option disabled selected>Select Section</option>
                                            <?php 
                                                if(isset($section))
                                                {
                                                    if($section_id != 0)
                                                    {
                                            ?>            
                                                        <option value="<?php echo $section_id;?>" selected><?php echo $section_name;?></option>
                                            <?php        
                                                    }
                                                    foreach ($section as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['product_section_id'];?>"><?php echo $row['product_section_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Section Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                               
                                    <td>Buyer</td>
                                    <td>
                                         <select  name="buyer" id="buyer" required>
                                            <option disabled selected>Select Buyer</option>
                                            <?php 
                                                if(isset($buyer))
                                                {
                                                    if($buyer_id != 0)
                                                    {
                                            ?>            
                                                        <option value="<?php echo $buyer_id;?>" selected><?php echo $buyer_name;?></option>
                                            <?php        
                                                    }
                                                    foreach ($buyer as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['buyer_id'];?>"><?php echo $row['buyer_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Buyer Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                                    <td>Season</td>
                                    <td>
                                        <select  name="season" id="season" required>
                                            <option disabled selected>Select Season</option>
                                            <?php 
                                                if(isset($season))
                                                {
                                                    if($season_id != 0)
                                                    {
                                            ?>            
                                                        <option value="<?php echo $season_id;?>" selected><?php echo $season_name;?></option>
                                            <?php        
                                                    }
                                                    foreach ($season as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['season_id'];?>"><?php echo $row['season_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>season Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Style</td>
                                    <td>
                                        <select  name="style" id="style" required>
                                            <option disabled selected>Select Style</option>
                                            <?php 
                                                if(isset($style))
                                                {
                                                    if($style_id != 0)
                                                    {
                                            ?>            
                                                        <option value="<?php echo $style_id;?>" selected><?php echo $style_name;?></option>
                                            <?php        
                                                    }
                                                    foreach ($style as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['style_id'];?>"><?php echo $row['style_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Style Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                                    <td>Gauge</td>
                                    <td>
                                        <select  name="gauge" id="gauge" required>
                                            <option disabled selected>Select Gauge</option>
                                            <?php 
                                                if(isset($gauge))
                                                {
                                                    if($gauge_id != 0)
                                                    {
                                            ?>            
                                                        <option value="<?php echo $gauge_id;?>" selected><?php echo $guage_size;?></option>
                                            <?php        
                                                    }
                                                    foreach ($gauge as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['guage_id'];?>"><?php echo $row['guage_size'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Gauge Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                                
                                    <td>Size</td>
                                    <td>
                                        <select  name="size" id="size" required>
                                            <option disabled selected>Select Style</option>
                                            <?php 
                                                if(isset($size))
                                                {
                                                    if($size_id != 0)
                                                    {
                                            ?>            
                                                        <option value="<?php echo $size_id;?>" selected><?php echo $size_name;?></option>
                                            <?php        
                                                    }
                                                    foreach ($size as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['size_id'];?>"><?php echo $row['size_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Style Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                                    <td>Unit of Measure</td>
                                    <td>
                                        <select  name="unitmeasure" id="unitmeasure" required>
                                            <option disabled selected>Select Unit Measure</option>
                                            <?php 
                                                if(isset($unitmeasure))
                                                {
                                                    if($unitmeasur_id != 0)
                                                    {
                                            ?>            
                                                        <option value="<?php echo $unitmeasur_id;?>" selected><?php echo $measurement_name;?></option>
                                            <?php        
                                                    }
                                                    foreach ($unitmeasure as $key => $row):
                                            ?>
                                                    <option value="<?php echo $row['measurement_id'];?>"><?php echo $row['measurement_name'];?></option>
                                            <?php
                                                    endforeach;
                                                }
                                                else
                                                {
                                            ?>        
                                                    <option value='0'>Gauge Not Found</option>
                                            <?php } ?>        
                                        </select>
                                    </td>
                                    
                                </tr>
                                <tr>    
                                    <td>Rate</td>
                                    <td><input type="text" id="rate" name="rate" value="<?php if(isset($rate)) echo $rate;?>" required /></td>
                                    
                                
                                    <td>Major Parts</td>
                                    
                                    <td colspan="7">
                                        
                                            <?php 
                                                $i = 0;
                                                foreach ($majorParts as $key => $row):
                                            ?>
                                            
                                        <input type="checkbox" name="parts_<?php echo $row['majorParts_id'];?>" id="parts_<?php echo $row['majorParts_id'];?>" value="<?php echo $row['majorParts_name'];?>" <?php if(isset($major_parts_array)){if($major_parts_array[$i] == $row['majorParts_name']){ echo 'checked';$i++;}}?> /> <?php echo $row['majorParts_name'];?> 
                                                
                                            <?php
                                                endforeach;
                                            ?>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                    <?php
                                    if(isset($operation_id))
                                    {
                                        $submitButton = array(
                                            'name' => 'submit',
                                            'id' => 'submit',
                                            'value' => 'Update',
                                            'type' => 'submit',
                                            'class' => 'btn btn-success'
                                        );

                                        echo form_submit($submitButton);
                                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Or";
                                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='".base_url()."product_operation'> Back To New Entry</a>";
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
                        <div id="searchPanel">
                            <table id="searchTable">
                                <thead>
                                    <tr>
                                        <th width="60" style="text-align: left">Id</th>
                                        <th width="120" style="text-align: left">Section</th>
                                        <th width="120" style="text-align: left">Season</th>
                                        <th width="400" style="text-align: left">Description</th>
                                        <th width="110" style="text-align: left">Measurement</th>
                                        <th width="70" style="text-align: left">Rates</th>
                                        <th width="120" style="text-align: left">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                        <?php if(isset($productionOperation)){foreach ($productionOperation as $key => $row):?>
                                        <tr>
                                            <td><?php echo $row['operation_id'];?></td>
                                            <td><?php echo $row['product_section_name'];?></td>
                                            <td><?php echo $row['season_name'];?></td>
                                            <td><?php echo $row['buyer_name']." ".$row['style_name']." ".$row['guage_size']." ".$row['product_section_name']." ".$row['size_name']." ".$row['major_parts'];?></td>
                                            <td><?php echo $row['measurement_name'];?></td>
                                            <td><?php echo $row['rate'];?></td>
                                            <td>
                                                <table style="width: 100%; border: none;">
                                                    <tr>
                                                        <td style="text-align: left;"><a href="<?php echo base_url();?>product_operation/viewEdit/<?= $row['operation_id']; ?>" title="Edit"><img alt="edit" src="<?php echo base_url();?>images/edit.png" /></a></td>
                                                        <td style="text-align: right;"><a href="<?php echo base_url();?>product_operation/delete/<?= $row['operation_id']; ?>" title="Delete"><img alt="edit" src="<?php echo base_url();?>images/delete.png" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php endforeach;}?>
                                 </tbody>    
                            </table>
                        </div>
                        <div class="panel-footer" style="text-align: right;">
                            <?php if(isset($operation_id)){?>
                                  <a href="<?php echo base_url();?>product_operation">New Entry</a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                           Search Panel
                        </div>
                        <div class="panel-body">
                            <div class="input-group">
                                <span class="input-group-addon">Search</span>
                                <input type="text" class="form-control" placeholder="Type Id/Section/Season/Description/Measure/Rates" name="searchOperation" id="searchOperation" />
                            </div>
                            <br />
                            <div id="content_barang"></div>
                        </div>
                        <div class="panel-footer">
                            <div id="pp"></div>
                        </div>
                    </div>
                </div>
            </div>-->
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
<?php $this->load->view('template/footer');?>