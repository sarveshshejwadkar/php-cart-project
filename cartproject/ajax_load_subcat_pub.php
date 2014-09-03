<?php 
include "classes/product_pub.php";
$Obj = new ProductPub();
$w_data = array(
     'category_id' => $_GET['cat_id']
);
?>

Sub Category : 
<select name="subcat" id="subcat" class="select" required>
<?php 
	$sub_category = $Obj->getSubCategoryByCategoryID("*", $w_data, "sub_categories"); 
	foreach ($sub_category as $row){
?> 
      	<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option> 
<?php                   
    }
?>
</select>