$.ajax({
	url : "./data/sessionService.php",
	type : "GET",
	dataType: "json",
	success : function (data) {
		$('.userFullName').text(`${data.fName} ${data.lName} ${data.user}`);
	},
	error : function (err) {
		console.log(err);
		// If we got an error we redirect to home.
		alert(err.responseText);
		$(location).attr('href', './index.html')
	}
});

$('#logoutButton').on("click", function() {
	$.ajax({
		url : "./data/logoutService.php",
		type : "GET",
		success : function (data) {
			console.log("Done");
			$(location).attr('href', './index.html')
		},
		error : function (err) {
			console.log(err);
		}
	});
});