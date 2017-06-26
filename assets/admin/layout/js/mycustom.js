var UIAlertDialogApi = function () {
  
    var handleDialogs = function() {


        
            $('.del').click(function(){ 
			  var qid=$(this).attr('id');
			  
                bootbox.confirm("Are you sure want delete this user?", function(result) {
				   	$.ajax({
				url: SITE_URL+"users/delete/"+qid, 
				async:false,
				success: function(result){
					if(result == 1){
						
						$("#delmsg").show();
						$("#delmsg .msg").html('User deleted successfully.');
						window.location.reload();
					}else{
						$("#delmsg").show();
						$("#delmsg .msg").html('Sorry, There is no such user to delete');
					}
				}
			});	
                }); 
            });
			
			
    }

    var handleAlerts = function() {
        
        $('#alert_show').click(function(){

            Metronic.alert({
                container: $('#alert_container').val(), // alerts parent container(by default placed after the page breadcrumbs)
                place: $('#alert_place').val(), // append or prepent in container 
                type: $('#alert_type').val(),  // alert's type
                message: $('#alert_message').val(),  // alert's message
                close: $('#alert_close').is(":checked"), // make alert closable
                reset: $('#alert_reset').is(":checked"), // close all previouse alerts first
                focus: $('#alert_focus').is(":checked"), // auto scroll to the alert after shown
                closeInSeconds: $('#alert_close_in_seconds').val(), // auto close after defined seconds
                icon: $('#alert_icon').val() // put icon before the message
            });

        });

    }

    return {

        //main function to initiate the module
        init: function () {
            handleDialogs();
            handleAlerts();
        }
    };

}();
