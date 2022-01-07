function reply() {
    var replyContent = $("#reply-content").val();
    var userId = $("#user-id").val();
    var topicId = $("#topic-id").val();

    if (replyContent === "" )
    {
        alert("Please fill in the reply field");
    } else {
        $.ajax({
            async: true,
            type: 'POST',
            //cache: false,
            url: 'reply.php',
            data: {
                replyContent:replyContent,
                userId:userId,
                topicId:topicId
            },
            success: function(response) {
                console.log("Reply posted successfully");
            },
            error: function(response) {
                alert('Error: ', response);
            }
        });
    }
}

function createTopic() {
        var topicSubject = $("#topic_subject").val();
        var topicCat = $("#topic_cat").val();
        var postContent = $("#post_content").val();
        var userId = $("#user-id").val();

        if (topicSubject === "" || postContent === "" )
        {
            alert("Please fill in the fields");
        } else {
            $.ajax({
                async: true,
                type: 'POST',
                //cache: false,
                url: 'create_topic.php',
                data: {
                    userId:userId,
                    topicSubject:topicSubject,
                    topicCat:topicCat,
                    postContent:postContent
                },
                success: function(response) {
                    if (response === 'first'){
                        alert('topic error.');
                    } else if (response === 'second'){
                        alert('post error.');
                    } else {
                        window.location.href = `index.php?view=topic&topic=${response}`;
                    } 
                },
                error: function(response) {
                    alert('Error: ', response);
                }
            });
        }
}