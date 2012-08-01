$(document).ready(function(){
	
	$("#pinSubmitButton").on("click",pinVerify);
	
});


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