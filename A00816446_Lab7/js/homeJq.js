$('#newPostButton').on("click", function (argument) {
	addContent();
});

$('#cancelImage').on("click",function (argument) {
	relod();
})

function addContent() {
	let jsonToSend = {
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
}

function relod() {
	$('#userNewPic').val(``);
}