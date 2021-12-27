<?php
    //Check whether user is already signed in
    if (isset($_SESSION['signed_in'])) {
        //If signed in, return to previous page or forum overview
        if (isset($_GET['previous'])){
            //If topic is set, get topic to return to.
            if (isset($_GET['topic'])) {
                //return to specific topic
                header('Location:index.php?view=' . $_GET['previous'] . '&topic=' . $_GET['topic']);
            } else {
                //return to the set view
                header('Location:index.php?view=' . $_GET['previous']);
            }
        } else {
            //Return to forum overview because no view is set
            header('Location:index.php');
        }
    } else {
        //Check whether the login form has been submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //If submitted, check login information
                //Form Validation

                //Check database
                    //Hash the password before querying DB
                    //If correct, set session information and return user to previous page with login notification.

                    //Else display errors and increment a login counter (Basic $session counter or advanced IP, Username, datetime tracked in DB).
        } else {
            //Else display the form and registration link.
            echo '
            <div class="card border-secondary mb-3 m-auto" style="max-width: 28rem;">
                <div class="card-header">Login:</div>
                <div class="card-body text-secondary">
                    <form class="" method="post" action="">
                        <div class="form-group">
                            <input type="username" class="form-control text-center" id="user_name" name="user_name" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control text-center" id="user_pass" name="user_pass" placeholder="Password">
                        </div>
                        <div class="form-group"><button type="submit" class="btn btn-secondary btn-md w-100" name="sign-in-button">Sign In</button></div>
                    </form>
                </div>';

                // if/else logic to handle different links depending on what page to return to or to carry on to the registration page.
                if (isset($_GET['previous'])){
                    //If topic is set, get topic to return to.
                    if (isset($_GET['topic'])) {
                        //Carry specific topic to the register view and create return link to topic
                        echo '<div class="card-footer text-center"><a href="index.php?view=register&previous=' . $_GET['previous'] . '&topic=' . $_GET['topic'] . '">Click here to create an account.</a></div>';
                        echo '<div class="card-footer text-center"><a href="index.php?view=' . $_GET['previous'] . '&topic=' . $_GET['topic'] . '">Click here to return to previous page.</a></div>';
                    } else {
                        //carry non-topic view to register page or return to view
                        echo '<div class="card-footer text-center"><a href="index.php?view=register&previous=' . $_GET['previous'] . '">Click here to create an account.</a></div>';
                        echo '<div class="card-footer text-center"><a href="index.php?view=' . $_GET['previous'] . '">Click here to return to previous page.</a></div>';
                    }
                } else {
                    //Return to forum overview because no view is set
                    echo '<div class="card-footer text-center"><a href="index.php?view=register">Click here to create an account.</a></div>';
                    echo '<div class="card-footer text-center"><a href="index.php">Click here to return to previous page.</a></div>';
                }
            echo '</div>';
        } 
    }
?>