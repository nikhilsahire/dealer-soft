<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Purchase Transactions</span></div>
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
			echo form_open('payment/purchase_statement/',$attributes);
				
			
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
		<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="FlagsExport">
          <thead>
            <tr>              
              <!-- <th scope="col"> Date </th>
			  <th scope="col" > Supplier Name </th>
			  <th scope="col" > Invoice #</th>
			  <th scope="col" > GSTin Id</th>
              <th scope="col" > SGST / IGST % </th> 
			  <th scope="col" > CGST % </th>
			  <th scope="col" > Sub-total </th>
			  <th scope="col" > SGST / IGST Amt </th>
			  <th scope="col" > CGST Amt </th> -->
			  <th scope="col" > Date </th>
			  <th scope="col" > Supplier Name </th>
			  <th scope="col" > Invoice #</th>
			  <th scope="col" > Product Name </th> 				<!-- Client Name -->
			  <th scope="col" > HSN Code</th> 					<!-- Newly added -->
			  <th scope="col" > GSTIN ID</th> 
			  <th scope="col" > SGST % </th> 
			  <th scope="col" > SGST Amt </th>  				<!-- Newly added -->
			  <th scope="col" > CGST % </th>
			  <th scope="col" > CGST Amt </th>  				<!-- Newly added -->
			  <th scope="col" > IGST % </th>
			  <th scope="col" > IGST Amt </th>  				<!-- Newly added -->
			  <th scope="col" > Sale Amt </th>
			  <th scope="col" > Line Total </th>
			  <th scope="col" > Invoice Total </th>
			  
            </tr>
          </thead>
          <tbody>
            <?php 
			
				// echo "<pre>";
				// print_r($transactions);
				// die;
				$count_transactions = count($transactions);
				if($count_transactions > 0)
				{ 
				  foreach($transactions as $transaction )
				  {
				   // $taxAmt = ($transaction['tax_per']*)
				?>
                    <tr class="odd gradeX" >
                    	<td><?php echo date('d M Y',strtotime($transaction['on_date'])); ?></td>
						<td><?php echo $transaction['supl_comp']; ?></td>
                    	<td><?php echo $transaction['invoice_no']; ?></td>
                    	<td><?php echo $transaction['prod_ref_name'];  ?></td>
                    	<td><?php echo $transaction['hsn_code'];  ?></td>
                    	<td><?php echo $transaction['gstin_num'];  ?></td>
                    	<td><?php echo $transaction['sgst_per'];  ?></td>
                    	<td><?php echo 'SGST AMT';  ?></td>
                    	<td><?php echo $transaction['cgst_per'];  ?></td>
                    	<td><?php echo 'CGST AMT';  ?></td>
                    	<td><?php echo $transaction['igst_per'];  ?></td>
                    	<td><?php echo 'IGST AMT';  ?></td>
                    	<td><?php echo 'Sales Amt';  ?></td>
                    	<td><?php echo 'Line Total';  ?></td>
                    	<td><?php echo 'Invoice Total';  ?></td>
						<!-- <td><?php echo date('d M Y',strtotime($transaction['on_date'])); ?></td>			   
						<td><?php echo $transaction['supl_comp']; ?></td>
						<td><?php echo $transaction['invoice_no']; ?></td>
						<td><?php echo $transaction['gstin_num']; ?></td>
						<td><?php if($transaction['tax_per'] > 0){ echo $transaction['tax_per'].'% '.$transaction['tax_type']; }else { echo '-' ;} ?></td>
						<td><?php if($transaction['excise'] > 0){ echo $transaction['excise'].'% CGST'; }else { echo '-' ;} ?></td>
						<td><?php echo number_format($transaction['amount'],2); ?></td>	 
						<td><?php echo number_format((($transaction['tax_per']*$transaction['amount'])/100),2); ?></td>
						<td><?php echo number_format((($transaction['excise']*$transaction['amount'])/100),2); ?></td>	 -->					
						 
                    </tr>
            <?php
				 }
			}?>
          </tbody>
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
            "pageLength": 50,
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','print']
        });
    });
</script>
