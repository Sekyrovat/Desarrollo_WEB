let jsonToSend = {
	"action" : "GET_POSTS"
	};

$(document).ready(function () {
	$.ajax({
	    url : "../data/applicationLayer.php",
	    type : "GET",
		data : jsonToSend,
		ContentType : "json",
	    dataType : "json",
	    success : function(data){
	    	if (data['code'] === 406)
	    	{
	    		window.location.replace("../index.html");
	    	}
	    	
	    	newData = data['response'];

			let newHtml = "";

			let posterId = "";
			let newText = "";
			let newImage = "";
			let posterUserName = "";
			let posterProfilePic = "";

			for(var i = 0; i<newData.length; ++i)
			{
				posterId = newData[i].posterId;
				newText = newData[i].postText;
				newImage = newData[i].postImage;
				posterUserName = newData[i].posterUserName;
				posterProfilePic = newData[i].posterProfilePic;


				if(newText != "" && newImage != "")
				{
					newHtml +=  `<label class="modalCaller">
									<!--vwesvwe -->
									<section class='cards'> 
										<h3 name='user' class='postOwner'> ${posterUserName} </h3>
										<img src="${posterProfilePic}" class="userProfilePic">
										<img src='${newImage}' name='image' class='postImage'>
										<br>
										<p name='text' class='postText'>
											${newText}
										</p>
									</section>
								 </label>`;
				}
				else if (newText == "" && newImage != "")
				{
					newHtml +=  `<label class="modalCaller">
									<section class='cards'>
										<h3 name='user' class='postOwner'> ${posterUserName} </h3>
										<img src="${posterProfilePic}" class="userProfilePic">
										<img src='${newImage}' name='image' class='postImage'>
									</section>
								</label>`;
				}
				else if(newText != "" && newImage == "")
				{
					newHtml += `<label class="modalCaller">
									<section class='cards'>
										<h3 name='user' class='postOwner'> ${posterUserName} </h3>
										<img src="${posterProfilePic}" class="userProfilePic">
										<br>
										<p name='text' class='postText'>
											${newText}
										</p>
									</section>
								</label>`;
				}
			};
			$('#mainContent').append(newHtml);
	    },
	    error : function(err){
	    	console.log(err);
	    }
	});
});