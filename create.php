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
                                <input type="submit" class="btn btn-secondary btn-md w-50" value="Create topic" onclick="createTopic()" required/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
        } else {
            //category not set. redirect back to home page.
        }
    } else {
        //Not Signed in, redirect back to category overview.
    }
?>