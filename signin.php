<?php
    //Check whether user is already signed in
    if ($_SESSION['signed_in']) {
        //If signed in, return to previous page or forum overview
        if ($_GET['view']){
            //If topic is set, get topic to return to.
            if ($_GET['topic']) {
                //return to specific topic
                header('Location:index.php?view=' . $_GET['view'] . '&topic=' . $_GET['topic']);
            } else {
                //return to the set view
                header('Location:index.php?view=' . $_GET['view']);
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
                </div>
                <div class="card-footer text-center"><a href="#">Click here to create an account.</a></div>
            </div>';
        } 
    }
?>