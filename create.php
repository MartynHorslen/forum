<?php
    //Is user signed in?
    if(isset($_SESSION['signed_in']))
    {
        //Signed in, is $_GET['cat'] set?
        if(isset($_GET['cat'])){
            //Category is set. Search database for category information to display on form.
            $sql = $dbh->prepare("SELECT cat_name FROM categories WHERE cat_id = :cat_id");
            $sql->bindParam(':cat_id', $_GET['cat'], PDO::PARAM_INT);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            //*************************************** */
            //create an if form is submitted, check form and if errors, return form with original data and errors.
            //****************************************** */
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //Form Posted, should only see this if there is an error.
                $errors = array();
                //Check Username was posted and not empty
                if(!isset($_POST['topic_subject'])){
                    $errors[] = 'No topic title was submitted.';
                } else if ($_POST['topic_subject'] === ''){
                    $errors[] = 'Please give your topic a name.';
                }
                //Check user password was posted and not empty
                if(!isset($_POST['post_content'])){
                    $errors[] = 'No post content was submitted.';
                } else if ($_POST['post_content'] === ''){
                    $errors[] = 'Please fill in the opening post of your topic.';
                }
                if(!empty($errors)){
                    //redisplay form with user input
                    echo '<div class="row no-gutters mt-3">
                    <div class="col-md-10 col-lg-8 col-xl-8 offset-md-1 offset-lg-2 offset-xl-2">
                        <div class="card mb-2">
                            <div class="card-header text-center">
                                <h4>Create a topic in the <a href="index.php?view=cat&cat=' . $_GET['cat'] . '">' . $row['cat_name'] . ' forum</a>.</h4>
                            </div>
                            <div class="alert alert-danger mb-0" role="alert">
                            Uh-oh.. a couple of fields are not filled in correctly..
                            <ul>';
                            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
                            {
                                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
                            }
                            echo '</ul>
                            </div>
                            <div class="card-body text-center">
                                <form method="post" action="">
                                    <input type="hidden" id="user-id" name="user-id" value="' . $_SESSION['user_id'] . '" />
                                    <input type="text" id="topic_subject" class="" name="topic_subject" minlength="1" placeholder="Topic Title" value="' . $_POST['topic_subject'] . '">
                                    <input type="hidden" id="topic_cat" name="topic_cat" value="' . $_GET['cat'] . '"/>
                                    <textarea id="post_content" class="" name="post_content" minlength="1" placeholder="Write your message here..." rows="8">' . $_POST['post_content'] . '</textarea>
                                    <input type="button" class="btn btn-secondary btn-md w-50" value="Create topic" onclick="createTopic()"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
                } else {
                    //Random error?
                    echo 'Unknown error: Form posted and both fields were filled in. Need to investigate.';
                }
            } else {
            //Set up form to create category.
            echo '<div class="row no-gutters mt-3">
                <div class="col-md-10 col-lg-8 col-xl-8 offset-md-1 offset-lg-2 offset-xl-2">
                    <div class="card mb-2">
                        <div class="card-header text-center">
                            <h4>Create a topic in the <a href="index.php?view=cat&cat=' . $_GET['cat'] . '">' . $row['cat_name'] . ' forum</a>.</h4>
                        </div>
                        <div class="card-body text-center">
                            <form method="post" action="">
                                <input type="hidden" id="user-id" name="user-id" value="' . $_SESSION['user_id'] . '" />
                                <input type="text" id="topic_subject" class="" name="topic_subject" minlength="1" placeholder="Topic Title" required>
                                <input type="hidden" id="topic_cat" name="topic_cat" value="' . $_GET['cat'] . '"/>
                                <textarea id="post_content" class="" name="post_content" minlength="1" placeholder="Type your message here..." rows="8"></textarea>
                                <input type="button" class="btn btn-secondary btn-md w-50" value="Create topic" onclick="createTopic()" required/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
            }
        } else {
            //category not set. redirect back to home page.
        }
    } else {
        //Not Signed in, redirect back to category overview.
    }
?>