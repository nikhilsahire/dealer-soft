function view_state(cptid)
{
  
  	$.ajax({
				url: SITE_URL+"state_con/get_state_details/"+cptid, 
				async:false,
				success: function(result){
					$("#popup_title").html("State Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});	
}



var UIAlertDialogApi = function () {
  
    var handleDialogs = function() {


        
            $('.del').click(function(){ 
			  var qid=$(this).attr('id');
			  
                bootbox.confirm("Are you sure?", function(result) {
				   	$.ajax({
				url: SITE_URL+"coupon_con/delete_coupon/"+qid, 
				async:false,
				success: function(result){
					
					window.location.reload()
					$("#delmsg").show();
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