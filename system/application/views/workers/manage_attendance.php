<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Attendance: <?php echo $employee_details[0]['emp_name'];?></span></div>
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
			echo form_open('workers/attendance/'.$employee_details[0]['emp_id'],$attributes);
				
			
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
        <table class="table table-striped table-bordered table-hover" > <!--id=" sample_2"-->
          <thead>
            <tr>              
              <th> Sr.No </th>
			  <th> Date </th>
			  <th > In Time</th>
			  <th > Out Time</th>
             
			  <th > Work Hours </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_attendance = count($attendance);
				$totalHrs = $totalMins = $i= $lunchHrs = 0;
				
				if($count_attendance > 0)
				{ 
				  foreach($attendance as $row )
				  {
				   $i++;
				  
			   ?>
                    <tr class="odd gradeX" >
					
						<td><?php echo $i; ?></td>			
						<td><?php echo date('d M Y',strtotime($row['atn_date'])); ?></td>			   
						<td><?php 
								$in_time = new DateTime($row['in_time']);
								echo $in_time->format('h:i A') ;
						  ?></td>
						<td><?php 
						
								$out_time = new DateTime($row['out_time']);
								echo $out_time->format('h:i A') ;
						
						 ?></td>	 
						
					    <td><?php //echo (strtotime($row['out_time'])-strtotime($row['in_time']))/(60*60);
						
						
								$datetime1 = new DateTime($row['in_time']);//start time
								$datetime2 = new DateTime($row['out_time']);//end time
								$interval = $datetime1->diff($datetime2);
								$totalHrs += $interval->format('%H');
								$totalMins += $interval->format('%i');
								echo $interval->format('%H Hrs %i Mins');
						?>
						</td>
                    </tr>
            <?php
				 } ?>
				 	<tr class="odd gradeX" >
						<td colspan="4" align="right"><strong>Total Work Hours Including Lunch Time:</strong> </td>	 
						<td><strong><?php 
						  //$hrsMins =  round(($totalMins/60),2);
						 $minutes = ($totalHrs*60)+$totalMins;
						 
						 $totalHours = floor($minutes / 60);
						 $remainigMins = ($minutes % 60);
						 echo $totalHours.' Hrs '.$remainigMins.' Mins'
						// echo date('H:i', mktime(0,$minutes)); ?></strong>
						</td>
					    
                    </tr>
					  
          <?php }?>
		  
          </tbody>
        </table>
		<div class="row" style="margin-top: 15px;">
		<div class="col-md-12">
		  <div class="form-group">
			<div class="col-md-4"> <strong>Total Work Hours:</strong><br/>
			  <?php 
			  		echo $totalHours.' Hrs '.$remainigMins.' Mins';
			   ?>
			</div>
			<div class="col-md-4"> <strong>Total Lunch Hours:</strong><br/>
			  <?php 
			  $lunchTime = $i*30; 
			  $lunchHours = floor($lunchTime / 60);
			  $lunchMins = ($lunchTime % 60);
			 echo $lunchHours.' Hrs '.$lunchMins.' Mins' ?>
			</div>
			<div class="col-md-4"> <strong>Total Payble Hours:</strong><br/>
			  <?php  
			  $finalHours = floor(($minutes-$lunchTime) / 60);
			  $finalMins = (($minutes-$lunchTime) % 60);
			 echo $finalHours.' Hrs '.$finalMins.' Mins' ?>
			</div>
		  </div>
		</div>
	  </div>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>