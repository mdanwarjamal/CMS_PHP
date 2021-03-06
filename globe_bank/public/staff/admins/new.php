<?php
  require_once('../../../private/initialize.php');
  require_login();
  // if(!isset($_GET['id'])){
  //   redirect_to(url_for('/staff/admins/new.php'));
  // }
  // $id = $_GET['id'];
  // $admin_set = find_all_admins();
  // $admin_count = mysqli_num_rows($admin_set) + 1;
  // mysqli_free_result($admin_set);

  $admin =[];

  $admin = [];
  $admin['id'] = '';
  $admin['first_name'] = '';
  $admin['last_name'] =  '';
  $admin['email'] = '';
  $admin['username'] = '';
  $admin['hashed_password'] = '';
  $admin['confirm_password'] = '';
  if(is_post_request()){
    $admin['first_name'] = $_POST['first_name'] ?? '';
    $admin['last_name'] = $_POST['last_name'] ?? '';
    $admin['email'] = $_POST['email'] ?? '';
    $admin['username'] = $_POST['username'] ?? '';
    $admin['hashed_password'] = $_POST['hashed_password'] ?? '';
    $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

    $result = insert_admin($admin);
    if($result === true){
      $new_id = mysqli_insert_id($db);
      $_SESSION['status'] = 'Successfully created a new admin';
      redirect_to(url_for('/staff/admins/show?id=' . $new_id));
    }
    else{
      $errors = $result;
    }


  }

?>

<?php $page_title = 'Create Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin new">
    <h1>Create Admin</h1>
    <?php echo display_errors($errors); ?>
    <form action="<?php echo url_for('/staff/admins/new.php');?>" method="post">
      <dl>
        <dt>First Name</dt>
        <dd><input type="text" name="first_name" value="<?php echo h($admin['first_name']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Last Name</dt>
        <dd><input type="text" name="last_name" value="<?php echo h($admin['last_name']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><input type="email" name="email" value="<?php echo h($admin['email']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo h($admin['username']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Enter Password</dt>
        <dd><input type="password" name="hashed_password" value="<?php echo h($admin['hashed_password']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Confirm Password</dt>
        <dd><input type="password" name="confirm_password" value="<?php echo h($admin['hashed_password']) ?>" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Admin" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
