$(document).ready(function(){
	$('#userDiag').dialog({ autoOpen: false, 
							modal: true,
							buttons: {
								'Submit': function() {
								
										var paramsArray = { 
											 "id" : $("#userform").attr("name"),
											 "username" : $('#username').val(),
											 "firstname" : $('#firstname').val(),
											 "lastname" : $('#lastname').val(), 
											 "email" : $('#email').val(),
											 "year" : $('#year').val(),
											 "sudo" : $('#sudo').val()
										};
										
										// var id = $("#userform").attr("name");
										// var uname = $('#username').val();
										// var fname = $('#firstname').val();
										// var lname = $('#lastname').val();
										// var email = $('#email').val();
										// var year = $('#year').val();
										// var sudo = $('#sudo').val();
										// console.log(id);
										// console.log(uname);
										$.ajax({
											type: "POST",
											url: "../admin/handlers.php",
											// data: "func=2&id="+id+"&uname="+uname+"&fname="+fname+"&lname="+lname+"&email="+email+"&year="+year+"&sudo="+sudo,
											data:"func=2&params="+JSON.stringify(paramsArray),
											dataType: 'json',
											success: function(data){
												alert(data.msg);
												console.log(data.msg);
												
												// $('#userDiag').html('');
												// $('#userDiag').html(data.form);
												// $('#userDiag').dialog('open');
											},
											error: function(data){
												alert("Problem loading user form!");
											}
										});	
										$(this).dialog('close');
									
								},
								'Cancel': function() {
									$(this).dialog('close');
								}
							}
	});
	
	 
	
	$('#addUserButton').click(openUserDiag());
});

function openUserDiag(){
	
	$("#addUserButton").click(function()
	{
		$.ajax({
			type: "POST",
			url: "../admin/forms/userForm.php",
			data: "",
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