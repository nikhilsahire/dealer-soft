<div class="page-bar"> <?php echo $bredcrumbs;?> </div>
<div class="row">
<div class="col-md-12">
  <!-- BEGIN EXAMPLE TABLE PORTLET-->
  <div class="portlet box grey-cascade">
    <div class="portlet-title">
      <div class="caption"> <i class="fa fa-globe"></i>Add Attendance </span></div>
      <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
    </div>
    <div class="portlet-body">
      <?php if(validation_errors()){?>
      <div class="alert alert-danger display-hide" style="display: block;">
        <button class="close" data-close="alert"></button>
        You have some form errors. Please check below. </div>
      <?php } ?>
      <?php if(isset($_SESSION['suc_msg'])){ ?>
      <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>"> <?php echo $_SESSION['suc_msg'];
			 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
	  ?> </div>
      <?php } ?>
      <div class="table-toolbar">
	  <?php  
			$attributes = array('class' => 'form-inline', 'id' => 'myform');
			echo form_open('attendance/',$attributes);
	  ?>
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
          <div class="row" style="margin-bottom:20px; text-align:center">
            <div class="col-md-12">
              <div class="form-group"  style="margin-top:2px;">
                <label class="control-label">Date</label>
                <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                  <input type="text" class="form-control" id="attendanceDate" name="attendanceDate" required="required" value="<?php echo $date; ?>" readonly >
                  <span class="input-group-btn">
                  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                  </span> </div>
              </div>
              
              
            </div>
          </div>
         
        </div>
		
        <table class="table table-striped table-bordered table-hover" >
          <!--id=" sample_2"-->
          <thead>
            <tr>
              <th> Employee Name </th>
              <th > In Time</th>
              <th > Out Time</th>
              <th > Work Hours </th>
              
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_attendance = count($worker_details);
				if($count_attendance > 0)
				{ 
				  foreach($worker_details as $row )
				  {
				   
				  
			   ?>
            <tr class="odd gradeX" >
              <td>
			  	<?php echo $row['emp_name']; ?>
				<input type="hidden" name="emp_id[]" value="<?php echo $row['emp_id']; ?>" />
			  </td>
              <td>
			  			<div class="input-group">
							<input type="text" name="in_time[]" id="in_time_<?php echo $row['emp_id']; ?>"  class="form-control timepicker timepicker-24">
							<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
							</span>
						</div>
												
			 </td>
              <td>
			  		<div class="input-group"> <!--timepicker-no-seconds-->
							<input type="text" name="out_time[]" id="out_time_<?php echo $row['emp_id']; ?>"   class="form-control timepicker timepicker-24">
							<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
							</span>
						</div>
			  </td>
              <td><?php echo '-'; ?></td>
             
            </tr>
            <?php } ?>
				<tr>
              <td colspan="4" > 
			  	<div class="row" style="margin-top: 10px; text-align:right;">
					<div class="col-xs-12">	
						<input name="submit" value="Submit" class="btn green" type="submit">
				</div>
			  </div> </td>
              
            </tr> 
				 
			<?php }?>
          </tbody>
        </table>
	  <?php	
		echo form_close();
	  ?>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>