<?php
    //first select the category based on $_GET['cat']
    $cat_id = $_GET['cat'];

    //prepare statement
    $sql = $dbh->prepare("SELECT cat_id, cat_name, cat_description FROM categories WHERE cat_id = :cat_id");

    //bind the paramaters
    $sql->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);

    //execute the prepared statement
    $sql->execute();
    $result = $sql->fetchAll();

    if(count($result) === 0){
        echo 'No categories defined yet.';
    } else {     
        // Loop through each category counting number of topics and getting the category ID
        foreach($result as $catRow) {
            echo '<div class="my-2 py-1 px-4"><h4>Category: ' . $catRow['cat_name'] . '</h4> ' . $catRow['cat_description'] . '</div>';
        }
        
        //Get category topics and the users who created them.
        $sql = $dbh->prepare("SELECT topics.topic_id, topics.topic_subject, topics.topic_date, topics.topic_cat, topics.topic_by, users.user_id, users.user_name FROM topics LEFT JOIN users ON topics.topic_by = users.user_id WHERE topic_cat = :cat_id ORDER BY topic_date DESC");
        $sql->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->fetchAll();

        if (!$result){
            echo 'Error searching database';
        } else if (count($result) === 0) {
            echo 'No topics defined yet.';
        } else {

            //prepare the bootstrap cards/table structure
            echo '
            <div class="card mb-2">
                <div class="row no-gutters">
                    <div class="col-6">
                        <div class="card-header">
                            Topic
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="card-header">
                            Replies
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card-header">
                            Last Message
                        </div>
                    </div>
                </div>';

                //For each topic...
                foreach($result as $topic) {
                    //Build the card to show topic, username, time posted and how many posts are on that topic.
                    
                    echo '<div class="row">
                            <div class="col-6">
                                <div class="card-body py-2">
                                    <a href="index.php?view=topic&topic=' . $topic['topic_id'] . '">
                                        ' . $topic['topic_subject'] . '
                                    </a><br />
                                    By ' . $topic['user_name'] . ', 
                                    ' . date("F j Y, g:i a", strtotime($topic['topic_date'])) . ' <h3>
                                </div>
                            </div>';

                            //count posts
                            $sql = $dbh->prepare("SELECT * FROM posts WHERE post_topic = :topic_id");
                            $sql->bindParam(':topic_id', $topic['topic_id'], PDO::PARAM_INT);
                            $sql->execute();
                            $numOfPosts = count($sql->fetchAll());

                            echo '<div class="col-2">
                                <div class="card-body py-2 px-1">
                                    Replies: ' . $numOfPosts . '
                                </div>
                            </div>';

                            
                            //get username and date of last reply on this topic
                            $sql = $dbh->prepare("SELECT posts.post_date, users.user_id, users.user_name FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE post_topic = :topic_id ORDER BY post_date DESC LIMIT 1 ");
                            $sql->bindParam(':topic_id', $topic['topic_id'], PDO::PARAM_INT);
                            $sql->execute();
                            $last_post = $sql->fetchAll();

                            if ($last_post){
                            echo'<div class="col-4">
                                <div class="card-body py-2 px-0">
                                    By ' . $last_post[0]['user_name'] . '<br />
                                    ' . date("F j Y, g:i a", strtotime($last_post[0]['post_date'])). '
                                </div>
                            </div>';
                            }    
                            echo '</div>'; 
                } 
            echo '</div>';
        }
    }


    


?>