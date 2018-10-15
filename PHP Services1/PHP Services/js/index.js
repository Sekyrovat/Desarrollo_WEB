$('#loginButton').on("click", function (event) {
	// we dont want to refresh the page.
	event.preventDefault();

	// Since the service expects to recieve a json element we create it.
	let jsonToSend = {
						"username" : $('#username').val(),
						"password" : $('#userPassword').val()
					};
	$.ajax({
		// It should be as dynamic as possible.
		url : "./data/loginService.php",
		type : "GET",
		data : jsonToSend,
		// We specify the application, since the application parses the json
		// in case it has special chars.
		contentType : "application/json",
		dataType : "json",
		success :function (data) {
			console.log(data);
		},
		error : function (err) {
			console.log(err);
		} 
	});
})

$('#registerButton').on("click", function (event) {
	$(location).attr("href","./registration.html")
})
