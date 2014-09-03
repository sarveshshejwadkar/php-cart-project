<?php
include "classes/users.php";

$Obj = new Users();

$Obj->addCss('style1.css');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('script1.js');
$Obj->addJs('index.js');

include "resources/layout/header.php";

if(isset($_SESSION['user'])){
    header("Location: user_home.php");
}

if($_POST != null){
    if($_POST['form_type'] == "registration"){
        $Obj->addUser($_POST);  
    }elseif($_POST['form_type'] == "signin"){
        $Obj->signIn($_POST);
    }
}
?>

<div class="main">   
    <div class="title">
        <h2>PHP Cart</h2>
        <a class="white-text" href="user_home.php">Take a tour</a>
    </div>
    <div class="signup">
        <div class="content" style="width: 70%;">
        <h3>Sign Up</h3>
        <form name="signup" id="signup" method="POST" action="index.php">
            <?php echo $Obj->getFlashData("cerror"); ?>
            <input type="hidden" name="form_type" value="registration" required />
            
            <input class="text-box" type="email" name="email" placeholder="Email" id="email" required />
            	<span id="email_checker_ajax" class="error"></span>
                <span id="email_checker" class="error"></span>
            
            <br/><input class="text-box" type="text" name="fname" placeholder="First Name" id="fname" required />
                 	<span id="fnameCheck" class="error"></span>    
            
            <br/><input class="text-box" type="text" name="lname" placeholder="Last Name" id="lname" required />
                 	<span id="lnameCheck" class="error"></span>    
            
            <br/><input class="text-box" type="password" name="password" placeholder="Password" id="pass" required />
                 	<span id="passwordLength" class="error"></span>    
                    
            <br/><input class="text-box" type="password" name="cpassword" placeholder="Confirm Password" id="cpass" required />
                 	<span id="passwordMatch" class="error"></span>
                  
            <br/><img src="resources/library/captcha/captcha.php" id="captcha" /><br/>
                 	<div onclick="
                         document.getElementById('captcha').src='resources/library/captcha/captcha.php?'+Math.random();
                         document.getElementById('captcha-form').focus();"
                         id="change-image">
                         Not readable? Change text.
                     </div><br/>
                     <input class="text-box" type="text" name="captcha" id="captcha-form" autocomplete="off" placeholder="Enter above text" required/>
                    
                    
             <br/><input class="button button-large" type="submit" value="Sign Up" id="submitsu" /></td>
                
        </form>
        </div>
    </div>
    
    <div class="signin">
        <div class="content" style="width: 70%;">
            <h3>Sign In</h3>
            <form name="signin" method="POST" action="">
                <?php echo $Obj->getFlashData("signin_error"); ?>
                <input type="hidden" name="form_type" value="signin" required />
                
                <input class="text-box" type="email" name="email" id="semail" placeholder="Email" required/>
                	<span id="siemail" class="error"></span>
                
                <br/><input class="text-box" type="password" name="password" id="spass" placeholder="Password" id="pass" required />
                	<span id="sipass" class="error"></span>
                
                <br/><input class="button button-large" type="submit" value="SignIn" /></td>
                    
                <br/><a href="forgot_password.php">Forgot Password?</a></td>
                
            </form>
        </div>
    </div>

</div>

<?
include "resources/layout/footer.php";
?>