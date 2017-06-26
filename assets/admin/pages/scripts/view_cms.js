function view_chapter(cptid)
{
  
  	$.ajax({
				url: SITE_URL+"cms_con/get_page_details/"+cptid, 
				async:false,
				success: function(result){
					$("#popup_title").html("Chapter Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});	
}

function view_faq(cptid)
{
  
  	$.ajax({
				url: SITE_URL+"faq_con/get_faq_details/"+cptid, 
				async:false,
				success: function(result){
					$("#popup_title").html("FAQ Details");
					$("#selDispo").attr("data-target","#appts_popup_faq");
					$("#appts-details").html(result);
					$("#appts_popup_faq").modal('toggle');
				}
			});	
}

var UIAlertDialogApi = function () {
  
    var handleDialogs = function() {


        
            $('.del').click(function(){ 
			  var qid=$(this).attr('id');
			  
                bootbox.confirm("Are you sure?", function(result) {
				   	$.ajax({
				url: SITE_URL+"cms_con/delete_cms_page/"+qid, 
				async:false,
				success: function(result){
					
					window.location.reload()
					$("#delmsg").show();
				}
			});	
                }); 
            });
			
			$('.del_faq').click(function(){ 
			  var qid=$(this).attr('id');
			  
                bootbox.confirm("Are you sure?", function(result) {
				   	$.ajax({
				url: SITE_URL+"faq_con/delete_faq/"+qid, 
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