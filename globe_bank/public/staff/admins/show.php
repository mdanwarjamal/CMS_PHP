<?php require_once '../../../private/initialize.php'; ?>
<?php
  require_login();
  $id = $_GET['id']??'1';
  $admin = find_admin_by_id($id);
?>
<?php $page_title = 'Show Admins' ?>
<?php require_once SHARED_PATH . '/staff_header.php'; ?>
<div id="content">
  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>
  <div class="admin show">
    <!-- <div class="success" >
      <h3 style="color:green;"><?php //echo $_SESSION['status']??''; unset($_SESSION['status']); ?></h3>
    </div> -->
    <h1><?php echo h($admin['first_name'] . " " . $admin['last_name']); ?></h1>
    <div >
      <dl>
        <dt>ID</dt>
        <dd><?php echo h($admin['id']); ?></dd>
      </dl>
      <dl>
        <dt>First Name</dt>
        <dd><?php echo h($admin['first_name']); ?></dd>
      </dl>
      <dl>
        <dt>Last Name</dt>
        <dd><?php echo h($admin['last_name']); ?></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><?php echo h($admin['email']); ?></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><?php echo h($admin['username']); ?></dd>
      </dl>
    </div>
  </div>

</div>
<?php require_once SHARED_PATH . '/staff_footer.php'; ?>
