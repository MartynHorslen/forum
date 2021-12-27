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
            header('Location:index.php');
        }
    } else {
        //Check whether the login form has been submitted

            //If submitted, check login information
                //Form Validation

                //Check database
                    //Hash the password before querying DB
                    //If correct, set session information and return user to previous page with login notification.

                    //Else display errors and increment a login counter (Basic $session counter or advanced IP, Username, datetime tracked in DB).

            //Else display the form and registration link.
    }
?>