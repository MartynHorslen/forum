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
            //process form
            echo 'form processing...';
        } else {
            //Display form
            echo '<div class="card border-secondary mb-3 m-auto" style="max-width: 28rem;">
                <div class="card-header">Registration:</div>
                <div class="card-body text-secondary">
                    <form class="" method="post" action="">
                        <div class="form-group">
                            <input type="username" class="form-control text-center" id="user_name" name="user_name" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control text-center" id="user_pass" name="user_pass" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control text-center" id="user_pass_check" name="user_pass_check" placeholder="Confirm Password">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control text-center" id="user_email" name="user_email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="register-button"  class="btn btn-secondary btn-md w-100">Register!</button>
                        </div>
                    </form>
                </div>
            </div>';
        }
    }
?>