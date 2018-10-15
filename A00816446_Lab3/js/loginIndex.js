let loginButton = document.getElementById("loginSubmit");

loginButton.addEventListener("click",function(event){
	event.preventDefault();
	if (validateLogin()){
		location.href = "./html/homePage.html";
	}
});



function validateLogin(){
	let uName = document.getElementById("loginUserName");
	let uNameError = document.getElementById("userNameError");

	let uPass = document.getElementById("loginUserPass");
	let uPassEerror = document.getElementById("userPassError");

	let verifier = true;


	if (uName.value == "")
	{
		uNameError.textContent = "Please provide your username";
		verifier = false;
	}
	else
	{
		uNameError.textContent = "";
	}

	if (uPass.value == "")
	{
		uPassEerror.textContent = "Please provide your password";
		verifier = false;
	}
	else
	{
		uPassEerror.textContent = "";
	}

	return verifier;
}