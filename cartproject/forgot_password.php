<?php
include "classes/users.php";
$Obj = new Users();

$Obj->addCss('style1.css');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('script1.js');

include "resources/layout/header.php";

if(isset($_SESSION['logged_in'])){
    if($_SESSION['logged_in'] == true){
        header("Location: user_home.php");
    }
}

if($_POST != null){
    if($_POST['form_type'] == "forgot_password"){
        $Obj->forgotPassword($_POST);  
    }
}
?>

<div class="main">
    <div class="title">
        <h2>PHP Cart</h2>
        <a class="white-text" href="user_home.php">Take a tour</a>
    </div>
    <div class="admin_signin" style="width: 300px;">
        <div class="content">
        <h3>Forgot Password</h3>
        <form name="forgot_password" method="POST" action="">
            <?php echo $Obj->getFlashData("error"); ?>
            	<input type="hidden" name="form_type" value="forgot_password" required/>
				<input type="email" class="text-box" name="email" placeholder="Email" /><br/>
				<input class="button" type="submit" value="Submit" />

        </form>
        </div>
    </div>
    </div>
</div>

<?
include "resources/layout/footer.php";
?>