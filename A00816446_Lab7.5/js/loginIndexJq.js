$('#loginSubmit').on("click",function(event){
	event.preventDefault();
	if (validateLogin()){

		let jsonToSend ={
						"userName" : $("#loginUserName").val(),
						"userPassword" : $("#loginUserPass").val(),
						"action" : "LOGIN"
					};

		$.ajax({
			url : "./data/applicationLayer.php",
			type : "GET",
			data : jsonToSend,
			ContentType : "json",
			dataType : "json",
			success : function(data){
					location.href = "./html/homePage.html";
			},
			error : function(error){
				alert("Invalid credentials provided.");
			}
		});
	}
});

function validateLogin(){
	
	let uNameError = $('#userNameError');
	let uPassEerror = $('#userPassError');

	let verifier = true;

	if ($('#loginUserName').val() == "")
	{
		uNameError.text(`Please provide your username`);
		verifier = false;
	}
	else
	{
		uNameError.text(``);
	}

	if ($('#loginUserPass').val() == "")
	{
		uPassEerror.text(`Please provide your password`);
		verifier = false;
	}
	else
	{
		uPassEerror.text(``);
	}

	return verifier;
}