$("#loginButton").on("click", function(event){
	event.preventDefault();

	let jsonToSend ={
						"username" : $("#username").val(),
						"password" : $("#userPassword").val()
					};

	$.ajax({
		url : "./data/loginService.php",
		type : "GET",
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

$("#registerButton").on("click", function(event){
	event.preventDefault();

	$(location).attr("href", "./registration.html");
})