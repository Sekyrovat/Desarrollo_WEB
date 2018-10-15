$('#newPostButton').on("click", function (argument) {
	addContent();
});

$('#cancelImage').on("click",function (argument) {
	relod();
})

function addContent() {
	let jsonToSend = {
		"userId" : 1,
		"newInput" : $('#newPostText').val(),
		"newImage" : $('#userNewPic').val()
	};
	$.ajax({
		url : "../data/newPostPHP.php",
		type : "POST",
		data : jsonToSend,
		ContentType : "json",
		success : function(data) {
			console.log(data);
			location.reload();
		},
		error : function(err) {
			alert(err.responseText);
			console.log(err);
		}
	});
	/* 
		We declare a variable where we will place everything 
		the user inputs after being validated.
	*/
	// let newPostHtml = "\t<section class='cards'>\n<h3 name='user' class='postOwner'>You</h3>";

	/*
		In this section we put everything together, although
		we are using '""' it is done so because "``" proved to
		not work, therefore a different approach had to be taken.
	*/
	/*if (newImage == "" && newInput != "") {
		newPostHtml += "\t\t<p name='text' class='postText'>\n\t\t\t"+
							newInput
						+"\n\t\t\</p>\n";
		newPostHtml += "\t</section>\n";
		$('#mainContent').prepend(newPostHtml);	
	} else if(newImage != "" && newInput != ""){
				newPostHtml += "\t\t<img src='"+newImage+"' name='image' class='postImage'>"+
						"\t\t<p name='text' class='postText'>\n\t\t\t"+
							newInput
						+"\n\t\t\</p>\n";
			newPostHtml += "\t</section>\n";
			$('#mainContent').prepend(newPostHtml);
	}else if(newImage != "" && newInput == ""){
		newPostHtml += "\t\t<img src='"+newImage+"' name='image' class='postImage'>";
		newPostHtml += "\t</section>\n";
		$('#mainContent').prepend(newPostHtml);					
	}*/

	/*
		It's worth noting that this is only applicable while no DB,
		and no back end code is present. Once backend is used, ajax
		or some other form of sending and retriving data wil be in place.
		And it should follow the next logic:
			1.-User inputs data
			2.-Data is cleaned, processeced, verified
			3.-Data is sent to the server
			4.-Server verifies the recived data as weell as performing
			a second cleaning of data.
			5.-Server stores imgs in file system under a specific folder,
			and text on a database.
			6.-Data is stored on the server, and the poster sees it 
			displayed after the server sends an "all good" message,
			indicating that the input is safe.
			7.-Friends of the user will see the new post while browsing,
			since the page gets posts dynmically from the server. 
	*/
}

function relod() {
	$('#userNewPic').val(``);
}