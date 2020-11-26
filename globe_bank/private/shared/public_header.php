<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "<?php echo url_for('/stylesheets/public.css')  ?>">
    <title>Globe Bank
      <?php
        if(isset($page_title)){
          echo '-' . h($page_title);
        }
        if(isset($preview) && $preview){
          echo "[Preview Mode]";
        }
      ?>
    </title>
</head>
<body>
    <header>
      <h1>
        <a href="<?php echo url_for('/index.php'); ?>">
          <img src="<?php echo url_for('/images/gbi_logo.png') ?>" alt="Globe Bank International" width="298" height="71">
        </a>
      </h1>
    </header>
