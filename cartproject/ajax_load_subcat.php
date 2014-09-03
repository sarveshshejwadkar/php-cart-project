<?php 
    include "classes/product.php";
    $Obj = new Products();
    
    $cat = $_POST['cat'];
    $tmp=array(
        'category_id' => $cat
    );
?>

<select name="subcategory" id="subcategory" class="select" >
<?php 
	$sub_category = $Obj->getSubCategoryByCategoryID("*",$tmp,"sub_categories"); 
	foreach ($sub_category as $row){
?> 
      	<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option> 
<?php                   
    }
?>
</select>          
                    

