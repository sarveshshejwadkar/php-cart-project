<?php
include "classes/brand.php";

$Obj = new Brand();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');

include "resources/layout/header.php";

if($_SESSION['isAdmin'] != true){
    header("Location: index.php");
}

if($_POST != null){
    if(count($_POST) == 1){
        $Obj->addBrand($_POST);  
    }
}

$brands = $Obj->getAllBrands();

if(isset($_GET['delete'])){
    $Obj->deleteBrandById($_GET['delete']);
}
?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
        <h3>Brands</h3>
        <div>
            <form method="POST">
                <table>
                    <tr>
                        <td>Brand Name : </td>
                        <td><input type="text" name="brandname" required />
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
                foreach($brands as $brand){
                ?>
                <tr>
                    <td style="width: 80%;"><?php echo $brand['name']; ?><hr /></td>
                    <td><a href="admin_brand_edit.php?bid=<?php echo $brand['id']; ?>">Edit</a><hr /></td>
                    <td><a href="admin_brand.php?delete=<?php echo $brand['id']; ?>" >Delete</a><hr /></td>
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