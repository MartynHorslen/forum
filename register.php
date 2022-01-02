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
            //Prepare array to collect errors. This will be more useful for registration but still worth doing here.
            $errors = array();

            //Check is sign in form was posted. May have other forms on page that could be submitted so need to check its the right form.
            if (isset($_POST['register-button'])){
                //Check Username was posted and not empty
                if(!isset($_POST['user_name'])){
                    $errors[] = 'The username field was not posted.';
                } else if ($_POST['user_name'] === ''){
                    $errors[] = 'The username field cannot be empty.';
                }
                //Check user password was posted and not empty
                if(!isset($_POST['user_pass'])){
                    $errors[] = 'The password field was not posted.';
                } else if ($_POST['user_pass'] === ''){
                    $errors[] = 'The password field cannot be empty.';
                }
                //Check password confirmation was posted and not empty
                if(!isset($_POST['user_pass_check'])){
                    $errors[] = 'The confirm password field was not posted.';
                } else if ($_POST['user_pass_check'] === ''){
                    $errors[] = 'The confirm password field cannot be empty.';
                }
                //Check email address was posted and not empty
                if(!isset($_POST['user_email'])){
                    $errors[] = 'The email field was not posted.';
                } else if ($_POST['user_email'] === ''){
                    $errors[] = 'The email field cannot be empty.';
                }
                //Check if passwords match
                if($_POST['user_pass'] != $_POST['user_pass_check']){
                    $errors[] = 'The password and confirmation password do not match.';
                }

                //If errors, display them and redisplay form with red error border.
                if(!empty($errors)){
                    echo '<div class="card border-danger mb-3 m-auto" style="max-width: 28rem;">
                        <div class="card-header">Registration:</div>';

                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
                        echo '<ul>';
                        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
                        {
                            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
                        }
                        echo '</ul>';
                        echo '</div>';

                        echo '<div class="card-body text-secondary">
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
                } else {
                    //check details against database and register user.
                    echo 'Registered.';
                    
                }
            }
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