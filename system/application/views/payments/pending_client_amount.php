<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i><?php echo $pagetitle; ?></span></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
	 
        <div class="table-toolbar">
          
		  
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>              
              
			  <th width="30%"> Client Name </th>
			  <th width="15%"> Contact Person</th>
			  <th width="15%"> Phone Number</th>
              <th width="15%"> Mobile Number </th>
			  <th width="15%"> Debit Amount </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_transactions = count($pendingAmount);
				if($count_transactions > 0)
				{ 
				  foreach($pendingAmount as $transaction )
				  {
				   
				   
			   ?>
                    <tr class="odd gradeX " >
						<td><a href="<?php echo base_url()?>payment/transactions/<?php echo $transaction['comp_id']; ?>"><?php echo $transaction['comp_name']; ?></a></td>			   
						<td><?php echo $transaction['primary_contact']; ?></td>
						<td><?php echo $transaction['primary_phone']; ?></td>	
						<td><?php echo $transaction['primary_mobile']; ?></td>	 
						<td class="short"><?php echo number_format($transaction['balanceAmt'],2); ?></td>
					   
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