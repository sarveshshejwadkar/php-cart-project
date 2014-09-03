<?php
include "classes/category_pub.php";

$Category = new CategoryPub();

$sub_categories = $Category->getAllSubCategories($_GET['catid']);

echo "<div class='content'>";
foreach($sub_categories as $cat){
	
    echo "<span class='tag'>".$cat['name']."</span>";
}
echo "</div>";
?>