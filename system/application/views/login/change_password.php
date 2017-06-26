<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="portlet box blue ">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Change Password </div>
        <div class="tools"> <a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
        <form action="<?php echo base_url()?>login_con/change_password" class="form-horizontal form-bordered form-label-stripped" method="post">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Old Password</label>
              <div class="col-md-9">
                <input type="text" placeholder="Old password" class="form-control" name="old_pwd" required="required"/>
                <span class="help-block"> Enter old password </span> </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">New Password</label>
              <div class="col-md-9">
                <input type="text" placeholder="New password" class="form-control" name="new_pwd" required="required"/>
                <span class="help-block"> Enter new password </span> </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Confirm Password</label>
              <div class="col-md-9">
                <input type="text" placeholder="Confirm password" class="form-control" name="confirm_pwd" required="required"/>
                <span class="help-block"> Enter confirm password </span> </div>
            </div>
          </div>
          <div class="form-actions right">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <input type="submit" class="btn green" name="submit" id="submit" value="Save" /> 
              </div>
            </div>
          </div>
        </form>
        <!-- END FORM--> 
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT--> 
