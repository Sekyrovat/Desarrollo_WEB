$('#submitButton').on('click', function(event){
	
	let $completeName = $('#completeName');
	let $completeNameError = $('#completeNameErrorMessage');
	
	if($completeName.val() == ""){
		$completeNameError.removeClass('hideElement');
	}
	else{
		$completeNameError.addClass('hideElement');
	}

	let $email = $('#email');
	let $emailError = $('#emailErrorMessage');
	let $emailerror2 = $('#emailErrorMessage2');
	
	if($email.val() == ""){
		$emailError.removeClass('hideElement');
		$emailerror2.addClass('hideElement');
	}
	else{
		$emailError.addClass('hideElement');

		if (! validateEmail($email.val()) ){
			$emailerror2.removeClass('hideElement');
		}
		else{
			$emailerror2.addClass('hideElement');
		}
	}

	let $password = $('#password');
	let $passwordConf = $("#passwordConf");
	let $passwordError = $('#passwordErrorMessage');
	let $passwordConfError = $('#passwordConfErrorMessage');
	let $passwordMismatchError = $('#passwordMismatchErrorMessage');
	let bFlag1 = false;
	let bFlag2 = false;

	if ($password.val() == ""){
		$passwordError.removeClass('hideElement');
		bFlag1 = false;
	}
	else{
		$passwordError.addClass('hideElement');
		bFlag1 = true;
	}

	if ($passwordConf.val() == ""){
		$passwordConfError.removeClass('hideElement');
		bFlag2 = false;
	}
	else{
		$passwordConfError.addClass('hideElement');
		bFlag2 = true;
	}

	if (bFlag1 && bFlag2){
		if ($password.val() != $passwordConf.val()){
			$passwordMismatchError.removeClass('hideElement');
		}
		else{
			$passwordMismatchError.addClass('hideElement');
		}
	}

	let $country = $('#country');
	let $countryError = $('#countryErrorMessage');

	if ($country.val() == 0){
		$countryError.removeClass('hideElement');
	}
	else{
		$countryError.addClass('hideElement');
	}

	let $genderError = $('#genderErrorMessage');
	if ($('input[name=gender]').is(':checked')){
		$genderError.addClass('hideElement');
	}
	else{
		$genderError.removeClass('hideElement');
	}

});

$('#menu > li').on('click', function(event){
	
	$('.selectedNavElement').removeClass('selectedNavElement');

	let $currentElement = $(this);
	let sectionName = $currentElement.attr('class');

	
	$currentElement.addClass('selectedNavElement');

	$('section').addClass('hideElement');

	
	$('#' + sectionName + '-section').removeClass('hideElement');
	$(`#${sectionName}-section`)
});

$.ajax({
	url : './assets/contacts.json',
	type : 'GET',
	dataType : 'json',
	success : function(data){
		let newHtml = "";

		for (let i = 0; i < data.contacts.length; i ++){
			newHtml += ` <div class="contactCard">
							<h2>${data.contacts[i].fName} ${data.contacts[i].lName} </h2>
							<p> ${data.contacts[i].description}</p>
						 </div>
						`;
		}

		$('#contact-section').append(newHtml);
	},
	error : function(errorMsg){
		console.log(errorMsg);
	}
});

function validateEmail(email) {
 	let regularExpression = /\S+@\S+\.\S+/;    
 	return regularExpression.test(email.toLowerCase());
}



