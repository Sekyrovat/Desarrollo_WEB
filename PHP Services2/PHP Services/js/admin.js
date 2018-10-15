$("#updateButton").on("click", function(event){
	event.preventDefault();

	let jsonToSend = {
						"userName" : $("#userName").val(),
						"currentPassword" : $("#currentPassword").val(),
						"newPassword" : $("#newPassword").val()
					};

	$.ajax({
		url : "./data/adminServices.php",
		type : "PUT",
		data : jsonToSend,
		ContentType : "application/json",
		dataType : "json",
		success : function (data) {
			console.log(data);
		},
		error : function (error) {
			console.log(error);
		}
	});
});

$("#deleteButton").on("click", function (event){
	event.preventDefault();

	let jsonToSend = {
						"userName" : $("#userName").val(),
						"currentPassword" : $("#currentPassword").val()
					};

	$.ajax({
		url : "./data/adminServicesDelete.php",
		type : "DELETE",
		data : jsonToSend,
		ContentType : "application/json",
		dataType : "json",
		success : function (data) {
			console.log(data);
		},
		error : function (error) {
			console.log(error);
		}
	});
});