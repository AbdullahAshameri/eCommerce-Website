<?php include 'init.php'; ?>

<div class="container">
    <h1 class="text-center"><?php echo str_replace('-', ' ', $_GET['pagename']); ?></h1>
    <?php 
        foreach(getItem($_GET['pageid']) as $item) {

            echo $item['Name'] . '<br>';

        }
    ?>
</div>

<?php include $tpl . 'footer.php'; ?>