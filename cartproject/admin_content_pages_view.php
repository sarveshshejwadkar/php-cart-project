<?php
include "classes/content_page.php";

$Obj = new ContentPage();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');

include "resources/layout/header.php";

if($_SESSION['isAdmin'] != true){
    header("Location: index.php");
}

if($_GET['pid'] == null){
    header("Location: admin_content_pages.php");
}

$page_content = $Obj->getContentPageById($_GET['pid']);

if($page_content == null){
    header("Location: admin_content_pages.php");
}
?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
        <h3>Content Pages</h3>
        <h4>Title : <?php echo $page_content[0]['title']; ?></h4>
        <div>
            <?php echo $page_content[0]['content']; ?>
        </div>
        <div>
            <a href="admin_content_pages.php?delete=<?php echo $page_content[0]['id']; ?>">Delete</a>
            <a href="admin_content_pages_edit.php?pid=<?php echo $page_content[0]['id']; ?>">Edit</a>
        </div>
    </div>
</div>
<?
include "resources/layout/footer.php";
?>