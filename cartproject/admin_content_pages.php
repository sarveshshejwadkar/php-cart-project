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

if($_POST != null){
    if(count($_POST) == 1){
        $Obj->addCategory($_POST);  
    }
}

$pages = $Obj->getAllContentPages();

if(isset($_GET['delete'])){
    $Obj->deleteContentPageById($_GET['delete']);
}
?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
        <h3>Content Pages</h3>
        <div>
            <a href="admin_content_pages_add.php">Add New Page</a>
        </div>
        <br /><br /><hr />
        <div>
            <span id="catname"><?php echo $Obj->getFlashData("cerror"); ?></span>
            <table width="100%">
                <?php 
                foreach($pages as $page){
                ?>
                <tr>
                    <td style="width: 80%;"><a href="admin_content_pages_view.php?pid=<?php echo $page['id']; ?>"><?php echo $page['title']; ?></a><hr /></td>
                    <td><a href="admin_content_pages_edit.php?pid=<?php echo $page['id']; ?>">Edit</a><hr /></td>
                    <td><a href="admin_content_pages.php?delete=<?php echo $page['id']; ?>">Delete</a><hr /></td>
                </tr>
                
                <?php
                    }
                ?>
            </table>
        </div>
    </div>
</div>
<?
include "resources/layout/footer.php";
?>