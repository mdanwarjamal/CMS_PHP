<?php $page_title = $page_title ?? 'Staff Area' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "<?php echo url_for('/stylesheets/staff.css')  ?>">
    <title>GBI - <?php echo h($page_title); ?></title>
</head>
<body>
    <header>
      <h1>GBI Staff Area</h1>
    </header>
    <nav>
        <ul>
            <li>
              User: <?php echo $_SESSION['username']??''; ?>
            </li>
            <li>
                <a href="<?php echo url_for('/staff/index.php')  ?>">Menu</a>
            </li>
            
            <?php if(is_logged_in()): ?>
            <li>
                <a href="<?php echo url_for('/staff/logout.php')  ?>">Logout</a>
            </li>
          <?php endif; ?>
        </ul>
    </nav>
    <?php echo display_session_message(); ?>
