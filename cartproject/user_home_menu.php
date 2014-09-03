<div class="title">
    <h2>PHP Cart</h2>
</div>
<div class="header">
    <a href="user_home.php" class="headertab">Home</a>
    <a href="" class="headertab">My Cart</a>
    <a href="user_contact.php" class="headertab">Contact Us</a>
    <?php 
    if($Obj->isLoggedIn() == true){
    ?>
        <a id="user" class="headertab"><?php echo $user_data[0]['first_name']; ?></a>
    <?php    
    }else{
    ?>
        <a href="index.php" class="headertab">SignIn</a>
    <?php
    }
    ?>
</div>
<div id="user_options" class="content">
    <a href="user_account.php" class="tag">Profile</a>
    <a class="tag">My Orders</a>
    <a href="logout.php" class="tag">Logout</a>
</div>
<div class="blue">
    <form method="GET" action="user_home_products.php"> 
        <div class="content">
            <input type="text" name="search" class="search" placeholder="Search products" />
            <input type="submit" class="button" value="Search" />
            <input type="button" class="button" onClick="parent.location='user_advance_search.php'" value="Advance Search" />
        </div>
    </form>
</div>