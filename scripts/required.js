// //init login check
// $(document).ready(function(){
		// //pass init details
		// $.post("admin.php",{loggedin: false,logout:false,} ,
			// function(data)
				// {
				  // if(data!='0') //not logged in
				  // { 
					// $("#login").html('Hello, ' + data);
					// $("#login").append("<a href='dashboard.php'><b>My Dashboard</b></a>");
					// $("#login").append("<a href='init.php?logout'><b>Logout</b></a></div>");
					// $("#login").append("<br><div id='savebox'></div>");
				  // }	
				// });
		// return false; //not to post the form 
// });
//login script
$(document).ready(function(){
	$("#login_form").submit(function()
	{
		//pass login details
		$.post("../admin/login.php",{ 
			user:$('#username').val(),
			pass:$('#password').val(),
			rand:Math.random() } ,
			function(data)
				{
				  data = data.replace(/(\r\n|\n|\r)/gm,""); //remove line breaks.
				  if(data=="1") //if correct login details
				  { 
					 //redirect to secure page
					 // $("#login").html('Hello, ' + data);
					 document.location='dashboard.php';
					 //$("#loginmsg").html('Login passed');
				  }
				  else 
				  {
					$("#loginmsg").html('Login failed');
					// $("#loginmsg").html($('#username').val());
					$("#loginmsg").html(data);
				  }	
				});
		return false; //not to post the form 
	});
});

//admin update info script
$(document).ready(function(){
	$("#info_form").submit(function()
	{
	
		var infoArray = new Array($('#name').val(),$('#username').val(), $('#password').val(), $('#email').val(),$('#year').val());

		//pass the update details
		$.post("handlers.php",{ 
			func:"1",
			'params[]': infoArray,
			rand:Math.random() } ,
			function(data)
				{
					$("#formmsg").html(data);
				
				  // if(data=='1') 
					// $("#regmsg").html('Please fill the form completely!');
				  // else if(data=='2') 
					// $("#regmsg").html("Passwords don't match!");
				 // else if(data=='3') 
					// $("#regmsg").html("Emails don't match!");
				  // else if(data=='4') 
					// $("#regmsg").html('That username already exists, sorry.');
				  // else if(data=='5') //if correct registration details
					 // document.location='test.php';
				  // else //catch all
					// $("#regmsg").html('Registration failed, try again.');
				});
		return false; 
	});
});


//register script
$(document).ready(function(){
	$("#reg_form").submit(function()
	{
		//pass the registration details
		$.post("register.php",{ 
			fn:$('#regfn').val(),
			ln:$('#regln').val(),
			user:$('#reguser').val(),
			pass:$('#regpass').val(),
			pass2:$('#regpass2').val(),
			email:$('#regemail').val(),
			email2:$('#regemail2').val(),
			rand:Math.random() } ,
			function(data)
				{
				  if(data=='1') 
					$("#regmsg").html('Please fill the form completely!');
				  else if(data=='2') 
					$("#regmsg").html("Passwords don't match!");
				 else if(data=='3') 
					$("#regmsg").html("Emails don't match!");
				  else if(data=='4') 
					$("#regmsg").html('That username already exists, sorry.');
				  else if(data=='5') //if correct registration details
					 document.location='test.php';
				  else //catch all
					$("#regmsg").html('Registration failed, try again.');
				});
		return false; 
	});
});
// $(document).ready(function(){
	// //colorbox - enable window if login is clicked.
	// $("#loginbtn").colorbox({width:"50%", inline:true, href:"#login_form"});
	// $("#regbtn").colorbox({width:"50%", inline:true, href:"#reg_form"});
// });

// var id = "a2sdf";
// //document save init
// $(document).ready(function(){
	// //pass doc id
	// $.post("save.php",{ identifier: id, saved: false} ,
		// function(data)
			// {
			  // if(data=='0') //if not saved
			  // { 
				 // $("#savebox").html('<form method="post" action="" id="save_form"><input name="Submit" type="submit" id="submit" value="Save" /></form>');
				// //wait for save submission.
				// $("#save_form").submit(function()
				// {
					// //pass doc details
					// $.post("save.php",{ identifier: id, saved: true } ,
						// function(data)
							// {
							  // if(data=='2') //if doc saved
							  // { 
								// $("#savebox").html('Saved.');
							  // }
							  // else 
							  // {
								// $("#savebox").html('<form method="post" action="" id="save_form"><input name="Submit" type="submit" id="submit" value="Retry Save" /></form>');
							   // }	
								
							// });
					// return false; //not to post the form 
				// });
			  // }
			  // else if(data=='1')
			  // {
				// $("#savebox").html('Saved.');
			  // }
			// });
	// return false; //not to post the form 
// });