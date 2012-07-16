$(document).ready(function(){
	$('#itemDiag').dialog({ autoOpen: false, 
							modal: true,
							width: 500,
							title: 'Create Item',
							buttons: {
								'Submit': function() {
										var paramsArray = { 
											 "id" : $("#itemform").attr("name"),
											 "itemname" : $('#itemname').val(),
											 "location" : $('#location').val(),
											 "minamt" : $('#minamt').val(),
											 "maxamt" : $('#maxamt').val(),
											 "increment" : $('#increment').val(), 
											 "measure_type" : $('#measure_type').val(),
											 "warning_limit" : $('#warning_limit').val(),
											 "itemType":"nightly"
										};
										
										$.ajax({
											type: "POST",
											url: "../admin/handlers.php",
											data:"func=4&params="+JSON.stringify(paramsArray),
											dataType: 'json',
											success: function(data){
												if(data.status == 'success'){
													$(this).dialog('close');
													location.reload();
												}
												if(data.status == 'update_success'){
													alert(data.msg);
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
	
	$(".updateItemButton").on("click",openItemDiag);
	$('.deleteItemButton').on("click",deleteItem);
});

function deleteItem(){
	
	if(confirm("Are you sure you want to delete this item?")){	
		var paramsArray = { 
			"id" : $(this).attr("name")
		};
			
		$.ajax({
			type:"POST",
			url: "../admin/handlers.php",
			data: "func=5&params="+JSON.stringify(paramsArray),
			dataType: 'json',
			success: function(data){
				if(data.status == 'success'){
					$(this).dialog('close');
					// alert(data.msg);
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
	}
}

function openItemDiag(){
	$.ajax({
		type: "POST",
		url: "../admin/forms/itemForm.php",
		data: "id="+$(this).attr("name"),
		dataType: 'json',
		success: function(data){
			$('#itemDiag').html('');
			$('#itemDiag').html(data.form);
			$('#itemDiag').dialog('open');
		},
		error: function(data){
			alert("Problem loading item form!");
		}
	});	
}