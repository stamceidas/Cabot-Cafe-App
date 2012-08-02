$(document).ready(function(){
	
	$("#pinSubmitButton").on("click",pinVerify);
	$("#testingButton").on("click",getFormValues);
	$("#nightlyInvButton").on("click",getNightlyForm);
});


function getNightlyForm(){
	console.log("testing");
	
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
				alert(data.msg);
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
	return false;

}
