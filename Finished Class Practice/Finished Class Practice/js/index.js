let submitButton = document.getElementById("submitButton");

submitButton.addEventListener("click", function(event){

	let name = document.getElementById("completeName");
	let nameError = document.getElementById("completeNameErrorMessage");
	if (name.value == ""){
		nameError.textContent = "Please type your name";
	}
	else{
		nameError.textContent = "";
	}

	let email = document.getElementById("email");
	let emailError = document.getElementById("emailErrorMessage");
	if (email.value == ""){
		emailError.textContent = "Please type your email";
	}
	else{
		if (validateEmail(email.value)){
			emailError.textContent = "";
		}
		else{
			emailError.textContent = "Please type a valid email";
		}
	}

	let password = document.getElementById("password");
	let passwordError = document.getElementById("passwordErrorMessage");
	if (password.value == ""){
		passwordError.textContent = "Please type your password";
	}
	else{
		passwordError.textContent = "";
	}

	let passwordConf = document.getElementById("passwordConf");
	let passwordConfError = document.getElementById("passwordConfErrorMessage");
	if (passwordConf.value == ""){
		passwordConfError.textContent = "Please type your password";
	}
	else{
		if(passwordConf.value != password.value){
			passwordConfError.textContent = "Passwords do not match";
	
		}
		else{
			passwordConfError.textContent = "";
		}
	}

	let radios = document.getElementsByName("gender");
	let genderError = document.getElementById("genderErrorMessage");

	let radioFlag = false;
	let i;
	for (i = 0; i < radios.length; i++) {
	    if (radios[i].checked) {
	        radioFlag = true;
	    }
	}

	if (radioFlag){
		genderError.textContent = "";
	}
	else{
		genderError.textContent = "Please select a gender";
	}

	let countrySelect = document.getElementById("country");
	let countryError = document.getElementById("countryErrorMessage");
	
	if (countrySelect.value == 0){
		countryError.textContent = "Please select a country";
	}
	else{
		countryError.textContent = "";
	}

});

function validateEmail(email) {
 		var regularExpression = /\S+@\S+\.\S+/;    
 	return regularExpression.test(email.toLowerCase());
}









