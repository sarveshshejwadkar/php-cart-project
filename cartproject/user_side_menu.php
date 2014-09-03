<div class="left_home">
	<div>
		<div class="category">Categories</div>
		<?php
		foreach($categories as $cat){
		?>
            <div class="item">
                <a href="user_category.php?cat_id=<?php echo $cat['id']; ?>"><?php echo $cat['category_name']; ?></a>
            </div>  
        <?php
         }
         ?>
	</div>
        
	<div>
		<div class="category">Brands</div>
            <div class="content">
            	<?php 
                	foreach($brands as $brand){
	            ?>
                <span class="tag"><?php echo $brand['name']; ?></span>
	            <?php
	                }
	            ?>
            </div>
    </div>
</div>