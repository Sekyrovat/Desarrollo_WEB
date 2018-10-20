$('#loginSubmit').on("click",function(event){
	event.preventDefault();
	if (validateLogin()){

		let jsonToSend ={
						"userName" : $("#loginUserName").val(),
						"userPassword" : $("#loginUserPass").val()
					};

		$.ajax({
			url : "./data/loginToAccountPHP.php",
			type : "POST",
			data : jsonToSend,
			ContentType : "json",
			dataType : "json",
			success : function(data){
				if (data.status === "success")
				{
					location.href = "./html/homePage.html";
					console.log(data);
				}
			},
			error : function(error){
				console.log(error);
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