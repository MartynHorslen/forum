<?php
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
?>