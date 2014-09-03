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
        $Obj->editCategory($_POST);  
    }
}

$categories = $Obj->getAllCategories();

if(isset($_GET['cid'])){
    $ca = $Obj->getCategoryById($_GET['cid']);
}else{
    header("Location: admin_product_category.php");
}
?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
        <h3>Edit Category</h3>
        <div>
            <form method="POST">
                <table>
                    <tr>
                        <td>Category Name : </td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $ca[0]['id']; ?>" required />
                            <input type="text" name="categoryname" value="<?php echo $ca[0]['category_name']; ?>" required />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="button" value="Edit" /></td>
                    </tr>
                </table>   
            </form>
        </div>
        
        <div>
            <table width="100%">
                <?php 
                foreach($categories as $category){
                ?>
                <tr>
                    <td style="width: 80%;"><?php echo $category['category_name']; ?><hr /></td>
                    <td><a href="admin_product_category_edit.php?cid=<?php echo $category['id']; ?>">Edit</a><hr /></td>
                    <td><a href="admin_product_category.php?delete=<?php echo $category['id']; ?>">Delete</a><hr /></td>
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