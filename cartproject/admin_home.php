<?php
include "classes/admin.php";

$Obj = new Admin();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('index.js');

include "resources/layout/header.php";

if($_SESSION['isAdmin'] != true){
    header("Location: index.php");
}
?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
        <h1>Welcome to PHP Cart Admin</h1>
        
    </div>
</div>

<?
include "resources/layout/footer.php";
?>