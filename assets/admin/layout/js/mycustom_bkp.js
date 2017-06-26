// JavaScript Document
jQuery(document).ready(function() {
	jQuery('#save_credit').click(function(){
		var courseid = jQuery('#course_id').val();
		var credittype = jQuery('#credit_type').val();
		var stateid = jQuery('#state').val();
		var credits = jQuery('#credits').val();
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		if(stateid == '')
		{
			alert('Please select states.');
			return false;
		}
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		var url = base_url+'course_con/add_credits'
		$.post(url,
		    {
				course_id:courseid,
				state_id:stateid,
				credit_type:credittype,
				credits:credits,
				action: 'add'
			},
			function(responseText){
				var obj = jQuery.parseJSON(responseText);
			    if(obj.length > 0)
				{
					location.href = base_url+'course_con/manage_credits/'+courseid;
				}else{
					 alert(obj.message);
				}
				
		});
	});
	
	jQuery('#edit_credit').click(function(){
		var courseid = jQuery('#course_id').val();
		var credittype = jQuery('#credit_type').val();
		var stateid = jQuery('#state').val();
		var credits = jQuery('#credits').val();
		var creditsid = jQuery('#credit_id').val();
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		if(stateid == '')
		{
			alert('Please select states.');
			return false;
		}
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		var url = base_url+'course_con/edit_credits'
		
		$.post(url,
		    {
				course_id:courseid,
				state_id:stateid,
				credit_type:credittype,
				credits:credits,
				credit_id:creditsid,
				action: 'edit'
			},
			function(responseText){
				var obj = jQuery.parseJSON(responseText);
			    if(obj.length > 0)
				{
					location.href = base_url+'course_con/manage_credits/'+courseid;
				}else{
					 alert(obj.message);
				}
				
		});
		
		
		
	});
	
	jQuery('#save_state_credit').click(function(){
		var stateid = jQuery('#state_id').val();
	
		var credittype = jQuery('#credit_type').val();
		//var stateid = jQuery('#state').val();
		var credits = jQuery('#credits').val();
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		$("#save_credit").hide();
		var url = base_url+'state_con/add_credits'
		$.post(url,
		    {
				
				state_id:stateid,
				credit_type:credittype,
				credits:credits,
				action: 'add'
			},
			function(responseText){
				
				var obj = jQuery.parseJSON(responseText);
			    if(obj.length > 0)
				{
					location.href = base_url+'state_con/manage_credits/'+stateid;
				}else{
					 alert(obj.message);
					 $("#save_credit").show();
				}
				
		});
	});
	
	jQuery('#edit_state_credit').click(function(){
		
		var credittype = jQuery('#credit_type').val();
		
		var stateid = jQuery('#state_id').val();
		var credits = jQuery('#credits').val();
		var creditsid = jQuery('#credit_id').val();
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		if(stateid == '')
		{
			alert('Please select states.');
			return false;
		}
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		var url = base_url+'state_con/edit_credits'
		
		$.post(url,
		    {
				
				state_id:stateid,
				credit_type:credittype,
				credits:credits,
				credit_id:creditsid,
				action: 'edit'
			},
			function(responseText){
				var obj = jQuery.parseJSON(responseText);
			    if(obj.length > 0)
				{
					location.href = base_url+'state_con/manage_credits/'+stateid;
				}else{
					 alert(obj.message);
				}
				
		});
		
		
		
	});
	
	
});

function edit_pdf(course_id,pdf_id)
{
	var url = base_url+'course_con/get_course_pdf';
	$.post(url,
	{
		course_id:course_id,
		pdf_id:pdf_id
	},
	function(responseText){
		 var obj = jQuery.parseJSON(responseText);
		  if(obj.length > 0)
		  {
			   for(var i = 0;i < obj.length;i++)
			   {
				   $("#course_pdf_name").val(obj[i].pdf_name);
				   $("#myform_pdf").attr('action',base_url+'course_con/edit_pdf_material');
				   $("#coursepdf #mysubmit").val('Edit');
				   $("#pdf_url a").attr('href',base_url+'uploads/pdf/'+obj[i].course_pdf);
				   $("#pdf_url a").html(obj[i].course_pdf);
				   $("#pdf_id").val(obj[i].id);
				   $("#old_pdf").val(obj[i].course_pdf);
				   $("#pdf_url").show();
				   $('#coursepdf').modal();
			   }
		  }else{
			  alert('No record found...!');
		  }
	    }
	);
}

function edit_video(course_id,video_id)
{
	var url = base_url+'course_con/get_course_video';
	
	$.post(url,
	{
		course_id:course_id,
		video_id:video_id
	},
	function(responseText){
		 var obj = jQuery.parseJSON(responseText);
		 if(obj.length > 0)
		 {
			  for(var i = 0;i < obj.length;i++)
			  {
				   $("#course_video_name").val(obj[i].video_name);
				   $("#video_url").val(obj[i].video_url);
				   $("#video_id").val(obj[i].id);
				   $("#myform_video").attr('action',base_url+'course_con/edit_video_material');
				   $("#coursevideo #mysubmit").val('Edit');
				   $('#coursevideo').modal();
			  }
		 }else{
			 alert('No record found...!');
		}
	}
	);
}
function delete_pdf(course_id,pdf_id)
{
	var url = base_url+'course_con/delete_pdf';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id,
			  pdf_id:pdf_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con/manage_material/'+course_id;
			  }
		  }
		 );  
	});
	
	$('#delete_record').modal();
}

function delete_video(course_id,video_id)
{
	var url = base_url+'course_con/delete_video';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id,
			  video_id:video_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con/manage_material/'+course_id;
			  }
		  }
		 );  
	});
	
	$('#delete_record').modal();
}
function delete_credits(course_id,credit_id)
{
	var url =  base_url+'course_con/delete_credits';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id,
			  credit_id:credit_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con/manage_credits/'+course_id;
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_state_credits(state_id,credit_id)
{
	var url =  base_url+'state_con/delete_credits';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  stateid:state_id,
			  creditid:credit_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'/state_con/manage_credits/'+state_id;
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_questions(course_id,ques_id)
{
	 var url =  base_url+'course_con/delete_questions';
	 $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id,
			  ques_id:ques_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con/manage_course_quest/'+course_id;
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_customer(cust_id)
{
	 var url =  base_url+'users/delete';
	  $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  cust_id:cust_id
		  },function(responseText){
			  alert(456);
			  if(responseText == 1){
				  alert(123);
				   location.href = base_url+'users';
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_courses(course_id)
{
	var url =  base_url+'course_con/delete_course';
	
	 $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con';
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_bundle(bundle_id)
{
	 var url =  base_url+'bundle_con/delete_bundle';
	 
	  $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  bundle_id:bundle_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'bundle_con';
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function make_course_complete(id)
{   
	 var url =  base_url+'customer_con/complete_course';
	 alert(id)
	 /* $('#course_complted #yes').click(function(){
		  alert(11)
		 $.post(url,
		  {
			  uid:id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'userorder_con';
			  }
		  }
		 );  
	});*/
	$('#course_complted').modal();
}