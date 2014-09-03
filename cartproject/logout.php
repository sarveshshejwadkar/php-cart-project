<?php
include "classes/users.php";
$Obj = new Users();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');

include "resources/layout/header.php";
$Obj->logOffUser();
 header("Location: index.php");
?>

<div class="main">
    Loggedout
    

</div>




<?
include "resources/layout/footer.php";
?>
