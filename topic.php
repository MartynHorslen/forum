<?php
    //Get topic ID from GET and query database for posts.
    $sql = $dbh->prepare("SELECT topic_subject, topic_cat FROM topics WHERE topic_id = :topic_id");
    $sql->bindParam(':topic_id', $_GET['topic'], PDO::PARAM_INT);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);

    //Get parent category to provide a return link
    $category = $dbh->prepare('SELECT cat_name FROM categories WHERE cat_id = ' . $result['topic_cat']);
    $category->execute();
    $category = $category->fetch(PDO::FETCH_ASSOC);

    //Check for topics
    if($result === 0){
        echo 'No topics defined yet.';
    } else { 
        //Create bootstrap card/table structure and Topic header.
        echo '<div class="my-2 py-1 px-4"><p>Back to <a href="index.php?view=cat&cat=' . $result['topic_cat'] . '">' . $category['cat_name'] . ' forum</a></p>
            <h4>Topic: ' . $result['topic_subject'] . '</h2></div>';

        //display each post on topic
        $sql = $dbh->prepare("SELECT posts.post_id, posts.post_topic, posts.post_content, posts.post_date, posts.post_by, users.user_id, users.user_name FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE posts.post_topic = :topic_id");
        $sql->bindParam(':topic_id', $_GET['topic'], PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        //Post bootstrap card/table template
        //prepare the table
        echo '<div class="card mb-2">
        <div class="row no-gutters">
            <div class="col-3">
                <div class="card-header">
                    Posted By
                </div>
            </div>
            <div class="col-9">
                <div class="card-header">
                    Post
                </div>
            </div>
        </div>';

        //posts
        foreach($result as $post){
            echo '<div id="post-' . $post['post_id'] . '" class="row">
                            <div class="col-3">
                                <div class="card-body">  
                                '. $post['user_name'] . '<br />' . $post['post_date'] . '
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card-body px-1">
                                    ' . $post['post_content'] . '
                                </div>
                            </div>
                        </div>';
        }
        echo "</div>";
        //reply form if user is logged in.
        if (isset($_SESSION['signed_in'])){
            echo '<div class="card text-center p-2"><form method="post" action="">
            <input type="hidden" id="user-id" name="user-id" value="' . $_SESSION['user_id'] . '" />
            <input type="hidden" id="topic-id" name="topic-id" value="' . $_GET['topic'] . '"/>
            <textarea class="w-70" id="reply-content" name="reply-content" rows="6"></textarea>
            <input type="submit" class="btn btn-sm btn-primary w-40" value="Submit reply" onclick="reply()"/>
            </form></div>';
            }
    }
?>