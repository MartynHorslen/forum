<div class="card my-2 p-2">
<?php 
    //Get a list of forum categories
    $sql = "SELECT cat_id, cat_name, cat_description FROM categories ORDER BY cat_order ASC";
    $categories = fetchAllData($sql);
    
    //Catch empty category table and query error
    if(!$categories)
    {
        echo 'The categories could not be displayed, please try again later.';
    }
    else
    {
        if(count($categories) === 0)
        {
            echo 'No categories defined yet.';
        }
        else
        {     
            // Loop through each category counting number of topics and getting the category ID
            foreach($categories as $catRow) {
                $cat_id = $catRow['cat_id'];
                $sql = "SELECT * FROM topics WHERE topic_cat = ' $cat_id '";
                $topics = fetchAllData($sql);
                $numOfTopics = count($topics);

                //Loop through the topics counting the number of posts and topic ID
                $numOfPosts = 0;
                foreach($topics as $topicRow) {
                    $topic_id = $topicRow['topic_id'];
                    $sql = "SELECT * FROM posts WHERE post_topic = ' $topic_id '";
                    $posts = fetchAllData($sql);
                    $numOfPosts += count($posts);
                }

                //Select the latest topic from this category and join with user details ready to be displayed on the forum overview
                $sql = "SELECT topics.topic_subject, topics.topic_by, topics.topic_date, users.user_id, users.user_name FROM topics LEFT JOIN users ON topics.topic_by = users.user_id WHERE topics.topic_id = $topic_id Order By topic_date LIMIT 1";
                $lastTopic = $dbh->prepare($sql);
                $lastTopic->execute();
                $lastTopic = $lastTopic->fetch();

                //Create the forum overview structure and include category names, latest topic, date, username and also topic and reply counts with url links to relevant user and post pages.
                echo '<div class="card mb-2">
                    <div class="card-header px-3">
                        <h5 class="mb-0"><a href="index.php?view=cat&cat=' . $catRow['cat_id'] . '">' . $catRow['cat_name'] . '</a></h5>
                    </div>
                    <div class="row">
                        <div class="col-9 col-sm-8">
                            <div class="card-body py-0 px-2">
                                ' . $catRow['cat_description'] . '
                            </div>
                            <div class="card-body py-0 px-2">
                                Latest Topic: <a href="index.php?view=topic&topic=' . $topic_id . '">' . $lastTopic['topic_subject'] . '</a> posted by <a href="#">' . $lastTopic['user_name'] . '</a> 
                            </div>
                            <div class="card-body py-0 px-2">
                                Posted at ' . date("F j, Y, g:i a", strtotime($lastTopic['topic_date'])) . '
                            </div>
                        </div>
                        <div class="col-3 col-sm-4">
                            <div class="row">
                                <div class="col col-sm-6 py-2">
                                    <div class="card-body py-0 px-2 text-center">
                                        ' . $numOfTopics . '
                                    </div>
                                    <div class="card-body py-0 px-2 text-center">
                                        Topics
                                    </div>  
                                </div>
                                <div class="col col-sm-6 py-2">              
                                    <div class="card-body py-0 px-2 text-center">
                                        ' . $numOfPosts . '
                                    </div>
                                    <div class="card-body py-0 px-2 text-center">
                                        Posts
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                
                
                </div>
            </div>';
            }
        }
    }
?>
</div>