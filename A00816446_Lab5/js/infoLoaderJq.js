$.ajax({
	url : '../assets/profileData.json',
	type : 'GET',
	dataType : 'json',
	success : function(data){
		let newHtml = ``;

		newHtml += `<p id="userName">${data.username}</p>
		<p id="fName">${data.name.firstName}</p>
		<p id="lName">${data.name.lastName}</p>
		<p id="eMail">${data.email}</p>
		<p id="gender">${data.gender}</p>
		<p id="country">${data.country}</p>`;

		$('#userAccountInfo').append(newHtml);
	},
	error : function(errorMsg){
		console.log(errorMsg);
	}
});