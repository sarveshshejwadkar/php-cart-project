<?php
include "classes/content_page.php";

$Obj = new ContentPage();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('ckeditor/ckeditor.js');

include "resources/layout/header.php";

if($_SESSION['isAdmin'] != true){
    header("Location: index.php");
}

if($_POST != null){
    if(count($_POST) == 2){
        $Obj->addContentPage($_POST);  
    }
}
?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
        <h3>Content Pages</h3>
        <h4>Add New Content Page</h4>
        <div>
            <span id="catname"><?php echo $Obj->getFlashData("cerror"); ?></span>
            <table width="100%">
               <form method="POST">
                    <table>
                        <tr>
                            <td>Title : </td>
                            <td><input type="text" name="title" id="title" size="95" maxlength="50" placeholder="Title (Max 50)" required/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><textarea name="content" id="content" rows="20" cols="80"></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="button" value="Post Page" /></td>
                        </tr>
                    </table>
                </form>
            </table>
        </div>  
    </div>
</div>

<?
include "resources/layout/footer.php";
?>
<script>
    CKEDITOR.replace( 'content' );
</script>