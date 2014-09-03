<div class="base">
    <div class="content">
        <h4>Pages</h4>
        <?php
            foreach($pages as $p){
        ?>
                <a class="white-text" href="user_home_pages.php?page=<?php echo $p['id']; ?>"><?php echo $p['title']; ?></a>
                <br />
        <?php
            }
        ?>
    </div>
</div>