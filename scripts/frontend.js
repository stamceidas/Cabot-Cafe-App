$(document).ready(function(){
	
	$("#pinSubmitButton").on("click",pinVerify);
	$("#nightlySubmitButton").live("click",getFormValues);
	$("#nightlyInvButton").on("click",getNightlyForm);
	
	// $('#target').live('submit', params=$(this).parents('form').serializeArray(), function() {
		// alert('Handler for .submit() called.');
		// //return false;
	// });
	
});


function getNightlyForm(){
	
	var paramsArray = { 
		"formtype" : "nightly"
	};
	
	
	$.ajax({
		type: "POST",
		url: "admin/handlers.php",
		data: "func=7&params="+JSON.stringify(paramsArray),
		dataType: 'json',
		success: function(data){
			if(data.status == 'success'){
				//trigger allows html to be styled by jqm after ajax load
				$('#nightlyformcapsule').html(data.msg).trigger('create');
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
				$(this).parent().hide("fast");
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
