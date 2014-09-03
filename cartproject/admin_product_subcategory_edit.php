<?php
include "classes/category.php";

$Obj = new Category();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');

include "resources/layout/header.php";

if($_SESSION['isAdmin'] != true){
    header("Location: index.php");
}

if($_POST != null){
    if(count($_POST) == 3){
        $Obj->editSubCategory($_POST);  
    }
}

if(isset($_GET['scid'])){
    $category = $Obj->getSubCategoryById($_GET['scid']);
}else{
    header("Location: admin_product_category.php");
}
?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
        <p><b>Edit Sub categories</b></p>
        <div>
            <form method="POST">
                <table>
                    <tr>
                        <td>Sub Category : </td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $category[0]['id']; ?>" required />
                            <input type="hidden" name="catid" value="<?php echo $category[0]['category_id']; ?>" required />
                            <input type="text" name="subcategoryname" value="<?php echo $category[0]['name']; ?>" required />
                            <span id="catname"><?php echo $Obj->getFlashData("cerror"); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="button" value="Edit" /></td>
                    </tr>
                </table>   
            </form>
        </div>
    </div>
</div>

<?
include "resources/layout/footer.php";
?>