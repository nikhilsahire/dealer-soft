<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>HSN Transactions</span></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
	  <?php if(validation_errors()){?>
          <div class="alert alert-danger display-hide" style="display: block;">
            <button class="close" data-close="alert"></button>
            You have some form errors. Please check below. </div>
	<?php } ?>
	<?php if(isset($_SESSION['suc_msg'])){ ?> 
	 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
	  <?php echo $_SESSION['suc_msg'];
			 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
	  ?>
	</div>
	<?php } ?>
        <div class="table-toolbar">
          
		  <div class="filter-form hidden-xs" style="margin-bottom: 10px;">
 <style>
 .form-inline .input-parent {
  display: inline-block;
}
.filter-form .form-control {
  background-color: #fff;
  border:1px solid #979797 !important;
  background-image: none !important;
  
}
.beatpicker-clear beatpicker-clearButton button{ display:none !important;
	}
 </style>
<!--<form class="form-inline">-->
<div class="row">
<div class="col-md-12">
<?php  
       
	    	$attributes = array('class' => 'form-inline', 'id' => 'myform');
			echo form_open('payment/hsn_statement/',$attributes);
				
			
			 ?>

  <div class="form-group"  style="margin-top:2px;">
       <label class="control-label">From</label>
                  <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
				  <input type="text" class="form-control" id="fromdate" name="fromdate" required="required" value="<?php echo $sdate; ?>" readonly >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
				</div>
  </div>
  
  <div class="form-group"  style="margin-top:2px;">
  <label class="control-label">To</label>
                  <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" >
				  <input type="text" class="form-control" id="todate" name="todate" required="required" value="<?php echo $todate; ?>" readonly >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
				</div>
	 </div>
  
  
   
  <div class="form-group"  style="margin-top:2px;">
   <input  type="submit" name="submit" value="Filter"   class="btn green"/>
  <input  type="submit" name="reset" value="Reset"   class="btn btn-wht"/>
  </div>
 
  
       <?php	
			
			echo form_close();
		  ?>
  </div>
 </div>
 
		
        </div>
		<div class="table-scrollable">
        <table class="table table-striped table-bordered table-hover" id="FlagsExport">
          <thead>
          	<tr>
          		<th scope="col" ></th>
          		<th scope="col" colspan="3" align="center">Inward</th>
          		<th scope="col" colspan="3" align="center">Outward</th>
          	</tr>
            <tr>              
              <?php /* START Changes made by Nikhil 22-06-2017 10.58 am. */ ?>
			  <th scope="col"> HSN Code </th>
			  <th scope="col" > SGST </th>
			  <th scope="col" > CGST </th> 				<!-- Client Name -->
			  <th scope="col" > IGST </th> 					<!-- Newly added -->
			  <th scope="col" > SGST </th> 
			  <th scope="col" > CGST </th> 				<!-- Newly added -->
			  <th scope="col" > IGST </th> 
			  
			  
			  
			  <?php /* END Changes made by Nikhil 22-06-2017 10.58 am. */ ?>

            </tr>
          </thead>
         <tbody>
            <?php 
				$count_transactions = count($transactions);
				if($count_transactions > 0)
				{ 
					$insgst = 0;
					$incgst = 0;
					$inigst = 0;
					$outsgst = 0;
					$outcgst = 0;
					$outigst = 0;
				  foreach($transactions as $key=>$val )
				  {
				   // $taxAmt = ($transaction['tax_per']*)
				  	// echo "<pre>";
				  	// print_r($key);
				  	// die;
				?>
                    <tr class="odd gradeX" >
						<?php  /* START Changes made by Nikhil 22-06-2017 10.58 am. */ ?>
						<td><?php echo $key; ?></td>
						<?php if(isset($val['in'])){ ?>
							<td><?php echo $val['in']['sgst']; $insgst = $insgst + $val['in']['sgst']; ?></td>
							<td><?php echo $val['in']['cgst']; $incgst = $incgst + $val['in']['cgst']; ?></td>
							<td><?php echo $val['in']['igst']; $inigst = $inigst + $val['in']['igst']; ?></td>
						<?php }else{ ?>
							<td><?php echo 0; ?></td>
							<td><?php echo 0; ?></td>
							<td><?php echo 0; ?></td>
						<?php } ?>
						<?php if(isset($val['out'])){ ?>
							<td><?php echo $val['out']['sgst']; $outsgst = $outsgst + $val['out']['sgst'];?></td>
							<td><?php echo $val['out']['cgst']; $outcgst = $outcgst + $val['out']['cgst'];?></td>
							<td><?php echo $val['out']['igst']; $outigst = $outigst + $val['out']['igst'];?></td>
						<?php }else{ ?>
							<td><?php echo 0; ?></td>
							<td><?php echo 0; ?></td>
							<td><?php echo 0; ?></td>
						<?php } ?>
                   </tr>
            <?php
				 } ?>
					
			<?php
			}?>
          </tbody>
			 <tfoot>
          	<tr style="font-weight:bold">
				<td><?php echo "Total : ";  ?></td>			   
				<td><?php echo $insgst;  ?></td>
				<td><?php echo $incgst;  ?></td>
				<td><?php echo $inigst;  ?></td>
				<td><?php echo $outsgst;  ?></td>
				<td><?php echo $outcgst;  ?></td>
				<td><?php echo $outigst;  ?></td>
				
			</tr>
          </tfoot>		
        </table>
		</div>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
	
  </div>
</div>

<script src="<?php echo $this->config->item("global_url")?>plugins/export" type="text/javascript"></script>
 <link type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/export/jquery.dataTables.min.css" rel="stylesheet">
<link type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/export/buttons.dataTables.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/export/dataTables.tableTools.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/export/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/export/dataTables.buttons.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/export/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("global_url")?>plugins/export/buttons.print.min.js"></script>
 
<script type="text/javascript">
    $(document).ready(function() {
        $('#FlagsExport').DataTable({
            "pageLength": 100000,
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','print']
        });
    });
</script>
