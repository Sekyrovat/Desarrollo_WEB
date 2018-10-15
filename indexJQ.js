$("#submitForm").on("click", function(event){
	event.preventDefault();

	let userNameError=$("#errorName");
	let userEmailError=$("#errorEmail");
	let userPasswordError=$("#errorPassword");
	let userPasswordError2=$("#errorPassword2");

	let userCountry=$("#userCountry");
	let userCountryError=$("#errorCountry");

	let genderRadios=$("#gender");
	let selectedFlag=false;
	let userGenderError=$("#errorGender");
	if($("#name").val()!=""){
		userNameError.text("");
	}else{
		userNameError.text("Please provide your name");
	}
	if($("#email").val()!=""){
		userEmailError.text("");
	}else{
		userEmailError.text("Please provide your email");
	}
	if($("#pass").val()!=""){
		userPasswordError.text("");
	}else{
		userPasswordError.text("Please provide your password");
	}
	if($("#passC").val()!=""){
		userPasswordError2.text("");
	}else{
		userPasswordError2.text("Please provide your password confirmation");
	}

	if(userCountry.val()==0){
		userCountryError.text("Please provide country");
	}else{
		userCountryError.text("");
	}

	for(let i=0; i<genderRadios.length; i++){
		if(genderRadios[i].val()){
			selectedFlag=true;
			break;
		}
	}
	if(selectedFlag){
		userGenderError.text("");
	}else{
		userGenderError.text("Provide Gender");
	}
});

$('#menu > li').on('click',function(event){
	let $currentElement=$(this);
	//Remove the class selected from the <li>
	$('.selected').removeClass('selected');
	//Add the class selected to the clicked <li>
	$($currentElement).addClass('selected');
	//Hide the previous <section> 
	$('main > section').addClass('hiddenElement'); //in a loop because main>section provide a list of elements to addclass
	//show the current <section> that has been clicked 
	let currentId = $($currentElement).attr('id');
	$('#'+currentId+'Section').removeClass('hiddenElement');
});

$.ajax({
	url: './assest/contacts.json',
	type: 'GET',
	dataType:'json',
	success: function(data){
		//console.log(data);
		let newHtml="";
		//full contanct file of json
		for(let i=0; i<data.contacts.length; i++){
			newHtml += `<div class="contactCard"> 
							<div class="contactName">
								${data.contacts[i].fName} 
								${data.contacts[i].LName}
							</div class="contactDescription">
								${data.contacts[i].description}
							</div>
						</div>`;
		}
		$('#mainContactContent').html(newHtml);
	},
	error : function(err){
		console.log(err);
	} 
});