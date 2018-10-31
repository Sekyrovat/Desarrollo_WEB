$('#newPostButton').on("click", function (argument) {
	addContent();
});

$('#cancelImage').on("click",function (argument) {
	relod();
});

$('#logoutBtn').on("click",function (argument) {

	let jsonToSend = {
		"action" : "LOGOUT"
	};

	$.ajax({
		url : "../data/applicationLayer.php",
		type : "POST",
		data : jsonToSend,
		dataType : "json",
		ContentType : "json",
		success : function(data) {
			window.location.replace("../index.html");
		},
		error : function(err) {
			console.log(err);
		}
	});
});

function addContent() {
	let jsonToSend = {
		"newInput" : $('#newPostText').val(),
		"newImage" : $('#userNewPic').val(),
		"action" : "NEW_POST"
	};
	$.ajax({
		url : "../data/applicationLayer.php",
		type : "POST",
		data : jsonToSend,
		dataType : "json",
		ContentType : "json",
		success : function(data) {
			if (data.status === "success")
			{
				console.log(data);
				location.reload();
			}
		},
		error : function(err) {
			alert(err.responseText);
			console.log(err);
		}
	});
}

function relod() {
	$('#userNewPic').val(``);
}