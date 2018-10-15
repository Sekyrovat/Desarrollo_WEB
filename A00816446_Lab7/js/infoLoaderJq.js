$('#newPicSubmit').on("click",function(event){
	event.preventDefault();
	
});

$.ajax({
	url : '../data/loadProfileDataPHP.php',
	type : 'GET',
	dataType : 'json',
	success : function(data){
		let temp = "";

		const {username, userFiName, userLaName, userEmail, userCountry} = data;

		if (data.userGender == 0) 
		{
			temp = "Female";
		} 
		else 
		{
			temp = "Male";
		}

		let newHtml = ``;

		newHtml += `<p id="userName">${username}</p>
		<p id="fName">${userFiName}</p>
		<p id="lName">${userLaName}</p>
		<p id="eMail">${userEmail}</p>
		<p id="gender">${temp}</p>
		<p id="country">${userCountry}</p>`;

		$('#userAccountInfo').append(newHtml);
	},
	error : function(errorMsg){
		console.log(errorMsg);
	}
});