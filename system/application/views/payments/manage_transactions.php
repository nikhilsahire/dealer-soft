<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Transactions: <?php echo $client_name;?></span></div>
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
          
		  <div class="filter-form hidden-xs">
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
			echo form_open('payment/transactions/'.$client_id,$attributes);
				
			
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
  
  
   <div class="form-group" style="margin-top:2px;" >
       <label class="control-label">Firm</label>
                 <?php echo form_dropdown('firm_id[]',$firmList,$firm_id,'class="form-control select2me" tabindex="0" placeholder= "Select Firmd" required="required" id="prod_1"');?> 
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
 <div class="row" style="margin-top: 15px;">
  <!--</form>-->
   <div class="col-md-9">
	  <div class="form-group">
	  
	  			 <div class="col-md-4">
			  <strong>Total Credit:</strong><br/><?php echo number_format($finalAmount[0]['paid_amount'],2); ?> 
			  </div>
			  <div class="col-md-4">
			  <strong>Total Debit Amount:</strong><br/><?php echo number_format($finalAmount[0]['invoice_amount'],2); ?>
			</div>
			<div class="col-md-4">
			  <strong>Total Balance:</strong><br/><?php echo number_format(($finalAmount[0]['invoice_amount']-$finalAmount[0]['paid_amount']),2); ?>
			</div>
	 
			  
			
	  </div>
  </div>  
  <div class="col-md-3">
  <div class="form-group">
      
              <div class="btn-group" style="float:right;">
                <a href="<?php echo base_url();?>payment/add/<?php echo $client_id ?>"><button id="sample_editable_1_new" class="btn green"> New Transaction <i class="fa fa-plus"></i> </button></a>
				
			  </div>
			
       
	</div>
  </div>
 </div>
		
        </div>
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>              
              <th width="10%"> Date </th>
			  <th width="20%"> Transaction Title </th>
			  <th width="10%"> Debit Amount</th>
			  <th width="10%"> Credit Amount</th>
              <th width="10%"> TXN Number </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_transactions = count($transactions);
				if($count_transactions > 0)
				{ 
				  foreach($transactions as $transaction )
				  {
				   
				   $class = 'green';
				   if($transaction['debit_amount'] > 0){
				   	 $class = 'short';
				   }
			   ?>
                    <tr class="odd gradeX <?php echo $class; ?>" >
						<td><?php echo date('d M Y',strtotime($transaction['transaction_date'])); ?></td>			   
						<td><?php echo $transaction['transaction_title']; ?></td>
						<td><?php echo number_format($transaction['debit_amount'],2); ?></td>	 
						<td><?php echo number_format($transaction['credit_amount'],2); ?></td>
					    <td><a href="javascript:void(0)" title="View Details" class="trans_details" id="<?php echo $transaction['id'];?>" ><?php echo $transaction['transaction_id']; ?></a></td>
                    </tr>
            <?php
				 }
			}?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>

<div id="ajax1">
	<div id="appts_popup" class="modal fade" tabindex="-1" data-width="400">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:closePopup()"></button>
				<h4 class="modal-title" ><b id="popup_title"></b></h4>
			</div>
			<div id="appts-details" class="modal-body row" style="padding:3%;"></div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn" 	onclick="javascript:closePopup()">Close</button>
			</div>
		</div>
	</div>	
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.trans_details').click(function () {
   		var id = $(this).attr('id');
		$.ajax({
				url: SITE_URL+"payment/transaction_details/",
				data: { 
					"id": id
				}, 
				type:'POST',
				async:false,
				success: function(result){
					$("#popup_title").html("Transaction Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});		
			
    });
});

</script>