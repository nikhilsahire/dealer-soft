<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Sales Transactions</span></div>
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
			echo form_open('payment/sales_statement/',$attributes);
				
			
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
              <?php /* START Changes made by Nikhil 22-06-2017 10.58 am. */ ?>
			  <th scope="col"> Date </th>
			  <th scope="col" > Invoice #</th>
			  <th scope="col" > Product Name </th> 				<!-- Client Name -->
			  <th scope="col" > HSN Code</th> 					<!-- Newly added -->
			  <th scope="col" > GSTIN ID</th> 
			  <th scope="col" > State Code </th> 				<!-- Newly added -->
			  <th scope="col" > SGST % </th> 
			  <th scope="col" > SGST Amt </th>  				<!-- Newly added -->
			  <th scope="col" > CGST % </th>
			  <th scope="col" > CGST Amt </th>  				<!-- Newly added -->
			  <th scope="col" > IGST % </th>
			  <th scope="col" > IGST Amt </th>  				<!-- Newly added -->
			  <th scope="col" > Sale Amt </th>
			  <th scope="col" > Line Total </th>
			  <th scope="col" > Invoice Total </th>
			  
			  
			  <?php /* END Changes made by Nikhil 22-06-2017 10.58 am. */ ?>

            </tr>
          </thead>
          <tbody>
            <?php 
				$count_transactions = count($transactions);
				if($count_transactions > 0)
				{ 
					// echo "<pre>";
					// print_r($transactions);
					// echo $transactions[2]['invoice_number'];
					// die;
					// $z = 0;
					$tot_sgst = 0;
					$tot_cgst = 0;
					$tot_igst = 0;
					$tot_sub = 0;
					$tot_tot = 0;
					$inv_tot = 0;
				  foreach($transactions as $transaction )
				  {
				   // $taxAmt = ($transaction['tax_per']*)
				?>
                    <tr class="odd gradeX" >
						<?php /* START Changes made by Nikhil 22-06-2017 10.58 am. */ ?>
						
						
						<td><?php echo date('d M Y',strtotime($transaction['order_date'])); ?></td>			   
						<td><a href="<?php echo base_url()?>orders/view_invoice/<?php echo strtolower($transaction['order_type']).'/'.$transaction['order_id'] ?>"><?php echo $transaction['invoice_number']; ?></a></td>
						<td><?php echo $transaction['prod_ref_name']; ?></td>
						<td><?php echo $transaction['hsn_code']; ?></td>
						<td><?php echo $transaction['gstin_num']; ?></td>
						<td><?php echo $transaction['state_code']; ?></td>
						<td><?php echo $transaction['sgst_per']; ?></td>
						<td><?php $total_amt = ($transaction['order_rate'] * $transaction['order_qty']);
						$sgst_amt = number_format((($transaction['sgst_per']*$total_amt)/100),2); echo $sgst_amt; $tot_sgst = $tot_sgst + $sgst_amt;?></td>
						<td><?php echo $transaction['cgst_per']; ?></td>
						<td><?php $cgst_amt = number_format((($transaction['cgst_per']*$total_amt)/100),2); echo $cgst_amt; $tot_cgst = $tot_cgst + $cgst_amt;?></td>
						<td><?php echo $transaction['igst_per']; ?></td>
						<td><?php $igst_amt = number_format((($transaction['igst_per']*$total_amt)/100),2); echo $igst_amt; $tot_igst = $tot_igst + $igst_amt;?></td>
						<td><?php $gst_amt = ($sgst_amt + $cgst_amt + $igst_amt); 
						$subtotal = number_format(($total_amt - $gst_amt),2); 
						echo $subtotal; 
						$tot_sub = $tot_sub + ($total_amt - $gst_amt); ?></td>
						<td><?php echo number_format($total_amt,2); $tot_tot = $tot_tot + $total_amt;?></td>
						<td><?php echo number_format($transaction['sub_total'],2); $inv_tot = $inv_tot + $transaction['sub_total']?></td>
                   </tr>
            <?php
				 } ?>
					
			<?php
			}?>
          </tbody>
          <tfoot>
					<tr style="font-weight:bold">
						<td></td>			   
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo "Total: ";  ?></td>
						<td></td>
						<td><?php echo number_format($tot_sgst,2);?></td>
						<td></td>
						<td><?php echo number_format($tot_cgst,2);?></td>
						<td></td>
						<td><?php echo number_format($tot_igst,2);?></td>
						<td><?php echo number_format($tot_sub,2); ?></td>
						<td><?php echo number_format($tot_tot,2); ?></td>
						<td><?php echo number_format($inv_tot,2); ?></td>
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
