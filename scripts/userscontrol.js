$(document).ready(function(){

	$('#userDiag').dialog({ autoOpen: false, 
							modal: true,
							width: 500,
							title: 'Create User',
							buttons: {
								'Submit': function() {
										var paramsArray = { 
											 "id" : $("#userform").attr("name"),
											 "username" : $('#username').val(),
											 "password" : $('#password').val(),
											 "password2" : $('#password2').val(),
											 "firstname" : $('#firstname').val(),
											 "lastname" : $('#lastname').val(), 
											 "email" : $('#email').val(),
											 "year" : $('#year').val(),
											 "sudo" : $('#sudo').is(':checked') ? $('#sudo').val() : ''
										};
										
										$.ajax({
											type: "POST",
											url: "../admin/handlers.php",
											data:"func=2&params="+JSON.stringify(paramsArray),
											dataType: 'json',
											success: function(data){
												if(data.status == 'success'){
													$(this).dialog('close');
													location.reload();
												}
												if(data.status == 'error'){
													alert(data.msg);
												}
											},
											error: function(data){
												alert("Problem loading form!");
											}
										});	
								},
								'Cancel': function() {
									$(this).dialog('close');
								}
							}
	});
	
	
	

	
	
	
	
	$('#addUserButton').click(openUserDiag());
});

function openUserDiag(){
	
	$(".updateUserButton").click(function()
	{
		$.ajax({
			type: "POST",
			url: "../admin/forms/userForm.php",
			data: "id="+$(this).attr("name"),
			dataType: 'json',
			success: function(data){
				$('#userDiag').html('');
				$('#userDiag').html(data.form);
				$('#userDiag').dialog('open');
			},
			error: function(data){
				alert("Problem loading user form!");
			}
		});	
	});

}