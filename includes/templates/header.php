<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8" />
        <title><?php echo getTitle() ?></title>
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>backend.css" />
    </head>
    <body>
    <div class="upper-bar">
        Upper Bar
    </div>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Homepage</a>
            </div>
            <div class="collapse navbar-collapse" id="app-nav">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    foreach (getCat() as $cat) {
                        echo '<li><a href="categories.php?pageid='. $cat['ID'] .'">'. $cat['Name'] . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>