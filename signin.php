<?php
    //Check whether user is already signed in

        //If signed in, return to previous page or forum overview

        //Else
            //Check whether the login form has been submitted

                //If submitted, check login information
                    //Form Validation

                    //Check database
                        //Hash the password before querying DB
                        //If correct, set session information and return user to previous page with login notification.

                        //Else display errors and increment a login counter (Basic $session counter or advanced IP, Username, datetime tracked in DB).

                //Else display the form and registration link.
                
?>