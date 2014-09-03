<?php
include "classes/admin.php";

$Obj = new Admin();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('index.js');

include "resources/layout/header.php";

if($_SESSION['isAdmin'] == true){
    header("Location: admin_home.php");
}

if($_POST != null){
    if($_POST['admin'] == "login"){
        $Obj->signIn($_POST);
    }
}
?>

<div class="main">
    <div class="title">
    	<h1>PHP Cart Admin</h1>
    </div>
    <div class="admin_signin" style="width:300px;">
        <div class="content">
            <h3>Admin Sign In</h3>
            <form name="signin" method="POST" action="">
                <?php echo $Obj->getFlashData("signin_error"); ?>
                
                <input type="hidden" name="admin" value="login" required/>
                <input class="text-box" type="email" name="email" id="semail" placeholder="Email" required/>
                <br/><span id="siemail"></span>
                       
                <input class="text-box" type="password" name="password" id="spass" placeholder="Password" id="pass" required />
                <br/><span id="sipass"></span>
                        
                <br/><input class="button button-large" type="submit" value="SignIn" />
            </form>
        </div>
    </div>

</div>

<?
include "resources/layout/footer.php";
?>