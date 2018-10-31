$('#newPicSubmit').on("click",function(event){
	event.preventDefault();
	
});

let jsonToSend = {
	"action" : "GET_DATA"
}

$.ajax({
	url : '../data/applicationLayer.php',
	type : 'GET',
	data : jsonToSend,
	dataType : 'json',
	ContentType : 'json',
	success : function(data){

		if (data['code'] === 406)
    	{
    		window.location.replace("../index.html");
    	}

    	newData = data['response'];
	    	
		let temp = "";
		if (newData.userGender === 0) 
		{
			temp = "Female";
		} 
		else 
		{
			temp = "Male";
		}

		let newHtml = ``;

		newHtml = `<p id="userName">${newData.username}</p>
		<p id="fName">${newData.userFiName}</p>
		<p id="lName">${newData.userLaName}</p>
		<p id="eMail">${newData.userEmail}</p>
		<p id="gender">${temp}</p>
		<p id="country">${newData.userCountry}</p>`;

		$('#userAccountInfo').append(newHtml);
	},
	error : function(errorMsg){
		console.log(errorMsg);
	}
});