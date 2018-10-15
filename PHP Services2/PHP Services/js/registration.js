$("#registerButton").on("click", function(event){
	event.preventDefault();

	let jsonToSend ={
						"username" : $("#username").val(),
						"userPassword" : $("#userPassword").val(),
						"userFirstName" : $("#firstName").val(),
						"userLastName" : $("#lastName").val()

					};

	$.ajax({
		url : "./data/registrationService.php",
		type : "POST",
		data : jsonToSend,
		ContentType : "application/json",
		dataType : "json",
		success : function(data){
			console.log(data);
			$(location).attr("href", "./home.html");
		},
		error : function(error){
			console.log(error);
		}
	});
});

$("#cancelButton").on("click", function(event){
	event.preventDefault();

	$(location).attr("href", "./index.html");
})