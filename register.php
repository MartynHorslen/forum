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

                //check username and email isn't taken.
                $sql = $dbh->prepare("SELECT `user_name` FROM users WHERE `user_name` = :username");
                $sql->bindParam(':username', $_POST['user_name'], PDO::PARAM_STR);
                if ($sql->execute()){
                    $errors[] = 'Username already taken. Please choose a new username.';
                }

                $sql = $dbh->prepare("SELECT `user_email` FROM users WHERE `user_email` = :email");
                $sql->bindParam(':email', $_POST['user_email'], PDO::PARAM_STR);
                if ($sql->execute()){
                    $errors[] = 'Email already is use. Please use the "Find Username" or "Reset Password" options.';
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
                                    <input type="username" class="form-control text-center" id="user_name" name="user_name" value="' . $_POST['user_name'] . '" placeholder="' . $_POST['user_name'] . '">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control text-center" id="user_pass" name="user_pass" value="' . $_POST['user_pass'] . '" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control text-center" id="user_pass_check" name="user_pass_check" value="' . $_POST['user_pass_check'] . '" placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control text-center" id="user_email" name="user_email" value="' . $_POST['user_email'] . '" placeholder="' . $_POST['user_email'] . '">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="register-button"  class="btn btn-secondary btn-md w-100">Register!</button>
                                </div>
                            </form>
                        </div>
                    </div>';
                } else {
                    //Register user.                    

                    //Create a random email verification hash
                    $hash = md5( rand(0,1000) ); // Example output: f4552671f8909587cf485ea990207f3b
                    $date = date("Y-m-d H:i:s");
                    $user_level = 0;

                    $sql = $dbh->prepare("INSERT INTO
                        users(`user_name`, user_pass, user_email, user_date, user_level, `hash`)
                    VALUES(:username, :userpass, :useremail, :userdate, :userlevel, :userhash)");

                    $sql->bindParam(':username', $_POST['user_name'], PDO::PARAM_STR);
                    $sql->bindParam(':userpass', $_POST['user_pass'], PDO::PARAM_STR);
                    $sql->bindParam(':useremail', $_POST['user_email'], PDO::PARAM_STR);
                    $sql->bindParam(':userdate', $date);
                    $sql->bindParam(':userlevel', $user_level, PDO::PARAM_INT);
                    $sql->bindParam(':userhash', $hash, PDO::PARAM_STR);

                    if ($sql->execute()){
                        //Success
                        //send verification email

                        $to      = $_POST['user_email']; // Send email to our user
                        $subject = 'Mch123s Forum Registration | Verification'; // Give the email a subject 
                        $message = 'Thanks for registering to mch123s forum!' . "\n" . 'Your account has been created and you can login with the following username. Please use the link below to verify your email address.' . "\n\n" . '------------------------' . "\n" . 
                        'Username: '. $_POST['user_name'] .'' . "\n" . 
                        '------------------------' . "\n\n" . 
                        'Verification link:' . "\n" . 
                        'http://www.mch123.x10host.com/index.php?view=verify&email='.$to.'&code='.$hash.'
                        
                        '; //Our message above including the link
                                            
                        $headers = 'From:noreply@mch123.x10host.com' . "\r\n"; // Set from headers
                        //Send email
                        mail($to, $subject, $message, $headers);

                        //redirect
                        header('Location:index.php?alert=registered');
                
                    } else {
                        echo 'There has been an error. Please try again later. <br />';                        
                        echo $sql->errorcode();
                    }
                    
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