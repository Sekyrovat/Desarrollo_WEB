$.ajax({
    url : `../assets/comments.xml`,
    type : `GET`,
    dataType : `xml`,
    success : function(data){
        let newHtml = "";

        let poster = "";
        let newText = "";
        let newImage = "";

        $(data).find('contact').each(function(){
            
            poster = $(this).find('name').attr('username');
            newText = $(this).find('text').text();
            newImage = $(this).find('image').text();

            if(newText != "" && newImage != "NULL")
            {
                newHtml +=  `<section class='cards'> 
                                <h3 name='user' class='postOwner'> ${poster} </h3>
                                <img src='${newImage}' name='image' class='postImage>
                                <p name='text' class='postText'>
                                    ${newText}
                                </p>
                            </section>`;
            }
            else if (newText == "" && newImage != "NULL")
            {
                newHtml +=  `<section class='cards'>
                                <h3 name='user' class='postOwner'> ${poster} </h3> 
                                <img src='${newImage}' name='image' class='postImage>
                            </section>`;
            }
            else if(newText != "" && newImage == "NULL")
            {
                newHtml += `<section class='cards'>
                                <h3 name='user' class='postOwner'> ${poster} </h3> 
                                <p name='text' class='postText'>
                                    ${newText}
                                </p>
                            </section>`;
            }
        });
        $('#mainContent').prepend(newHtml);
    },

    error : function(err) {
        console.log(err);
    }
});  