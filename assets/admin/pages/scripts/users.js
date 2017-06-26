function view_user(uid)
{
  
  	$.ajax({
				url: SITE_URL+"users/viewUser/"+uid, 
				async:false,
				success: function(result){
					$("#popup_title").html("User Details");
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


$(document).ready(function() {
	$('#assign-clients').change(function() {
		var compnay_name = $('#assign-clients option:selected').text();
		var compnay_id = $('#assign-clients').val();
		var handling_person = $('#handling_person').val();
		var url = base_url+'users/add_client_person'
		$.post(url,
		    {
				compnay_id:compnay_id,
				handling_person:handling_person,
				action: 'add'
			},
			function(responseText){	
				if(responseText == 1){
					//var addHtml = '<div class="col-md-6" id="row_'+compnay_id+'"><div class="form-group"><label class="control-label"><a title="Delete" alt="Delete" href="javascript:void(0)" class="btn default btn-xs red"><i class="fa fa-trash-o remove" id="'+compnay_id+'"></i></a> '+compnay_name+'</label></div></div>';
				 //$('#assigned-companies').append(addHtml);
				 location.reload(true);
				}
				
		});
	});
	
	$('.remove').click(function(){
		
		var compnay_id = $(this).attr('id');
		var url = base_url+'users/remove_client_person'
		$.post(url,
		    {
				compnay_id:compnay_id,
				action: 'update'
			},
			function(responseText){				
				if(responseText == 1){
					location.reload(true);
				}
				
		});					
	})
	
	$('#assign-suppliers-user').change(function() {
		alert(1);
		var supplier_name = $('#assign-suppliers option:selected').text();
		var supplier_id = $('#assign-suppliers-user').val();
		var handling_person = $('#handling_person').val();
		var url = base_url+'users/add_supplier_person'
		$.post(url,
		    {
				supplier_id:supplier_id,
				handling_person:handling_person,
				action: 'add'
			},
			function(responseText){	
				if(responseText == 1){
				 location.reload(true);
				}
				
		});
	});
	
	$('.remove-supplier').click(function(){
		
		var supplier_id = $(this).attr('id');
		var url = base_url+'users/remove_supplier_person'
		$.post(url,
		    {
				supplier_id:supplier_id,
				action: 'update'
			},
			function(responseText){				
				if(responseText == 1){
					location.reload(true);
				}
				
		});					
	})
});