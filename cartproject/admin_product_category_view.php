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
    if(count($_POST) == 2){
        $Obj->addSubCategory($_POST);  
    }
}

if(isset($_GET['delete'])){
    $Obj->deleteSubCategoryById($_GET['delete']);
    header("Location: admin_product_category_view.php?catid=".$_GET['cid']."");
}elseif(isset($_GET['catid'])){
    $sub_categories = $Obj->getAllSubCategories($_GET['catid']);
    $category = $Obj->getCategoryById($_GET['catid']);
    if($category == null){
        header("Location: admin_product_category.php");
    }
}else{
    header("Location: admin_product_category.php");
}
?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
        <p><b><a href="admin_product_category.php">Category</a> >  <?php echo $category[0]['category_name']; ?></b></p><br />
        <div>
            <form method="POST">
                <table>
                    <tr>
                        <td>Sub Category : </td>
                        <td>
                            <input type="hidden" name="category_id" value="<?php echo $_GET['catid']; ?>" required />
                            <input type="text" name="subcategoryname" required />
                            <span id="catname"><?php echo $Obj->getFlashData("cerror"); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="button" value="Add" /></td>
                    </tr>
                </table>   
            </form>
        </div>
        
        <div>
            <table width="100%">
                <?php 
                foreach($sub_categories as $category){
                ?>
                <tr>
                    <td style="width: 80%;">
                        <a href="admin_product_add.php?scat_id=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a>
                        <hr />
                    </td>
                    <td><a href="admin_product_subcategory_edit.php?scid=<?php echo $category['id']; ?>">Edit</a><hr /></td>
                    <td><a href="admin_product_category_view.php?delete=<?php echo $category['id']; ?>&cid=<?php echo $_GET['catid']; ?>">Delete</a><hr /></td>
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