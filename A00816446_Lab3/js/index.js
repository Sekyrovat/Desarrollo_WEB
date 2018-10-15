let registerBtn = document.getElementById("registerSubmit");
let resetButton = document.getElementById("resetBtn");

resetButton.addEventListener("click", function(event){
	relod();
});


registerBtn.addEventListener("click", function(event){
	event.preventDefault();
	if(validateRegistration() && validateRadioButtons() && validateDropDownMenu())
	{
		location.href = "./login.html"
	}
});

function validateRegistration() {
	let verifier = true;

	let fName = document.getElementById("registrationUserFname");
	let fNameError = document.getElementById("errorFName");

	let lName = document.getElementById("registrationUserLname");
	let lNameError = document.getElementById("errorLName");

	let uName = document.getElementById("registrationUserName");
	let uNameError = document.getElementById("errorUName");
	
	let uMail = document.getElementById("registrationUserEmail");
	let uMailError = document.getElementById("errorEmail");

	let uPass1 = document.getElementById("registrationUserPass1");
	let uPass1Error = document.getElementById("errorPass1");

	let uPass2 = document.getElementById("registrationUserPass2");
	let uPass2Error = document.getElementById("errorPass2");

	if (fName.value == "")
	{
		fNameError.textContent = "Please provide your name";
		verifier = false;
	}
	else
	{
		fNameError.textContent = "";
	}

	if (lName.value == "")
	{
		lNameError.textContent = "Please provide your last name";
		verifier = false;
	}
	else
	{
		lNameError.textContent = "";
	}

	if (uName.value == "")
	{
		uNameError.textContent = "Please provide a username";
		verifier = false;
	}
	else
	{
		uNameError.textContent = "";
	}

	if (uMail.value == "")
	{
		uMailError.textContent = "Please provide an email address";
		verifier = false;
	}
	else
	{
		uMailError.textContent = "";
	}
	if (uPass1.value == "")
	{
		uPass1Error.textContent = "Please provide a password";
		verifier = false;
	}
	else
	{
		uPass1Error.textContent = "";
	}
	if(uPass2.value != uPass1.value)
	{
		uPass2Error.textContent = "Passwords don't match";
		verifier = false;
	}
	else
	{
		uPass2Error.textContent = "";
	}

	return verifier;
}

function validateRadioButtons() {
	let genderRadios = document.getElementsByClassName("gender");
	let selectedFlag = false;
	let userGenderError = document.getElementById("errorGender");

	for (var i = 0; i < genderRadios.length; i++) {
		if (genderRadios[i].checked)
		{
			selectedFlag = true;
			break;
		}
	}

	if (selectedFlag)
	{
		userGenderError.textContent = "";
	} 
	else
	{
		userGenderError.textContent = "Please select a Gender";
	}

	return selectedFlag;
}

function validateDropDownMenu() {
	let userCountry = document.getElementById("natCountry");
	let userCountryError = document.getElementById("errorCountry");
	let selecFlag = false;

	if (userCountry.value == 0)
	{
		userCountryError.textContent = "Please select your coutnry";
	}
	else
	{
		userCountryError.textContent = "";
		selectedFlag = true;
	}
	return selectedFlag;
}

function relod(){
	let fName = document.getElementById("registrationUserFname");
	let fNameError = document.getElementById("errorFName");

	let lName = document.getElementById("registrationUserLname");
	let lNameError = document.getElementById("errorLName");

	let uName = document.getElementById("registrationUserName");
	let uNameError = document.getElementById("errorUName");
	
	let uMail = document.getElementById("registrationUserEmail");
	let uMailError = document.getElementById("errorEmail");

	let uPass1 = document.getElementById("registrationUserPass1");
	let uPass1Error = document.getElementById("errorPass1");

	let uPass2 = document.getElementById("registrationUserPass2");
	let uPass2Error = document.getElementById("errorPass2");

	fName.value = "";
	fNameError.textContent = "";
	lName.value = "";
	lNameError.textContent = "";
	uName.value = "";
	uNameError.textContent = "";
	uMail.value = "";
	uMailError.textContent = "";
	uPass1.value = "";
	uPass1Error.textContent = "";
	uPass2.value = "";
	uPass2Error.textContent = "";


	let genderRadios = document.getElementsByClassName("gender");
	let userGenderError = document.getElementById("errorGender");

	for (var i = 0; i < genderRadios.length; i++) {
		if (genderRadios[i].checked)
		{
			genderRadios[i].checked = false;
			break;
		}
	}
	userGenderError.textContent = "";

	let userCountry = document.getElementById("natCountry");
	let userCountryError = document.getElementById("errorCountry");

	userCountry[0].selectedIndex = 0;
	userCountryError.textContent = "";
}

function hideRegistration(){
	let registerForm = document.getElementById("registration");
	registerForm.style.display = "none";
}

