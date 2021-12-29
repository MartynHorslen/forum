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
            /********************************* */
            //Create a login attempt counter.
            /******************************** */


            /*********************************** */

            //Prepare array to collect errors. This will be more useful for registration but still worth doing here.
            $errors = array();

            //Check is sign in form was posted. May have other forms on page that could be submitted so need to check its the right form.
            if (isset($_POST['sign-in-button'])){
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
                

                //If errors, display them and redisplay form with red error border.
                if(!empty($errors)){
                echo '<div class="card border-danger mb-3 m-auto" style="max-width: 28rem;">
                    <div class="card-header">Login:</div>';

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
                } else {
                    //No errors, check username and password combination against database. Also hash and salt password for security.
                    //May need to sanitise and potentially filter for pattern/type at some point.
                    $user_pass = md5($_POST['user_pass']);
                    $sql = $dbh->prepare("SELECT user_id, user_name, user_level FROM users WHERE user_name = :user_name AND user_pass = :user_pass");
                    $sql->bindParam(':user_name', $_POST['user_name'], PDO::PARAM_STR);
                    $sql->bindParam(':user_pass', $user_pass, PDO::PARAM_STR);
                    $sql->execute();
                    $validated = count($sql->fetchAll());
                    if ($validated) {
                        //If correct, set session information and return user to previous page with login notification.
                        echo 'Logged in!';
                    } else {
                        //Else display errors and increment a login counter (Basic $session counter or advanced IP, Username, datetime tracked in DB).
                        echo 'Wrong username or password.';
                    }
                }
            }
            
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