<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php
    if(isset($_POST['submit'])){
        
            //validations
            $required_fields = array('email','password');
            validate_has_presense($required_fields,0);
        
        if(empty($errors)){
            
            $email = filter($_POST['email']);
            $password = filter($_POST['password']);

            $found_user = login_attempt($email,$password);
            
            if($found_user){
                //Success
                $_SESSION['user_id'] = $found_user['id'];
                $_SESSION['email'] = $found_user['email'];
                redirect_to("index.php");
            }else{
                //Failure
                $_SESSION["errors"] = "<strong>Username/Password</strong> not found";
            }
        }
        
        
        
    }
?>
<?php get_header("Doctor Login");  ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <?php echo errors();?>
                    <form role="form" method="POST" action="login.php">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>

                            <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php');  ?>