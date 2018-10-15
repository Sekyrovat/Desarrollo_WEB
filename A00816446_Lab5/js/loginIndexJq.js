$('#loginSubmit').on("click",function(event){
	event.preventDefault();
	if (validateLogin()){
		window.location.replace(`./html/homePage.html`);
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
	if ($('#loginUserPass').val() != "lab3")
	{
		uPassEerror.text(`Invalid password`);
		verifier = false;
	}
	else
	{
		uPassEerror.text(``);
	}

	return verifier;
}