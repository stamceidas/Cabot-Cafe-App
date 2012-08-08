$(document).ready(function(){
	
	$("#pinSubmitButton").on("click",pinVerify);
	$("#nightlySubmitButton").live("click",getFormValues);
	$("#nightlyInvButton").live("click",getInvForm);
	$("#weeklySubmitButton").live("click",getFormValues);
	$("#weeklyInvButton").on("click",getInvForm);

});


function getInvForm(){
	
	// get the type of form to load
	var formtype = $(this).attr("name");
	
	var paramsArray = { 
		"formtype" : formtype
	};
	
	
	$.ajax({
		type: "POST",
		url: "admin/handlers.php",
		data: "func=7&params="+JSON.stringify(paramsArray),
		dataType: 'json',
		success: function(data){
			if(data.status == 'success'){
				//trigger allows html to be styled by jqm after ajax load
				if(formtype == 'nightly')
					$('#nightlyformcapsule').html(data.msg).trigger('create');
				else if(formtype == 'weekly')
					$('#weeklyformcapsule').html(data.msg).trigger('create');
			}
			if(data.status == 'error'){
				alert(data.msg);
			}
		},
		error: function(data){
			alert("Problem loading user form!");
		}
	});
}


function pinVerify(){
	var paramsArray = { 
		"pin" : $('#pinbox').val()
	};

	$.ajax({
		type: "POST",
		url: "admin/handlers.php",
		data: "func=6&params="+JSON.stringify(paramsArray),
		dataType: 'json',
		success: function(data){
			if(data.status == 'success'){
				window.location.href = "menu.php";
			}
			if(data.status == 'error'){
				alert(data.msg);
			}
		},
		error: function(data){
			alert("Problem loading user form!");
		}
	});	
}


function getFormValues(){
	console.log($(this).parents('form').serializeArray());
	var formElt = $(this).parent();
	
	//$(this).parent().hide();
	var paramsArray = $(this).parents('form').serializeArray();

	$.ajax({
		type: "POST",
		url: "admin/handlers.php",
		data: "func=8&params="+JSON.stringify(paramsArray),
		// url: "nightly.php",
		// data: "params="+JSON.stringify(paramsArray),
		dataType: 'json',
		success: function(data){
			if(data.status == 'success'){
				alert(data.msg);
				formElt.hide();
				formElt.parent().find('.response').html(data.msg).trigger('create');
			}
			if(data.status == 'error'){
				alert(data.msg);
			}
		},
		error: function(data){
			alert("Problem sending form!");
		}
	});	
	
	return false;

}
